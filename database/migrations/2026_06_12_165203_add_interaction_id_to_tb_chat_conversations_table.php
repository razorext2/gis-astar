<?php

/** Goal: Add interaction_id column to tb_chat_conversations table, Caller: Migration, Deps: tb_chat_conversations table */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->string('interaction_id', 100)->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->dropColumn('interaction_id');
        });
    }
};
