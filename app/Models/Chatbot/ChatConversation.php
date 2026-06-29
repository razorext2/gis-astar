<?php

/** Goal: Chat conversation model with interaction_id field, Caller: Chatbot Livewire, Deps: User, ChatMessage */

namespace App\Models\Chatbot;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatConversation extends Model
{
    use SoftDeletes;

    protected $table = 'tb_chat_conversations';

    protected $fillable = [
        'user_id',
        'title',
        'interaction_id',
        'api_key_index',
        'persona',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    /**
     * @return HasMany<ChatMessage>
     */
    public function latestMessage(): HasMany
    {
        return $this->messages()->latest()->limit(1);
    }
}
