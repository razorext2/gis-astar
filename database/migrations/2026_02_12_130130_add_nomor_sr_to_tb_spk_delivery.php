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
        Schema::table('tb_spk_delivery', function (Blueprint $table) {
            $table->string('nomor_sr', 32)
                ->nullable()
                ->index()
                ->after('id_spk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk_delivery', function (Blueprint $table) {
            $table->dropColumn('nomor_sr');
        });
    }
};
