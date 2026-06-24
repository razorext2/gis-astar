<?php

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
        Schema::table('tb_announcements', function (Blueprint $table) {
            $table->string('file_path')->nullable();
            $table->string('target_type')->default('all');
            $table->json('target_roles')->nullable();
            $table->json('target_users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_announcements', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'target_type', 'target_roles', 'target_users']);
        });
    }
};
