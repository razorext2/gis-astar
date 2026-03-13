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
        Schema::create('tb_spk_project_hourly_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('daily_report_id')
                ->index()
                ->constrained('tb_spk_project_daily_reports')
                ->cascadeOnUpdate();
            $table->time('start_time');
            $table->time('end_time');
            $table->text('activity');
            $table->json('location')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_project_hourly_reports');
    }
};
