<?php

/** Goal: Centralize business logic and validation for Leave Requests, Caller: Livewire Components, Deps: User, LeaveRequest, LeaveType */

namespace App\Services\LeaveRequest;

use App\Models\LeaveRequest\LeaveBalance;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveRequestHistory;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class LeaveRequestService
{
    /**
     * Create a new leave request.
     */
    public function createRequest(array $data, User $user): LeaveRequest
    {
        return DB::transaction(function () use ($data, $user) {
            // H1: Pessimistic lock to prevent race condition double-submit
            $hasActive = $user->leaveRequests()
                ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
                ->lockForUpdate()
                ->exists();

            if ($hasActive) {
                throw new Exception('Anda masih memiliki pengajuan cuti yang sedang dalam proses.');
            }

            // H3: Use total_days from Livewire if provided, otherwise calculate
            $leaveType = LeaveType::findOrFail($data['leave_type_id']);
            $useBusinessDays = ! $leaveType->use_calendar_days;
            $totalDays = $data['total_days'] ?? $this->calculateTotalDays($data['start_date'], $data['end_date'], $useBusinessDays);

            $isBorrowed = $data['is_borrowed'] ?? false;

            // 1. Validasi saldo jika tipe cuti memotong saldo tahunan (Lewati jika pinjam)
            $this->validateRequest($user, $data['leave_type_id'], $totalDays, $isBorrowed);

            // 2. Tentukan status awal
            $status = isset($data['backup_person_id']) && $data['backup_person_id']
                ? 'pending_backup'
                : 'pending_spv';

            $request = LeaveRequest::create([
                'user_id' => $user->id,
                'leave_type_id' => $data['leave_type_id'],
                'backup_person_id' => $data['backup_person_id'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'return_date' => $this->calculateReturnDate($data['end_date']),
                'total_days' => $totalDays,
                'reason' => $data['reason'],
                'status' => $status,
                'attachments' => $data['attachments'] ?? [],
                'is_borrowed' => $isBorrowed,
            ]);

            // Notify first actor
            $this->notifyNextApprover($request);

            return $request;
        });
    }

    /**
     * Process an approval action.
     */
    public function processAction(LeaveRequest $request, string $action, User $actor, ?string $note = null)
    {
        return DB::transaction(function () use ($request, $action, $actor, $note) {
            $oldStatus = $request->status;

            if ($action === 'approve') {
                $request->status = $this->calculateNextStatus($request);
            } elseif (in_array($action, ['reject', 'auto_reject'])) {
                $request->status = 'rejected';
            } elseif ($action === 'cancel') {
                $request->status = 'canceled';
            }

            // Attach metadata for the observer
            // acted_by null untuk auto_reject agar observer mencatat action 'auto_reject'
            $request->acted_by = $action === 'auto_reject' ? null : $actor->id;

            // definisikan current_note
            $request->current_note = $note;

            $request->save();

            // Deduction Logic on FINAL APPROVAL (with pessimistic lock)
            if ($request->status === 'approved' && $request->leaveType?->is_anual_deduction) {
                $balance = LeaveBalance::where('user_id', $request->user_id)
                    ->where('year', date('Y'))
                    ->lockForUpdate()
                    ->first();
                $balance?->increment('used_quota', $request->total_days);

                // Audit log: catat pemotongan kuota
                if ($balance) {
                    LeaveRequestHistory::create([
                        'leave_request_id' => $request->id,
                        'acted_by' => $actor->id,
                        'action' => 'quota_deducted',
                        'status_from' => $oldStatus,
                        'status_to' => $request->status,
                        'note' => "Kuota dipotong: {$request->total_days} hari (sisa: {$balance->remaining_quota})",
                    ]);
                }
            }

            // Rollback Logic: kembalikan kuota jika cuti yang sudah approved ditolak/dibatalkan
            if (in_array($request->status, ['rejected', 'canceled']) && $oldStatus === 'approved'
                && $request->leaveType?->is_anual_deduction) {
                $balance = LeaveBalance::where('user_id', $request->user_id)
                    ->where('year', date('Y'))
                    ->lockForUpdate()
                    ->first();
                $balance?->decrement('used_quota', $request->total_days);

                // Audit log: catat pengembalian kuota
                if ($balance) {
                    LeaveRequestHistory::create([
                        'leave_request_id' => $request->id,
                        'acted_by' => $actor->id,
                        'action' => 'quota_restored',
                        'status_from' => $oldStatus,
                        'status_to' => $request->status,
                        'note' => "Kuota dikembalikan: {$request->total_days} hari (sisa: {$balance->remaining_quota})",
                    ]);
                }
            }

            // Notify next actor if approved but not final
            if ($action === 'approve' && $request->status !== 'approved') {
                $this->notifyNextApprover($request);
            }

            // Notify applicant when fully approved (final stage)
            if ($action === 'approve' && $request->status === 'approved') {
                $request->user->notify(
                    new \App\Notifications\LeaveRequestApprovedNotification($request)
                );
            }

            // Notify applicant when rejected (manual reject only, bukan auto_reject)
            if ($action === 'reject') {
                $request->user->notify(
                    new \App\Notifications\LeaveRequestRejectedNotification($request, $actor->name, $note)
                );
            }

            // Notify backup person when cancelled by applicant
            if ($action === 'cancel' && $request->backupPerson) {
                $request->backupPerson->notify(
                    new \App\Notifications\LeaveRequestCancelledNotification($request)
                );
            }

            return $request;
        });
    }

    /**
     * Determine where the request goes next.
     */
    protected function calculateNextStatus(LeaveRequest $request, ?string $currentStatus = null): string
    {
        $current = $currentStatus ?? $request->status;

        $next = match ($current) {
            'pending_backup' => 'pending_spv',
            'pending_spv' => 'pending_hrd',
            'pending_hrd' => 'pending_management',
            'pending_management' => 'approved',
            default => 'approved'
        };

        if ($next === 'approved') {
            return 'approved';
        }

        // Check if next status has any actors
        $actors = $this->getApproversForStatus($request, $next);
        if ($actors->isEmpty()) {
            // Skip this stage and find the next one
            return $this->calculateNextStatus($request, $next);
        }

        return $next;
    }

    /**
     * Get approvers for a specific status.
     */
    public function getApproversForStatus(LeaveRequest $request, string $status): \Illuminate\Support\Collection
    {
        $requester = $request->user;
        $pegawai = $requester->pegawai;
        if (! $pegawai) {
            return collect();
        }

        $jabatan = $pegawai->jabatanRelasi;
        if (! $jabatan) {
            return collect();
        }

        $placement = $jabatan->placementRelasi;

        switch ($status) {
            case 'pending_backup':
                return $request->backupPerson ? collect([$request->backupPerson]) : collect();

            case 'pending_spv':
                return $jabatan->supervisors;

            case 'pending_hrd':
                return $placement ? $placement->hrds : collect();

            case 'pending_management':
                return $placement ? $placement->managements : collect();
        }

        return collect();
    }

    /**
     * Notify next approvers for a request.
     */
    protected function notifyNextApprover(LeaveRequest $request): void
    {
        $approvers = $this->getApproversForStatus($request, $request->status);

        if ($approvers->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send(
                $approvers,
                new \App\Notifications\LeaveRequestApprovalNotification($request, $request->status)
            );
        }
    }

    /**
     * Helper to calculate total days.
     *
     * @param  bool  $excludeHolidays  If true, excludes Sundays and National Holidays (Business Days).
     */
    public function calculateTotalDays($startDate, $endDate, bool $excludeHolidays = true): int
    {
        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->startOfDay();

        if (! $excludeHolidays) {
            return $start->diffInDays($end) + 1;
        }

        $holidays = \App\Models\System\Holiday::whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->pluck('date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->toArray();

        $totalDays = 0;
        $current = clone $start;

        while ($current <= $end) {
            // Cek jika bukan hari Minggu DAN bukan hari libur nasional
            if (! $current->isSunday() && ! in_array($current->toDateString(), $holidays)) {
                $totalDays++;
            }
            $current->addDay();
        }

        return $totalDays;
    }

    /**
     * Get list of national holidays within a date range.
     */
    public function getIntersectedHolidays($startDate, $endDate)
    {
        return \App\Models\System\Holiday::whereBetween('date', [
            \Carbon\Carbon::parse($startDate)->toDateString(),
            \Carbon\Carbon::parse($endDate)->toDateString(),
        ])->orderBy('date')->get();
    }

    /**
     * Get list of Sundays within a date range.
     *
     * @return string[]
     */
    public function getIntersectedSundays(string $startDate, string $endDate): array
    {
        $sundays = [];
        $current = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        while ($current <= $end) {
            if ($current->isSunday()) {
                $sundays[] = $current->toDateString();
            }
            $current->addDay();
        }

        return $sundays;
    }

    /**
     * Validasi apakah seorang user boleh mengambil tipe cuti tertentu.
     *
     * @throws Exception
     */
    public function validateRequest(User $user, int $leaveTypeId, int $totalDays, bool $isBorrowed = false): bool
    {
        $leaveType = LeaveType::findOrFail($leaveTypeId);

        // 1. Validasi Cuti Tahunan (Potong Saldo)
        if ($leaveType->is_anual_deduction && ! $isBorrowed) {
            $balance = $user->currentLeaveBalance();

            if (! $balance) {
                throw new Exception('Saldo cuti tahunan untuk tahun ini belum diatur.');
            }

            if ($balance->remaining_quota < $totalDays) {
                throw new Exception("Saldo cuti tahunan tidak mencukupi (Sisa: {$balance->remaining_quota} hari).");
            }
        }

        // 2. Validasi Cuti Khusus
        switch ($leaveType->code) {
            case 'CT-MENIKAH':
                if ($user->hasTakenSpecialLeave('CT-MENIKAH')) {
                    throw new Exception('Anda sudah pernah menggunakan jatah cuti menikah.');
                }
                break;
            case 'CT-MELAHIRKAN':
                if ($user->hasTakenSpecialLeave('CT-MELAHIRKAN')) {
                    throw new Exception('Anda sudah pernah menggunakan jatah cuti melahirkan.');
                }
                break;
        }

        return true;
    }

    /**
     * Helper to calculate the next working day (return to work date).
     */
    public function calculateReturnDate($endDate): string
    {
        $current = \Carbon\Carbon::parse($endDate)->addDay();

        // Pre-fetch holidays 30 hari ke depan agar tidak query per iterasi
        $holidays = \App\Models\System\Holiday::whereBetween('date', [
            $current->toDateString(),
            $current->copy()->addDays(30)->toDateString(),
        ])->pluck('date')->map(fn ($d) => $d->format('Y-m-d'))->toArray();

        while (true) {
            $isHoliday = in_array($current->toDateString(), $holidays);

            if (! $current->isSunday() && ! $isHoliday) {
                return $current->toDateString();
            }

            $current->addDay();
        }
    }

    /**
     * Calculate adjusted end date based on allowed total days.
     */
    public function calculateEndDate($startDate, int $totalDays, bool $excludeHolidays = true): string
    {
        if ($totalDays <= 0) {
            return $startDate;
        }

        $current = \Carbon\Carbon::parse($startDate);
        $daysCount = 0;

        $holidays = \App\Models\System\Holiday::whereYear('date', $current->year)
            ->pluck('date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->toArray();

        while (true) {
            $isWorkDay = true;
            if ($excludeHolidays) {
                if ($current->isSunday() || in_array($current->toDateString(), $holidays)) {
                    $isWorkDay = false;
                }
            }

            if ($isWorkDay) {
                $daysCount++;
            }

            if ($daysCount >= $totalDays) {
                return $current->toDateString();
            }

            $current->addDay();
        }
    }
}
