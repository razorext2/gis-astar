<?php

/** Goal: Automate history logging and quota deduction for Leave Requests, Caller: AppServiceProvider, Deps: LeaveRequest, LeaveRequestHistory, LeaveBalance */

namespace App\Observers;

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveRequestHistory;

class LeaveRequestObserver
{
    /**
     * Handle the LeaveRequest "created" event.
     */
    public function created(LeaveRequest $request): void
    {
        LeaveRequestHistory::create([
            'leave_request_id' => $request->id,
            'acted_by'         => auth()->id() ?? $request->user_id,
            'action'           => 'submit',
            'status_from'      => null, // nullable: tidak ada status sebelumnya saat submit pertama
            'status_to'        => $request->status,
            'note'             => 'Pengajuan diajukan.',
        ]);
    }

    /**
     * Handle the LeaveRequest "updated" event.
     */
    public function updated(LeaveRequest $request): void
    {
        if ($request->isDirty('status')) {
            $newStatus = $request->status;
            $oldStatus = $request->getOriginal('status');

            // Log History
            LeaveRequestHistory::create([
                'leave_request_id' => $request->id,
                'acted_by' => $request->acted_by ?? auth()->id() ?? $request->user_id,
                'action' => $this->resolveActionName($newStatus, $request->acted_by ?? auth()->id()),
                'status_from' => $oldStatus,
                'status_to' => $newStatus,
                'note' => $request->current_note ?? 'Status diperbarui.',
            ]);

        }
    }

    protected function resolveActionName(string $status, mixed $actedBy = null): string
    {
        return match ($status) {
            'approved' => 'final_approve',
            'rejected' => $actedBy === null ? 'auto_reject' : 'reject',
            'canceled' => 'cancel',
            default => 'approve',
        };
    }
}
