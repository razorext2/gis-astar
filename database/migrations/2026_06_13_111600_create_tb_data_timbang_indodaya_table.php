<?php

/** Goal: Create tb_data_timbang_indodaya table, Caller: DB Migrations, Deps: none */

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
        Schema::create('tb_data_timbang_indodaya', function (Blueprint $table) {
            $table->id();
            $table->string('no_seri')->nullable();
            $table->string('no_polisi')->nullable();
            $table->string('nm_relasi')->nullable();
            $table->string('nm_barang')->nullable();
            $table->string('nm_supir')->nullable();
            $table->string('referensi')->nullable();
            $table->float('timbang1')->nullable()->default(0);
            $table->float('timbang2')->nullable()->default(0);
            $table->float('potongan')->nullable()->default(0);
            $table->float('netto')->nullable()->default(0);
            $table->date('tanggal_m')->nullable();
            $table->date('tanggal_k')->nullable();
            $table->time('waktu1')->nullable();
            $table->time('waktu2')->nullable();
            $table->string('penimbang')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_timbang_indodaya');
    }
};

