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
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->unsignedInteger('revision_count')
                ->default(0)
                ->after('production_has_download_spk_pdf_at');
            $table->foreignId('latest_revision_request_by')
                ->nullable()
                ->after('revision_count')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('latest_revision_request_detail')
                ->nullable()
                ->after('latest_revision_request_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('revision_count');
            $table->dropConstrainedForeignId('latest_revision_request_by');
            $table->dropColumn('latest_revision_request_detail');
        });
    }
};
