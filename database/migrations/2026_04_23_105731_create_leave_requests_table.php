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
        Schema::create('tb_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // user yang mengajukan
            $table->foreignId('leave_type_id')->constrained('tb_leave_types')->cascadeOnDelete(); // jenis cuti
            $table->foreignId('backup_person_id')->nullable()->constrained('users')->nullOnDelete(); // user pengganti

            $table->date('start_date'); // tanggal cuti mulai
            $table->date('end_date'); // tanggal cuti berakhir
            $table->date('return_date'); // tanggal masuk kerja kembali
            $table->integer('total_days'); // jumlah hari kerja yang digunakan
            $table->text('reason'); // alasan
            $table->json('attachments')->nullable(); // untuk lampiran surat, foto ll

            // alur persetujuan
            $table->enum('status', [
                'draft',
                'pending_backup',
                'pending_spv',
                'pending_hrd',
                'pending_management',
                'approved',
                'rejected',
                'auto_reject',
                'delayed',
                'cancelled',
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_leave_requests');
    }
};
