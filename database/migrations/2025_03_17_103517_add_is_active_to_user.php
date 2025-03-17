<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->datetime('last_login')->nullable()->after('remember_token');
            $table->boolean('is_active')->default(false)->after('last_login');
            $table->datetime('deactivation_at')->nullable()->after('is_active');
            $table->string('deactivation_reason', 100)->nullable()->after('deactivation_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('deactivation_at');
            $table->dropColumn('deactivation_reason');
            $table->dropColumn('last_login');
        });
    }
};
