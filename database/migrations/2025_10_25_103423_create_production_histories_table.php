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
        Schema::create('tb_produksi_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_produksi')
                ->nullable()
                ->constrained('tb_produksi')
                ->cascadeonUpdate()
                ->nullOnDelete()
                ->index();
            $table->string('judul', 255)
                ->index();
            $table->text('keterangan');
            $table->json('documentations')
                ->nullable();
            $table->integer('status_produksi')
                ->index()
                ->default(0);
            $table->integer('status_validasi')
                ->index()
                ->default(0);
            $table->foreignId('added_by')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->index()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('validated_by')
                ->nullable()
                ->index()
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
        Schema::dropIfExists('tb_produksi_histories');
    }
};
