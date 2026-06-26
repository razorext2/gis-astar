<?php

/** Goal: Chat message model, Caller: Chatbot Livewire & ProcessChatMessage Job, Deps: ChatConversation */

namespace App\Models\Chatbot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $table = 'tb_chat_messages';

    protected $fillable = [
        'conversation_id',
        'role',
        'content',
        'status',
    ];
}

