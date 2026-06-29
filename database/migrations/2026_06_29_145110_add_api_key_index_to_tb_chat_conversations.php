<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->tinyInteger('api_key_index')->nullable()->after('interaction_id')
                ->comment('Index of the API key used for this conversation (for round-robin rotation)');
        });
    }

    public function down(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->dropColumn('api_key_index');
        });
    }
};
