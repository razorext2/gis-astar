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
        Schema::table('tb_spk_receivable_history_details', function (Blueprint $table) {
            // Menyimpan nilai sisa_piutang dari record sebelumnya (per nomor_piutang) sebelum sync API.
            // Berguna untuk audit trail: mengetahui berapa pembayaran yang terjadi pada satu sync.
            $table->bigInteger('sisa_sebelum')->nullable()->after('sisa_piutang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk_receivable_history_details', function (Blueprint $table) {
            $table->dropColumn('sisa_sebelum');
        });
    }
};
