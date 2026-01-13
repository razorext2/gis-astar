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
            $table->boolean('production_has_download_spk_pdf')
                ->default(0)
                ->after('on_delay_by')
                ->comment('apakah produksi sudah download pdf?');
            $table->dateTime('production_has_download_spk_pdf_at')
                ->nullable()
                ->after('production_has_download_spk_pdf')
                ->comment('kapan dia download?');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('production_has_download_spk_pdf');
            $table->dropColumn('production_has_download_spk_pdf_at');
        });
    }
};
