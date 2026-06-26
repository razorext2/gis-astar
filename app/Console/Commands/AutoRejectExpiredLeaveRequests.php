<?php

/** Goal: Auto-reject leave requests exceeding approval deadline, Caller: Scheduler (console.php), Deps: LeaveRequest, LeaveRequestHistory */

namespace App\Console\Commands;

use App\Models\LeaveRequest\LeaveRequest;
use App\Services\LeaveRequest\LeaveRequestService;
use Illuminate\Console\Command;

class AutoRejectExpiredLeaveRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-reject-expired-leave-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menolak pengajuan cuti yang melebihi batas waktu approval.';

    /**
     * Execute the console command.
     */
    public function handle(LeaveRequestService $service): int
    {
        $deadlineDays = config('app.leave_approval_deadline_days', 3);
        $cutoff = now()->subDays($deadlineDays);

        $pendingStatuses = [
            'pending_backup',
            'pending_spv',
            'pending_hrd',
            'pending_management',
        ];

        $expiredRequests = LeaveRequest::with(['user', 'leaveType'])
            ->whereIn('status', $pendingStatuses)
            ->where('updated_at', '<', $cutoff)
            ->get();

        if ($expiredRequests->isEmpty()) {
            $this->info('Tidak ada pengajuan cuti yang expired.');

            return self::SUCCESS;
        }

        $rejectedCount = 0;

        foreach ($expiredRequests as $request) {
            // Simpan status original sebelum diubah
            $originalStatus = $request->status;

            $note = "Pengajuan ditolak otomatis karena melebihi batas waktu approval ({$deadlineDays} hari).";

            // Gunakan service agar notifikasi ke pemohon terkirim dan history tercatat konsisten
            $service->processAction($request, 'auto_reject', $request->user, $note);

            $rejectedCount++;

            $userName = $request->user->name ?? 'N/A';
            $this->line("  ✗ Request #{$request->id} ({$userName}) — status: {$originalStatus} → rejected");
        }

        $this->info("Berhasil menolak {$rejectedCount} pengajuan cuti yang expired.");

        return self::SUCCESS;
    }
}
