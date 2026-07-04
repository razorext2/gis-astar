<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_spk_receivable_history_details', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('receivable_history_id')
                ->constrained('tb_spk_receivable_histories', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nomor_piutang', 64)->nullable()->index();
            $table->bigInteger('jumlah_piutang')->default(0);
            $table->bigInteger('total_bayar')->default(0);
            $table->bigInteger('sisa_piutang')->default(0);
            $table->boolean('is_dp')->default(false);
            $table->enum('source', ['API', 'manual', 'system'])->default('API');
            $table->dateTime('checked_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_spk_receivable_history_details');
    }
};
