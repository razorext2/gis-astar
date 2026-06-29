<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->string('persona', 20)->default('professional')->after('api_key_index')
                ->comment('AI persona: professional, cheerful, strict');
        });
    }

    public function down(): void
    {
        Schema::table('tb_chat_conversations', function (Blueprint $table) {
            $table->dropColumn('persona');
        });
    }
};
