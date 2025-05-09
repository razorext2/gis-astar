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
        Schema::table('tb_sales', function (Blueprint $table) {
            $table->boolean('customer_make_order')
                ->default(false)
                ->nullable()
                ->after('id_session');
            $table->string('order_notes', 255)
                ->nullable()
                ->after('customer_make_order');
            $table->string('proof_picture', 255)
                ->nullable()
                ->after('order_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sales', function (Blueprint $table) {
            $table->dropColumn('customer_make_order');
            $table->dropColumn('order_notes');
            $table->dropColumn('proof_picture');
        });
    }
};
