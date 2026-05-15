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
        Schema::table('tb_leave_request_histories', function (Blueprint $table) {
            $table->string('status_from', 20)->nullable()->after('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_leave_request_histories', function (Blueprint $table) {
            $table->dropColumn('status_from');
        });
    }
};
