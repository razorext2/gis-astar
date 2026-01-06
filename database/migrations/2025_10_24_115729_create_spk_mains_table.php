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
        Schema::create('tb_spk', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();
            $table->string('nomor_order', 50)
                ->unique();
            $table->string('tipe_tagihan', 50)
                ->index()
                ->comment('tipe tagihan: idc non, idc ppn, idy ppn');
            $table->boolean('status_nomor_tagihan')
                ->default(false)
                ->comment('true = ada, false = tidak ada');
            $table->string('nomor_tagihan', 50)
                ->index()
                ->nullable()
                ->default(null)
                ->comment('nomor sr (non) dan fp (ppn)');
            $table->string('nomor_purchasing_request', 50)
                ->index()
                ->nullable()
                ->default(null)
                ->comment('nomor purchasing request, update setelah purchasing request diisi oleh gudang');
            $table->string('tipe_bayar', 50)
                ->index()
                ->comment('tipe bayar: cash, bon');
            $table->date('tgl_cetak')
                ->comment('tanggal spk dicetak');
            $table->string('tgl_kirim', 50)
                ->comment('tanggal spk dikirim');
            $table->text('keterangan')->comment('keterangan spk');
            $table->json('customer')
                ->comment('nama_customer, alamat, no_telp, contact');
            $table->json('products')
                ->comment('nama_barang, harga, qty, satuan');
            $table->json('informasi_pengiriman')
                ->nullable()
                ->comment('no_kontrak, no_polisi, nama_supir, no_hp_supir, partay, no_container, kapal, estimated_time_departure, estimated_time_arrival, berat');
            $table->integer('status')
                ->index()
                ->default(0)
                ->comment('status spk');
            $table->foreignId('added_by')
                ->index()
                ->nullable()
                ->comment('user yang menambahkan spk')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('assign_to')
                ->index()
                ->nullable()
                ->comment('assign ke produksi')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('update_by')
                ->index()
                ->nullable()
                ->comment('diupdate oleh')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('pengiriman_updated_by')
                ->index()
                ->nullable()
                ->comment('pengiriman diupdate oleh')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('no_tagihan_updated_by')
                ->index()
                ->nullable()
                ->comment('no tagihan diupdate oleh')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('purchasing_list_updated_by')
                ->index()
                ->nullable()
                ->comment('no purchasing_request diupdate oleh')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk');
    }
};
