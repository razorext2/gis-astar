<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_spk_receivable_histories', function (Blueprint $table) {
            $table->bigInteger('sisa_piutang_total')->default(0)->after('jumlah_piutang');
        });
    }

    public function down(): void
    {
        Schema::table('tb_spk_receivable_histories', function (Blueprint $table) {
            $table->dropColumn('sisa_piutang_total');
        });
    }
};
