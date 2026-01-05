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
        Schema::create('tb_packing_list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_barang');
            $table->string('nama_part', 200)->index();
            $table->integer('jumlah')->default(0);
            $table->string('satuan', 20);
            $table->string('pack', 200)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_packing_list');
    }
};
