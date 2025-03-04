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
            $table->unsignedBigInteger('id_driver')->nullable();
            $table->foreign('id_driver')->references('id')->on('tb_drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_photo_collect', function (Blueprint $table) {
            $table->dropForeign(['id_driver']);
            $table->dropColumn('id_driver');
        });
    }
};
