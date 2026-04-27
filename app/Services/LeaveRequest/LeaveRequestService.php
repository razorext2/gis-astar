<?php
/** Goal: Centralize business logic and validation for Leave Requests, Caller: Livewire Components, Deps: User, LeaveRequest, LeaveType */

namespace App\Services\LeaveRequest;

use App\Models\LeaveRequest\LeaveRequest;
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
            $totalDays = $this->calculateTotalDays($data['start_date'], $data['end_date']);
            
            // 1. Validasi saldo jika tipe cuti memotong saldo tahunan
            $this->validateRequest($user, $data['leave_type_id'], $totalDays);

            // 2. Tentukan status awal
            $status = isset($data['backup_person_id']) && $data['backup_person_id'] 
                ? 'pending_backup' 
                : 'pending_spv';

            return LeaveRequest::create([
                'user_id' => $user->id,
                'leave_type_id' => $data['leave_type_id'],
                'backup_person_id' => $data['backup_person_id'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'total_days' => $totalDays,
                'reason' => $data['reason'],
                'status' => $status,
                'attachments' => $data['attachments'] ?? [],
            ]);
        });
    }

    /**
     * Process an approval action.
     */
    public function processAction(LeaveRequest $request, string $action, User $actor, ?string $note = null)
    {
        return DB::transaction(function () use ($request, $action, $actor, $note) {
            if ($action === 'approve') {
                $request->status = $this->calculateNextStatus($request);
            } elseif ($action === 'reject') {
                $request->status = 'rejected';
            } elseif ($action === 'cancel') {
                $request->status = 'cancelled';
            }

            $request->save();

            // History logging is handled by LeaveRequestObserver
            // We can attach the note to the request temporarily so the observer picks it up
            // or pass it via a property if needed. For now, we'll assume observer handles standard log.
            // If we want custom notes in history, we might need a manual log here or specialized property.
            $request->current_note = $note;
            $request->acted_by = $actor->id;
            
            return $request;
        });
    }

    /**
     * Determine where the request goes next.
     */
    protected function calculateNextStatus(LeaveRequest $request): string
    {
        return match ($request->status) {
            'pending_backup' => 'pending_spv',
            'pending_spv' => 'pending_hrd',
            'pending_hrd' => 'pending_management',
            'pending_management' => 'approved',
            default => $request->status
        };
    }

    /**
     * Helper to calculate total working days.
     */
    public function calculateTotalDays($startDate, $endDate): int
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        
        // Simple diff for now, could be improved to exclude weekends/holidays
        return $start->diffInDays($end) + 1;
    }

    /**
     * Validasi apakah seorang user boleh mengambil tipe cuti tertentu.
     *
     * @throws Exception
     */
    public function validateRequest(User $user, int $leaveTypeId, int $totalDays): bool
    {
        $leaveType = LeaveType::findOrFail($leaveTypeId);

        // 1. Validasi Cuti Tahunan (Potong Saldo)
        if ($leaveType->is_anual_deduction) {
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
}
