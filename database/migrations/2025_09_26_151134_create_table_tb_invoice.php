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
        Schema::create('tb_invoice', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nomor_btt', 50)->nullable();
            $table->string('tgl_btt', 50)->nullable()->comment('tanggal btt dibuat');
            $table->string('tgl_invoice', 50)->nullable()->comment('tanggal invoice dibuat');
            $table->string('no_piutang', 64)->nullable();
            $table->string('no_penjualan', 64)->nullable();
            $table->string('no_faktur_pajak', 64)->nullable();
            $table->string('nama_customer', 128)->nullable()->comment('nama perusahaan/customer');
            $table->string('tipe_invoice', 50)->comment('dalam kota/luar kota');
            $table->string('status_pengiriman', 50)->nullable()->comment('belum/sudah dikirim');
            $table->string('status_awal', 200)->comment('status awal invoice saat btt baru ditambah');
            $table->string('status_terbaru', 200)->comment('status terbaru invoice');
            $table->integer('added_by')->comment('user yang menambahkan invoice');
            $table->integer('latest_update_by')->comment('user yang update terakhir');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_invoice');
    }
};
