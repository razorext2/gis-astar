<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rute', function (Blueprint $table) {
            $table->id('id_rute');
            $table->string('nama_rute');
            $table->decimal('jarak_total', 8, 3)->default(0); // km
            $table->integer('waktu_total')->default(0);       // menit
            $table->string('algoritma', 20)->default('astar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rute');
    }
};
