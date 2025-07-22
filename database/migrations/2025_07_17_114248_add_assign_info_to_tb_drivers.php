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
        Schema::table('tb_drivers', function (Blueprint $table) {
            $table->date('assign_date')
                ->nullable()
                ->comment('Tanggal Assign')
                ->after('revised_by');
            $table->foreignId('assign_by')
                ->nullable()
                ->constrained('users', 'id')
                ->nullOnDelete()
                ->comment('Assign By (userid)')
                ->after('assign_date');
            // ubah jadi nullable semua
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
            $table->text('keterangan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_drivers', function (Blueprint $table) {
            $table->dropForeign(['assign_by']); // Hapus FK dulu
            $table->dropColumn('assign_date');
            $table->dropColumn('assign_by');
        });
    }
};
