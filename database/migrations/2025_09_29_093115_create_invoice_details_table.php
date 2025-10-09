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
        Schema::create('tb_invoice_detail', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('no_faktur_pajak', 64)->comment('no faktur pajak dari tb_invoice');
            $table->string('status_btt', 20)->nullable()->comment('ada/tidak di BSI (sudah dibuat atau blm)');
            $table->string('status')->comment('status dari invoice');
            $table->json('informasi_pengiriman')->comment('informasi pengiriman, array[tujuan, jasa_kirim, no_resi]')->nullable();
            $table->integer('added_by')->comment('user yang menambahkan invoice');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_invoice_detail');
    }
};
