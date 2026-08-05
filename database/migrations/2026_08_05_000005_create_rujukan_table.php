<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rujukan', function (Blueprint $table) {
            $table->id('id_rujukan');
            $table->string('no_rujukan', 30)->unique();
            $table->foreignId('id_pasien')->constrained('pasien', 'id_pasien');
            $table->foreignId('id_rumah_sakit')->constrained('rumah_sakit_rujukan', 'id_rumah_sakit');
            $table->foreignId('id_user')->constrained('users');
            $table->datetime('tanggal_rujukan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rujukan');
    }
};
