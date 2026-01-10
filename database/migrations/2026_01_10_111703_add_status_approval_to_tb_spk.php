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
            $table->integer('status_approval')
                ->default(0)
                ->index()
                ->comment('0 = belum disetujui, 1 = disetujui, 2 = ditolak, 3 = revisi')
                ->after('purchasing_list_updated_by');

            $table->text('catatan_approval')
                ->nullable()
                ->after('status_approval');

            $table->foreignId('approved_by')
                ->index()
                ->nullable()
                ->after('catatan_approval')
                ->comment('siapa yang menyetujui')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->dateTime('approved_at')
                ->nullable()
                ->comment('di setujui kapan?')
                ->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('status_approval');
            $table->dropColumn('catatan_approval');
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
        });
    }
};
