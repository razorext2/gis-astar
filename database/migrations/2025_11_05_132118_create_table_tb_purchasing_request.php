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
        Schema::create('tb_purchasing_request', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_spk')
                ->nullable()
                ->index()
                ->constrained('tb_spk')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('foreign key ke tb_spk');
            $table->string('kode_item', 32)->index();
            $table->string('nama_item', 256)->index();
            $table->integer('qty')->default(0)->nullable();
            $table->string('satuan', 32);
            $table->string('lokasi_gudang_terima', '128')->index();
            $table->integer('jumlah_item_dipesan')->default(0)->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('added_by')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('user yang menambahkan data');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_purchasing_request');
    }
};
