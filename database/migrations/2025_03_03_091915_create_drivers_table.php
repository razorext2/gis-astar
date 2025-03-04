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
        Schema::create('tb_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pegawai', 12)->index()->nullable(false);
            $table->string('title', 32)->nullable(false)->comment('Judul laporan');
            $table->string('lokasi', 128)->nullable(false)->comment('Lokasi kunjungan');
            $table->text('keterangan')->nullable(false)->comment('Keterangan laporan');
            $table->string('longitude', 32);
            $table->string('latitude', 32);
            $table->boolean('status')->default(0);
            $table->string('notes', 128)->nullable();
            $table->string('validate_by', 12)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
