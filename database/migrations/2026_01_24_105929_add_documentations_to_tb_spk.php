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
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->string('nomor_dokumen_penawaran')
                ->after('nomor_order')
                ->nullable()
                ->index()
                ->comment('Nomor Dokumen Penawaran terkait SPK');
            $table->json('documentations')
                ->after('informasi_pengiriman')
                ->nullable()
                ->comment('Dokumentasi terkait SPK dalam format JSON, biasa isinya request fondasi dari customer');
            $table->boolean('is_booked')
                ->after('production_has_download_spk_pdf_at')
                ->default(false)
                ->comment('menandakan nomor spk statusnya dibook atau tidak');
            $table->dateTime('booked_at')
                ->after('is_booked')
                ->nullable()
                ->comment('Tanggal dan waktu ketika SPK dibook');
            $table->foreignId('booked_by')
                ->after('booked_at')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('User yang melakukan booking SPK');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('nomor_dokumen_penawaran');
            $table->dropColumn('documentations');
            $table->dropColumn('is_booked');
            $table->dropColumn('booked_at');
            $table->dropColumn('booked_by');
        });
    }
};
