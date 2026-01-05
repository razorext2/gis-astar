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
        Schema::create('tb_spk_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('spk_id')
                ->nullable()
                ->constrained('tb_spk')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('title', 200);
            $table->text('keterangan');
            $table->foreignId('added_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_histories');
    }
};
