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
        Schema::create('tb_spk_projects', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUuid('spk_id')
                ->index()
                ->nullable()
                ->constrained('tb_spk')
                ->cascadeOnDelete();
            $table->date('start_date')
                ->index()
                ->comment('deadline laporan bisa dikerjakan dari tanggal berapa');
            $table->date('end_date')
                ->nullable()
                ->index()
                ->comment('deadline laporan bisa dikerjakan sebelum tanggal berapa');
            $table->date('deadline')
                ->nullable();
            $table->string('project_name', 255)
                ->index();
            $table->text('description')->nullable();
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_projects');
    }
};
