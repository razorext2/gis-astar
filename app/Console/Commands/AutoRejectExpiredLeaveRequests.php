<?php

/** Goal: Auto-reject leave requests exceeding approval deadline, Caller: Scheduler (console.php), Deps: LeaveRequest, LeaveRequestHistory */

namespace App\Console\Commands;

use App\Models\LeaveRequest\LeaveRequest;
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
    public function handle(): int
    {
        $deadlineDays = config('app.leave_approval_deadline_days', 3);
        $cutoff = now()->subDays($deadlineDays);

        $pendingStatuses = [
            'pending_backup',
            'pending_spv',
            'pending_hrd',
            'pending_management',
        ];

        $expiredRequests = LeaveRequest::whereIn('status', $pendingStatuses)
            ->where('updated_at', '<', $cutoff)
            ->get();

        if ($expiredRequests->isEmpty()) {
            $this->info('Tidak ada pengajuan cuti yang expired.');

            return self::SUCCESS;
        }

        $rejectedCount = 0;

        foreach ($expiredRequests as $request) {
            $request->acted_by = null;  // null signals auto-reject → observer falls back to user_id
            $request->current_note = "Pengajuan ditolak otomatis karena melebihi batas waktu approval ({$deadlineDays} hari).";
            $request->update(['status' => 'rejected']);

            $rejectedCount++;

            $userName = $request->user->name ?? 'N/A';
            $originalStatus = $request->getOriginal('status');
            $this->line("  ✗ Request #{$request->id} ({$userName}) — status: {$originalStatus} → rejected");
        }

        $this->info("Berhasil menolak {$rejectedCount} pengajuan cuti yang expired.");

        return self::SUCCESS;
    }
}
