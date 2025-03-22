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
        Schema::create('tb_technician', function (Blueprint $table) {
            $table->id();
            $table->string('no_vt', 32);
            $table->string('id_permintaan', 100)->nullable();
            $table->string('kode_pegawai', 32);
            $table->string('customer_contact', 100)->nullable();
            $table->string('customer_address', 100)->nullable();
            $table->text('job_detail')->nullable();
            $table->string('weight_type', 100)->nullable();
            $table->string('size', 100)->nullable();
            $table->string('capacity', 50)->nullable();
            $table->string('indicator_type', 100)->nullable();
            $table->string('indicator_sn', 100)->nullable();
            $table->string('loadcell_type', 100)->nullable();
            $table->string('loadcell_qty', 50)->nullable();
            $table->string('loadcell_sn', 100)->nullable();
            $table->string('junction_type', 100)->nullable();
            $table->text('job_update')->nullable();
            $table->string('visit_date', 32)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_technician');
    }
};
