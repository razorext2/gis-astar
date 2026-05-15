<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('tb_dayoff');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
