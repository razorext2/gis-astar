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
        Schema::create('tb_spk_receivable_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('spk_id')
                ->nullable()
                ->constrained('tb_spk', 'id')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('nomor_sr', 32);
            $table->bigInteger('total_piutang');
            $table->bigInteger('sisa_piutang_sebelum');
            $table->bigInteger('sisa_piutang_sesudah');
            $table->bigInteger('selisih');
            $table->enum('source', ['API', 'manual', 'system'])
                ->default('API');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->dateTime('checked_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_receivable_histories');
    }
};
