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
        Schema::create('tb_leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // user yang memiliki jatah cuti
                ->constrained('users')
                ->cascadeOnDelete();
            $table->year('year'); // tahun
            $table->integer('total_quota')->default(12); // total jatah cuti
            $table->integer('used_quota')->default(0); // total cuti yang sudah digunakan
            $table->timestamps();

            $table->unique(['user_id', 'year']); // user hanya boleh punya 1 jatah cuti per tahun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_leave_balances');
    }
};
