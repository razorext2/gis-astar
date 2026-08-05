<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rumah_sakit_rujukan', function (Blueprint $table) {
            $table->id('id_rumah_sakit');
            $table->string('nama_rumah_sakit');
            $table->text('alamat');
            $table->string('no_telepon', 20)->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            // layanan_operasi disimpan sebagai JSON array: ["ICU","IGD","Bedah"]
            $table->text('layanan_operasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rumah_sakit_rujukan');
    }
};
