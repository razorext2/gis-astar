<?php

/** Goal: Add missing order columns to tb_sales table for test database schema, Caller: database migrations, Deps: Schema, Blueprint */

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
            if (!Schema::hasColumn('tb_sales', 'customer_make_order')) {
                $table->boolean('customer_make_order')->default(0)->after('id_session');
            }
            if (!Schema::hasColumn('tb_sales', 'order_notes')) {
                $table->text('order_notes')->nullable()->after('customer_make_order');
            }
            if (!Schema::hasColumn('tb_sales', 'proof_picture')) {
                $table->string('proof_picture')->nullable()->after('order_notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_sales', function (Blueprint $table) {
            if (Schema::hasColumn('tb_sales', 'customer_make_order')) {
                $table->dropColumn('customer_make_order');
            }
            if (Schema::hasColumn('tb_sales', 'order_notes')) {
                $table->dropColumn('order_notes');
            }
            if (Schema::hasColumn('tb_sales', 'proof_picture')) {
                $table->dropColumn('proof_picture');
            }
        });
    }
};
