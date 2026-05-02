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
        Schema::create('placement_hrds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained('tb_placement')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('placement_managements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained('tb_placement')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_managements');
        Schema::dropIfExists('placement_hrds');
    }
};
