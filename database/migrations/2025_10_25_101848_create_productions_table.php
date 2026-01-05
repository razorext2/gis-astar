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
        Schema::create('tb_produksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_spk')
                ->nullable()
                ->index()
                ->constrained('tb_spk')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('foreign key ke tb_spk');
            $table->foreignId('assign_to')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('di assign ke siapa');
            $table->json('packing_list')
                ->nullable()
                ->comment('packing list: products, jumlah, satuan, box_container');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_produksi');
    }
};
