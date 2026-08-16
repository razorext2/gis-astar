<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rumah_sakit_rujukan', function (Blueprint $table) {
            $table->softDeletes()->after('layanan_operasi');
        });

        Schema::table('rujukan', function (Blueprint $table) {
            $table->softDeletes()->after('keterangan');
        });

        Schema::table('detail_rujukan', function (Blueprint $table) {
            $table->softDeletes()->after('metode');
        });

        Schema::table('rute', function (Blueprint $table) {
            $table->softDeletes()->after('algoritma');
        });

        Schema::table('titik_rute', function (Blueprint $table) {
            $table->softDeletes()->after('tipe');
        });

        Schema::table('riwayat_rujukan', function (Blueprint $table) {
            $table->softDeletes()->after('waktu_perubahan');
        });
    }

    public function down(): void
    {
        Schema::table('rumah_sakit_rujukan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('rujukan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('detail_rujukan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('rute', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('titik_rute', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('riwayat_rujukan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
