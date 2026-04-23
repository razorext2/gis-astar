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
        Schema::table('tb_jabatan', function (Blueprint $table) {
            $table->foreignId('supervisor_id')
                ->nullable()
                ->after('penempatan')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('tb_placement', function (Blueprint $table) {
            $table->foreignId('manager_id')
                ->nullable()
                ->after('kode_penempatan')
                ->constrained('users')
                ->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->date('join_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('join_date');
        });

        Schema::table('tb_placement', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });

        Schema::table('tb_jabatan', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn('supervisor_id');
        });
    }
};
