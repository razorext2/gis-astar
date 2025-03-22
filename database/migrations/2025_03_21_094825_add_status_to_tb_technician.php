<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_technician', function (Blueprint $table) {
            $table->smallInteger('status')
                ->default(0)
                ->after('visit_date')
                ->comment('0 = diajukan, 1 = disetujui, 2 = butuh revisi, 3 = ditolak');
            $table->string('validate_by', 30)->nullable()->after('status');
            $table->dateTime('validate_at')->nullable()->after('validate_by');
            $table->smallInteger('total_revision')->default(0)->after('validate_at');
            $table->string('notes', 128)->nullable()->after('total_revision');
            $table->string('revised_by', 30)->nullable()->after('notes');
            $table->dateTime('revised_at')->nullable()->after('revised_by');
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::table('tb_technician', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('validate_by');
            $table->dropColumn('validate_at');
            $table->dropColumn('total_revision');
            $table->dropColumn('notes');
            $table->dropColumn('revised_by');
            $table->dropColumn('revised_at');
        });
    }
};
