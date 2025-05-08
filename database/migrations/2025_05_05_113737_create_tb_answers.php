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
        Schema::create('tb_answers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pegawai', 32);
            $table->string('id_session', 64);
            $table->string('id_question', 32);
            $table->string('id_option', 32);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_answers');
    }
};
