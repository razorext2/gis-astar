<?php

namespace App\Services\LeaveRequest;

/** Goal: Centralize business logic and validation for Leave Requests, Caller: Livewire Components, Deps: User, LeaveRequest, LeaveType */

use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use Exception;

class LeaveRequestService
{
    /**
     * Validasi apakah seorang user boleh mengambil tipe cuti tertentu dengan durasi tertentu.
     *
     * @throws Exception
     */
    public function validateRequest(User $user, int $leaveTypeId, int $totalDays): bool
    {
        $leaveType = LeaveType::findOrFail($leaveTypeId);

        // 1. Validasi Cuti Tahunan (Dukut Saldo)
        if ($leaveType->is_anual_deduction) {
            $balance = $user->currentLeaveBalance();

            if (! $balance) {
                throw new Exception('Saldo cuti tahunan untuk tahun ini belum diatur.');
            }

            if ($balance->remaining_quota < $totalDays) {
                throw new Exception("Saldo cuti tahunan tidak mencukupi (Sisa: {$balance->remaining_quota} hari).");
            }
        }

        // 2. Validasi Cuti Khusus (Misal: Menikah, Melahirkan, dll)
        // Kita bisa menggunakan sistem 'code' untuk identifikasi logic unik
        switch ($leaveType->code) {
            case 'CT-MENIKAH':
                if ($user->hasTakenSpecialLeave('CT-MENIKAH')) {
                    throw new Exception('Anda sudah pernah menggunakan jatah cuti menikah.');
                }
                break;

            case 'CT-MELAHIRKAN':
                // Logika bisa disesuaikan, misal cek gender atau periode waktu
                if ($user->hasTakenSpecialLeave('CT-MELAHIRKAN')) {
                    throw new Exception('Anda sudah pernah menggunakan jatah cuti melahirkan dalam periode ini.');
                }
                break;

                // Tambahkan case lainnya sesuai kebijakan perusahaan
        }

        // 3. Validasi durasi jika ada default_days di tipe cuti (Opsional)
        if ($leaveType->default_days > 0 && $totalDays > $leaveType->default_days) {
            // Ini bisa jadi warning atau hard-error tergantung kebijakan
            // Kita buat hard-error jika melebihi batas standar tipe cuti tersebut
            // throw new Exception("Durasi melebihi batas maksimal untuk tipe cuti {$leaveType->name} ({$leaveType->default_days} hari).");
        }

        return true;
    }
}
