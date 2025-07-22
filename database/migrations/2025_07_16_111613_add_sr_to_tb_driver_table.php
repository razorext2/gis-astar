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
        Schema::table('tb_drivers', function (Blueprint $table) {
            $table->string('title', 255)->comment('Nama PT.')->change(); // ubah comment title jadi nama PT
            $table->string('lokasi', 255)->comment('Alamat PT.')->change(); // ubah lokasi jadi alamat PT
            $table->tinyInteger('status')
                ->comment('0 : Diajukan, 1 : Disetujui, 2 : Ditolak, 3 : Revisi, 4 : Belum di Assign, 5 : Menunggu di Update')
                ->change();
            $table->string('no_sr', 20)
                ->nullable()
                ->comment('No SR')
                ->after('id'); // tambah field no sr
            $table->string('tipe_kunjungan', 10)
                ->nullable()
                ->comment('Tipe Kunjungan')
                ->after('no_sr'); // tambah field tipe kunjungan
            $table->string('kode_pegawai')->nullable(true)->change(); // ubah kode_pegawai agar jadi nullable
            $table->string('status_pengantaran', 32)->nullable()
                ->comment('Status Pengantaran (sudah diterima/belum)')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_drivers', function (Blueprint $table) {
            $table->string('title', 32)->comment('Judul laporan')->change();
            $table->string('lokasi', 128)->comment('Lokasi kunjungan')->change();
            $table->dropColumn('no_sr');
            $table->dropColumn('tipe_kunjungan');
        });
    }
};
