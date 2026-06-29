<?php

/** Goal: Full-page chatbot Livewire component using Interactions API via async Job, Caller: Route chatbot.index, Deps: ProcessChatMessage, ChatConversation, ChatMessage */

namespace App\Livewire\Chatbot;

use App\Jobs\ProcessChatMessage;
use App\Models\Chatbot\ChatConversation;
use App\Models\Chatbot\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('dashboard.layoutsDash.livewire.app')]
#[Title('AI Chatbot')]
class Chatbot extends Component
{
    public string $newMessage = '';

    public ?int $activeConversationId = null;

    public bool $isProcessing = false;

    public ?int $processingStartedAt = null;

    public string $searchConversation = '';

    public string $persona = 'professional';

    public function mount(): void
    {
        $latest = ChatConversation::query()
            ->where('user_id', Auth::id())
            ->latest('updated_at')
            ->first();

        if ($latest) {
            $this->activeConversationId = $latest->id;
            $this->persona = $latest->persona ?? 'professional';
        }
    }

    public function checkProcessingStatus(): void
    {
        if (! $this->isProcessing || ! $this->activeConversationId) {
            return;
        }

        // Check if there's a model response after the last user message
        $lastMessage = ChatMessage::query()
            ->where('conversation_id', $this->activeConversationId)
            ->orderByDesc('created_at')
            ->first();

        if ($lastMessage && $lastMessage->role === 'model') {
            $this->isProcessing = false;
            $this->processingStartedAt = null;
            $this->dispatch('message-sent');
            return;
        }

        // Timeout check (90 seconds — aligned with job $timeout = 120)
        if ($this->processingStartedAt && (time() - $this->processingStartedAt) > 90) {
            $this->isProcessing = false;
            $this->processingStartedAt = null;

            ChatMessage::create([
                'conversation_id' => $this->activeConversationId,
                'role' => 'model',
                'content' => '⚠️ **Waktu tunggu habis.** Koneksi ke AI lambat atau terputus.',
                'status' => 'failed',
            ]);

            $this->dispatch('message-sent');
        }
    }

    public function createConversation(): void
    {
        $this->authorizeAccess();

        $conversation = ChatConversation::create([
            'user_id' => Auth::id(),
            'title' => null,
            'persona' => $this->persona,
        ]);

        $this->activeConversationId = $conversation->id;
        $this->newMessage = '';
        $this->isProcessing = false;
    }

    public function setPersona(string $persona): void
    {
        $this->authorizeAccess();

        $validPersonas = ['professional', 'cheerful', 'strict'];
        if (! in_array($persona, $validPersonas, true)) {
            return;
        }

        $this->persona = $persona;

        if ($this->activeConversationId) {
            ChatConversation::query()
                ->where('user_id', Auth::id())
                ->where('id', $this->activeConversationId)
                ->update(['persona' => $persona]);
        }
    }

    public function selectConversation(int $id): void
    {
        $this->authorizeAccess();

        $conversation = ChatConversation::query()
            ->where('user_id', Auth::id())
            ->find($id);

        if (! $conversation) {
            abort(404);
        }

        $this->activeConversationId = $conversation->id;
        $this->persona = $conversation->persona ?? 'professional';
        $this->newMessage = '';
        $this->isProcessing = false;
    }

    public function deleteConversation(int $id): void
    {
        $this->authorizeAccess();

        $conversation = ChatConversation::query()
            ->where('user_id', Auth::id())
            ->find($id);

        if (! $conversation) {
            abort(404);
        }

        $conversation->delete();

        if ($this->activeConversationId === $id) {
            $next = ChatConversation::query()
                ->where('user_id', Auth::id())
                ->latest('updated_at')
                ->first();

            $this->activeConversationId = $next?->id;
            $this->persona = $next?->persona ?? 'professional';
            $this->isProcessing = false;
        }
    }

    public function sendMessage(): void
    {
        $this->authorizeAccess();

        $message = trim($this->newMessage);
        if (empty($message) || $this->isProcessing) {
            return;
        }

        // Clear textarea immediately so the user sees their message
        $this->newMessage = '';

        // Auto-create conversation if none
        if (! $this->activeConversationId) {
            $conversation = ChatConversation::create([
                'user_id' => Auth::id(),
                'title' => null,
                'persona' => $this->persona,
            ]);
            $this->activeConversationId = $conversation->id;
        } else {
            $conversation = ChatConversation::query()
                ->where('user_id', Auth::id())
                ->findOrFail($this->activeConversationId);
        }

        // Save user message immediately so it shows in the UI
        $userMessage = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $message,
            'status' => 'done',
        ]);

        // Mark as processing and dispatch job
        $this->isProcessing = true;
        $this->processingStartedAt = time();
        $this->dispatch('message-sent');

        ProcessChatMessage::dispatch(
            $conversation->id,
            $userMessage->id,
            $message,
            Auth::id(),
        );
    }

    public function retryMessage(int $modelMessageId): void
    {
        $this->authorizeAccess();

        if ($this->isProcessing) {
            return;
        }

        $modelMessage = ChatMessage::query()
            ->where('conversation_id', $this->activeConversationId)
            ->findOrFail($modelMessageId);

        if ($modelMessage->role !== 'model') {
            return;
        }

        // Find preceding user message
        $userMessage = ChatMessage::query()
            ->where('conversation_id', $this->activeConversationId)
            ->where('role', 'user')
            ->where('id', '<', $modelMessage->id)
            ->orderByDesc('id')
            ->first();

        if (! $userMessage) {
            return;
        }

        // Delete the failed model message so it disappears
        $modelMessage->delete();

        // Mark as processing and dispatch job
        $this->isProcessing = true;
        $this->processingStartedAt = time();
        $this->dispatch('message-sent');

        ProcessChatMessage::dispatch(
            $this->activeConversationId,
            $userMessage->id,
            $userMessage->content,
            Auth::id(),
        );
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, ChatConversation> */
    public function getConversationsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        $query = ChatConversation::query()
            ->where('user_id', Auth::id())
            ->latest('updated_at');

        if (! empty($this->searchConversation)) {
            $query->where('title', 'like', "%{$this->searchConversation}%");
        }

        return $query->get();
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, ChatMessage> */
    public function getMessagesProperty(): \Illuminate\Database\Eloquent\Collection
    {
        if (! $this->activeConversationId) {
            return new \Illuminate\Database\Eloquent\Collection;
        }

        return ChatMessage::query()
            ->where('conversation_id', $this->activeConversationId)
            ->orderBy('created_at')
            ->get();
    }

    private function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can('ai-chatbot'), 403);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.chatbot.chatbot');
    }
}
