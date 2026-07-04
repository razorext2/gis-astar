<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tb_spk_receivable_histories');

        Schema::create('tb_spk_receivable_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('spk_id')
                ->nullable()
                ->constrained('tb_spk', 'id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('nomor_sr', 32);
            $table->string('tipe_tagihan', 10);
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('total')->default(0);
            $table->bigInteger('jumlah_piutang')->default(0);
            $table->enum('jumlah_piutang_field', ['subtotal', 'total'])->default('subtotal');
            $table->enum('source', ['API', 'manual', 'system'])->default('manual');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->dateTime('checked_at');
            $table->softDeletes();
            $table->timestamps();

            $table->index('nomor_sr');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_spk_receivable_histories');
    }
};
