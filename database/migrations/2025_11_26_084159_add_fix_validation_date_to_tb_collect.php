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
        Schema::table('tb_collect', function (Blueprint $table) {
            $table->dateTime('validated_at')
                ->after('validate_by')
                ->nullable()
                ->comment('di validasi kapan?');
            $table->dateTime('revised_at')
                ->after('revised_by')
                ->nullable()
                ->comment('di revisi kapan?');
            $table->foreignId('filled_by')
                ->nullable()
                ->after('revised_at')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->comment('siapa yang isi?');
            $table->dateTime('filled_at')
                ->after('filled_by')
                ->nullable()
                ->comment('diisi oleh kolektor kapan? sama aja kaya assign_at ternyata wkwkwkwk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_collect', function (Blueprint $table) {
            $table->dropForeign(['filled_by']);
            $table->dropColumn('validated_at');
            $table->dropColumn('filled_by');
            $table->dropColumn('filled_at');
        });
    }
};
