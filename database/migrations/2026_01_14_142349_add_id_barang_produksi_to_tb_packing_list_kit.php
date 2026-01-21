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
        Schema::table('tb_packing_list_kit', function (Blueprint $table) {
            $table->string('id_barang_produksi', 200)
                ->after('id_spk')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_packing_list_kit', function (Blueprint $table) {
            $table->dropColumn('id_barang_produksi');
        });
    }
};
