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
            $table->string('timezone')
                ->nullable()
                ->after('waktuori');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->string('timezone')
                ->nullable()
                ->after('waktuori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
};
