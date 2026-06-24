<?php

/** Goal: Create chat messages table for storing conversation messages, Caller: Migration, Deps: tb_chat_conversations */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('tb_chat_conversations')->cascadeOnDelete();
            $table->enum('role', ['user', 'model']);
            $table->longText('content');
            $table->timestamps();

            $table->index(['conversation_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_chat_messages');
    }
};
