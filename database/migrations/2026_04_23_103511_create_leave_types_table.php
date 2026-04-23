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
        Schema::create('tb_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama jenis cuti, cth: cuti tahunan, melahirkan, menikah, kemalangan
            $table->string('code')->unique(); // kode jenis cuti, cth: TAHUNAN, MELAHIRKAN, MENIKAH, KEMALANGAN
            $table->boolean('is_anual_deduction')->default(false); // apakah memotong jatah cuti tahunan
            $table->integer('default_days')->nullable(); // jumlah hari cuti default, null untuk cuti tahunan, 3 untuk menikah, 2 untuk kemalangan, dsb
            $table->boolean('requires_attachment')->default(false); // apakah memerlukan lampiran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_leave_types');
    }
};
