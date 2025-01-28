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
        Schema::table('tb_collect_tasks', function (Blueprint $table) {
            $table->string('collect_type', 32)->nullable()->after('no_sr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_collect_tasks', function (Blueprint $table) {
            //
        });
    }
};
