<?php

/** Goal: Create tb_attendance_inquiries table, Caller: Migration command, Deps: - */

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
        Schema::create('tb_attendance_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pegawai', 16);
            $table->string('type_absen', 10)->comment('in = masuk, out = keluar');
            $table->tinyInteger('position_status')->comment('1 = onroute, 2 = standby, 3 = onsite, 0 = unknown');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->dateTime('waktu_absen');
            $table->text('keterangan');
            $table->string('no_vt', 32)->nullable();
            $table->json('bukti');
            $table->string('status', 20)->default('pending')->comment('pending, approved, rejected');
            $table->foreignId('acted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('acted_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('kode_pegawai');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_attendance_inquiries');
    }
};
