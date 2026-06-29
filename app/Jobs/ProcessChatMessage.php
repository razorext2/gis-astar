<?php

/** Goal: Async AI processing job with user permission context, Caller: Chatbot::sendMessage, Deps: GeminiService, ChatMessage, ChatConversation, User */

namespace App\Jobs;

use App\Models\Chatbot\ChatConversation;
use App\Models\Chatbot\ChatMessage;
use App\Models\User;
use App\Services\Chatbot\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessChatMessage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public int $timeout = 120;

    public function __construct(
        public readonly int $conversationId,
        public readonly int $userMessageId,
        public readonly string $userMessage,
        public readonly int $userId,
    ) {}

    public function handle(): void
    {
        $conversation = ChatConversation::find($this->conversationId);

        if (! $conversation) {
            return;
        }

        // Load user with roles and permissions
        $user = User::with(['roles', 'permissions'])->find($this->userId);
        $userContext = $this->buildUserContext($user);

        // Build history (all messages before the current user message)
        $history = ChatMessage::query()
            ->where('conversation_id', $this->conversationId)
            ->where('id', '<', $this->userMessageId)
            ->orderBy('created_at')
            ->get()
            ->map(fn (ChatMessage $m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        // Auto-generate title from first user message if none
        $service = new GeminiService;

        if (! $conversation->title) {
            $conversation->update(['title' => $service->generateTitle($this->userMessage)]);
        }

        // Send to Gemini with user context — pass pinned key index to maintain conversation continuity
        $result = $service->sendMessage($history, $this->userMessage, $conversation->interaction_id, $userContext, $conversation->api_key_index, $conversation->persona ?? 'professional');

        $status = 'done';
        if ($result['error']) {
            $aiContent = "⚠️ **Error:** {$result['error']}";
            $status = 'failed';
        } else {
            $aiContent = $result['content'];
            $updates = [];

            if (! empty($result['interaction_id'])) {
                $updates['interaction_id'] = $result['interaction_id'];
            }

            // Simpan key index yang dipakai jika conversation belum punya (pesan pertama)
            if ($conversation->api_key_index === null && $result['api_key_index'] !== null) {
                $updates['api_key_index'] = $result['api_key_index'];
            }

            if (! empty($updates)) {
                $conversation->update($updates);
            }
        }

        // Save AI response
        ChatMessage::create([
            'conversation_id' => $this->conversationId,
            'role' => 'model',
            'content' => $aiContent,
            'status' => $status,
        ]);

        // Update conversation timestamp
        $conversation->touch();
    }

    public function failed(\Throwable $exception): void
    {
        // Save AI error response if not already saved
        $lastMessage = ChatMessage::query()
            ->where('conversation_id', $this->conversationId)
            ->orderByDesc('id')
            ->first();

        if ($lastMessage && $lastMessage->role !== 'model') {
            ChatMessage::create([
                'conversation_id' => $this->conversationId,
                'role' => 'model',
                'content' => "⚠️ **Error:** Pekerjaan gagal diproses. {$exception->getMessage()}",
                'status' => 'failed',
            ]);
        }
    }

    /**
     * @return array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}
     */
    private function buildUserContext(?User $user): array
    {
        if (! $user) {
            return ['id' => 0, 'name' => 'Unknown', 'kode_pegawai' => null, 'roles' => [], 'permissions' => []];
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'kode_pegawai' => $user->kode_pegawai,
            'roles' => $user->roles->pluck('name')->toArray(),
            'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
        ];
    }
}
