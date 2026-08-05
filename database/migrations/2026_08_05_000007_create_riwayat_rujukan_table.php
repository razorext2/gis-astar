<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_rujukan', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->foreignId('id_rujukan')->constrained('rujukan', 'id_rujukan')->cascadeOnDelete();
            $table->string('status_lama', 20)->nullable();
            $table->string('status_baru', 20);
            $table->text('keterangan')->nullable();
            $table->foreignId('diubah_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->datetime('waktu_perubahan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_rujukan');
    }
};
