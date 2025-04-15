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
        Schema::table('tb_point_transactions', function (Blueprint $table) {
            $table->string('quartal')->nullable()->after('transaction_id');
            $table->string('year')->nullable()->after('quartal');
            $table->integer('valid_points')->nullable()->after('to_date');
            $table->integer('invalid_points')->nullable()->after('valid_points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_point_transactions', function (Blueprint $table) {
            $table->dropColumn('quartal');
            $table->dropColumn('year');
            $table->dropColumn('valid_points');
            $table->dropColumn('invalid_points');
        });
    }
};
