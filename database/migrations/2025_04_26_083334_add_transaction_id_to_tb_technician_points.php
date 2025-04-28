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
        Schema::table('tb_technician_points', function (Blueprint $table) {
            $table->string('transaction_id', 255)->nullable()->after('redeemed_date')->comment('ID transaksi diisi SETELAH transaksi dikonfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_technician_points', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
