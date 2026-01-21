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
        Schema::create('tb_packing_list_kit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_spk')
                ->index()
                ->constrained('tb_spk')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nama_kit', 200)->index();
            $table->float('jumlah_kit')->default(0);
            $table->string('satuan_kit', 32)->nullable();
            $table->string('nama_customer', 200)->index();
            $table->json('peti')->comment('nama peti dan isinya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_packing_list_kit');
    }
};
