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
        Schema::table('tb_invoice', function (Blueprint $table) {
            $table->string('tipe_tagihan', 32)
                ->nullable()
                ->after('no_faktur_pajak')
                ->comment('tipe tagihan: idc ppn/idy ppn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_invoice', function (Blueprint $table) {
            $table->$table->dropColumn('tipe_tagihan');
        });
    }
};
