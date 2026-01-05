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
        Schema::create('tb_laporan_fondasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_spk')
                ->nullable()
                ->index()
                ->constrained('tb_spk')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('judul', 256)->index();
            $table->json('dokumentasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('status_pengerjaan')
                ->default(0)
                ->index()
                ->comment('1 = baru dibuat, 2 = dalam proses, 3 = selesai');
            $table->foreignId('added_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_laporan_fondasi');
    }
};
