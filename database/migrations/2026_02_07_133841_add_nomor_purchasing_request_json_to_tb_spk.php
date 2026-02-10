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
            $table->json('nomor_purchasing_request_json')
                ->nullable()
                ->after('nomor_purchasing_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropColumn('nomor_purchasing_request_json');
        });
    }
};
