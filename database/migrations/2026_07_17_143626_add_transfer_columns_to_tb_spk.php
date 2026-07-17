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
            $table->unsignedBigInteger('transferred_from')->nullable()->after('reassign_at');
            $table->unsignedBigInteger('transferred_to')->nullable()->after('transferred_from');
            $table->timestamp('transferred_at')->nullable()->after('transferred_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn(['transferred_from', 'transferred_to', 'transferred_at']);
        });
    }
};
