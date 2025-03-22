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
        Schema::create('tb_technician_points', function (Blueprint $table) {
            $table->id();
            $table->string('from_vt', 32);
            $table->float('point');
            $table->string('kode_pegawai', 32);
            $table->boolean('is_redeemable')->default(false)->comment('0 = tidak dapat diklaim, 1 = dapat diklaim');
            $table->boolean('is_redeemed')->default(false)->comment('0 = belum diklaim, 1 = sudah diklaim');
            $table->smallInteger('redeemed_status')->default(0)->comment('0 = belum diklaim, 1 = pending, 2 = berhasil klaim, 3 = klaim ditolak');
            $table->datetime('redeemed_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_technician_points');
    }
};
