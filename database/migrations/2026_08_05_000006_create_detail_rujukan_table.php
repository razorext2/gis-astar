<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_rujukan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_rujukan')->constrained('rujukan', 'id_rujukan')->cascadeOnDelete();
            $table->foreignId('id_rute')->constrained('rute', 'id_rute');
            $table->decimal('jarak', 8, 3)->default(0);          // km
            $table->integer('waktu_tempuh')->default(0);          // menit
            $table->decimal('estimasi_biaya', 12, 2)->default(0); // rupiah
            $table->string('metode', 20)->default('otomatis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_rujukan');
    }
};
