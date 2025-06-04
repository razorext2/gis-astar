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
        Schema::create('tb_point_transactions_view', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 32);
            $table->string('quartal', 32);
            $table->string('year', 32);
            $table->string('point_type', 32);
            $table->string('redeemed_by', 32);
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('total_points');
            $table->string('status', 32);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_point_transactions_view');
    }
};
