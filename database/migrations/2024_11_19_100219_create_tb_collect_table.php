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
        Schema::create('tb_collect', function (Blueprint $table) {
            $table->id();
            $table->string('no_sr', 32)->nullable()->index();
            $table->string('kode_pegawai', 32)->nullable()->index();
            $table->string('title', 128)->nullable()->index();
            $table->text('keterangan')->nullable();
            $table->string('longitude', 32);
            $table->string('latitude', 32);
            $table->boolean('status')->default(0);
            $table->text('notes')->nullable();
            $table->integer('have_paid', 1)->nullable();
            $table->string('payment_type', 32)->nullable();
            $table->bigint('payment_amount')->nullable();
            $table->string('validate_by', 32)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_collect');
    }
};
