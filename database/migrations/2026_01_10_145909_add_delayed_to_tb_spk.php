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
            $table->boolean('on_delay')
                ->default(false)
                ->index()
                ->after('approved_at')
                ->comment('true = delayed, false = not delayed');
            $table->dateTime('on_delay_at')
                ->nullable()
                ->after('on_delay')
                ->comment('tanggal didelay');
            $table->text('on_delay_notes')
                ->nullable()
                ->after('on_delay_at')
                ->comment('catatan delayed');
            $table->foreignId('on_delay_by')
                ->nullable()
                ->after('on_delay_notes')
                ->comment('siapa yang delay?')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('on_delay');
            $table->dropColumn('on_delay_at');
            $table->dropColumn('on_delay_notes');
        });
    }
};
