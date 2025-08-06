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
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->tinyInteger('position_status')
                ->default(3)
                ->after('latitude')
                ->comment('1 = onroute(yellow), 2 = standby(green), 3 = onsite(red), 0 = unknown(gray)');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->tinyInteger('position_status')
                ->default(3)
                ->after('latitude')
                ->comment('1 = onroute(yellow), 2 = standby(green), 3 = onsite(red), 0 = unknown(gray)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->dropColumn('position_status');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->dropColumn('position_status');
        });
    }
};
