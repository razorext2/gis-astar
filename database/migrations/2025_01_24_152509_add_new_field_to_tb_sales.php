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
        Schema::table('tb_sales', function (Blueprint $table) {
            $table->string('customer_name', 128)->nullable()->after('title');
            $table->string('customer_telp', 20)->nullable()->after('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sales', function (Blueprint $table) {
            //
        });
    }
};
