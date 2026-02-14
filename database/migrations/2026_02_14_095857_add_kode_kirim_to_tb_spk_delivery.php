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
            $table->string('kode_kirim')
                ->after('id_spk')
                ->unique()
                ->nullable();
            $table->integer('status_kirim')
                ->default(0)
                ->after('kode_kirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk_delivery', function (Blueprint $table) {
            $table->dropColumn('kode_kirim');
            $table->dropColumn('status_kirim');
        });
    }
};
