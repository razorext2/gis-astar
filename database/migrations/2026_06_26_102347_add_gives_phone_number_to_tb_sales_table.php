<?php

/** Goal: Add gives_phone_number column to tb_sales, Caller: migration, Deps: Schema */

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
            $table->boolean('gives_phone_number')->nullable()->after('customer_make_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sales', function (Blueprint $table) {
            $table->dropColumn('gives_phone_number');
        });
    }
};
