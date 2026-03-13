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
        Schema::create('tb_spk_project_hourly_report_files', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('hourly_report_id')
                ->index()
                ->constrained('tb_spk_project_hourly_reports')
                ->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_project_hourly_report_files');
    }
};
