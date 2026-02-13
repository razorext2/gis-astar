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
        Schema::create('tb_spk_delivery', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('id_spk')
                ->constrained('tb_spk')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('via', 32)
                ->index();
            $table->string('partay', 100)
                ->nullable();
            $table->string('no_container', 100)
                ->nullable();
            $table->string('nama_kapal', 100)
                ->nullable();
            $table->string('no_plat', 100)->nullable();
            $table->string('nama_supir', 100)->nullable();
            $table->string('id_supir')
                ->nullable()
                ->index();
            $table->string('no_telp_supir', 20)->nullable();
            $table->string('berat', 20)->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->text('note')->nullable();
            $table->json('products')->nullable();
            $table->json('is_delay')->nullable();
            $table->json('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_delivery');
    }
};
