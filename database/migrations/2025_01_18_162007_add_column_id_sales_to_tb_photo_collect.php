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
        Schema::table('tb_photo_collect', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sales')->nullable()->after('id_collect');
            $table->foreign('id_sales')->references('id')
                ->on('tb_sales')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_photo_collect', function (Blueprint $table) {
            //
        });
    }
};
