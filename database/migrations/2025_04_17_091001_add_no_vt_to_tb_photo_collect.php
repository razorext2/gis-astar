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
        Schema::table('tb_photo_collect', function (Blueprint $table) {
            $table->string('no_vt', 32)->nullable()->after('id_driver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_photo_collect', function (Blueprint $table) {
            $table->dropColumn('no_vt');
        });
    }
};
