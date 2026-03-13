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
        Schema::create('tb_spk_project_daily_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('assignment_id')
                ->index()
                ->constrained('tb_spk_project_assignments')
                ->cascadeOnDelete();
            $table->date('report_date');
            $table->enum('status', [
                'draft',
                'submitted',
                'approved',
                'rejected',
            ])->default('draft');
            $table->dateTime('submitted_at');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['assignment_id', 'report_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_spk_project_daily_reports');
    }
};
