<?php

/** Goal: Add unique index to no_seri column on tb_data_timbang_indodaya, Caller: DB Migrations, Deps: none */

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
        Schema::table('tb_data_timbang_indodaya', function (Blueprint $table) {
            $table->unique('no_seri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_data_timbang_indodaya', function (Blueprint $table) {
            $table->dropUnique(['no_seri']);
        });
    }
};

