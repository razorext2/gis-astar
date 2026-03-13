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
        Schema::create('tb_spk_project_assignments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('project_id', 100)
                ->index()
                ->constrained('tb_spk_projects')
                ->cascadeOnDelete();
            $table->enum('laporan_type', ['teknisi', 'mekanik', 'metrologi'])
                ->index();
            $table->string('nomor_vt', 32)
                ->index()
                ->comment('nomor_vt untuk laporan hariannya');
            $table->foreignId('assign_to')
                ->index()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->dateTime('assign_at');
            $table->enum('status', [
                'assigned',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('assigned');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_project_assigments');
    }
};
