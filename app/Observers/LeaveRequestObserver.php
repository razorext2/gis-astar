<?php

namespace App\Observers;

/** Goal: Automatically update leave balances when status changes, Caller: LeaveRequest Model, Deps: LeaveRequest, LeaveBalance */

use App\Models\LeaveRequest\LeaveRequest;
use Illuminate\Support\Facades\DB;

class LeaveRequestObserver
{
    /**
     * Handle the LeaveRequest "updated" event.
     */
    public function updated(LeaveRequest $leaveRequest): void
    {
        // Hanya proses jika status berubah
        if (!$leaveRequest->wasChanged('status')) {
            return;
        }

        $newStatus = $leaveRequest->status;
        $oldStatus = $leaveRequest->getOriginal('status');

        // 1. Kondisi: Status Berubah Menjadi 'approved' (Potong Saldo)
        if ($newStatus === 'approved') {
            $this->handleBalanceDraft($leaveRequest, 'deduct');
        }

        // 2. Kondisi: Status Berubah DARI 'approved' ke lain (Refund Saldo)
        // Berguna jika ada revisi atau pembatalan setelah sempat disetujui pimpinan tertinggi
        if ($oldStatus === 'approved' && in_array($newStatus, ['rejected', 'cancelled'])) {
            $this->handleBalanceDraft($leaveRequest, 'refund');
        }
    }

    /**
     * Logika utama pemotongan atau pengembalian saldo
     */
    protected function handleBalanceDraft(LeaveRequest $leaveRequest, string $action): void
    {
        $leaveType = $leaveRequest->leaveType;

        // Cek apakah tipe cuti ini memotong kuota tahunan
        if ($leaveType && $leaveType->is_anual_deduction) {
            DB::transaction(function () use ($leaveRequest, $action) {
                // Ambil saldo berdasarkan tahun dimulainya cuti
                $year = $leaveRequest->start_date->format('Y');
                $balance = $leaveRequest->user->leaveBalances()
                    ->where('year', $year)
                    ->lockForUpdate() // Senior DBA Standard: Lock baris untuk mencegah race condition
                    ->first();

                if ($balance) {
                    if ($action === 'deduct') {
                        $balance->increment('used_quota', $leaveRequest->total_days);
                    } else {
                        $balance->decrement('used_quota', $leaveRequest->total_days);
                    }
                }
            });
        }
    }
}
