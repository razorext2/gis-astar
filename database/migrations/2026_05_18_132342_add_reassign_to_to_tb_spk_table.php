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
            $table->unsignedBigInteger('reassign_to')->nullable()->after('assign_to')->index();
            $table->unsignedBigInteger('reassign_by')->nullable()->after('reassign_to');
            $table->dateTime('reassign_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropIndex(['reassign_to', 'reassign_by']);
            $table->dropColumn('reassign_to');
            $table->dropColumn('reassign_by');
            $table->dropColumn('reassign_at');
        });
    }
};
