<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titik_rute', function (Blueprint $table) {
            $table->id('id_titik');
            $table->foreignId('id_rute')->constrained('rute', 'id_rute')->cascadeOnDelete();
            $table->unsignedInteger('urutan');
            $table->string('nama_lokasi')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('tipe', ['awal', 'perantara', 'tujuan']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titik_rute');
    }
};
