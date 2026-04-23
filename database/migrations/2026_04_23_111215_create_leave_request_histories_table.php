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
        Schema::create('tb_leave_request_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_request_id')->constrained('tb_leave_requests')->cascadeOnDelete(); // id pengajuan
            $table->foreignId('acted_by')->constrained('users')->cascadeOnDelete(); // user yang melakukan aksi

            $table->string('action'); // submitted, approved, rejected, delayed
            $table->string('status_to'); // status setelah aksi, cth: pending HRD
            $table->text('note')->nullable(); // wajib diisi jika ditolak/ditunda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_leave_request_histories');
    }
};
