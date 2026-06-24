<?php

/** Goal: Add reset tracking fields to tb_leave_balances, Caller: migration, Deps: tb_leave_balances, users */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_leave_balances', function (Blueprint $table) {
            $table->timestamp('reset_at')->nullable()->after('used_quota');
            $table->foreignId('reset_by')->nullable()->after('reset_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tb_leave_balances', function (Blueprint $table) {
            $table->dropForeign(['reset_by']);
            $table->dropColumn(['reset_at', 'reset_by']);
        });
    }
};
