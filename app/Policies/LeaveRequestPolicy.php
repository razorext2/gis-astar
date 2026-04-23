<?php

namespace App\Policies;

/** Goal: Encapsulate approval logic for Leave Requests, Caller: Controller/Livewire, Deps: User, LeaveRequest */

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeaveRequestPolicy
{
    /**
     * Determine whether the user can approve the leave request.
     */
    public function approve(User $user, LeaveRequest $leaveRequest): Response
    {
        return match ($leaveRequest->status) {
            // 1. Jika status pending_backup, yang boleh approve hanya user backup
            'pending_backup' => $user->id === $leaveRequest->backup_person_id
                ? Response::allow()
                : Response::deny('Hanya orang yang ditunjuk sebagai backup yang dapat menyetujui tahap ini.'),

            // 2. Jika status pending_spv, yang boleh approve hanya atasan langsungnya.
            // Jika pemohon tidak memiliki atasan langsung (level Kepala), maka otoritas persetujuan ada di Manajemen.
            'pending_spv' => ($leaveRequest->user->direct_supervisor
                ? $user->id === $leaveRequest->user->direct_supervisor->id
                : $user->can('leave-approve-management'))
                ? Response::allow()
                : Response::deny('Hanya atasan langsung atau Manajemen yang dapat menyetujui tahap ini.'),

            // 3. Jika status pending_hrd, yang boleh approve hanya user yang punya permission HRD
            'pending_hrd' => $user->can('leave-approve-hrd')
                ? Response::allow()
                : Response::deny('Anda tidak memiliki izin (HRD) untuk menyetujui tahap ini.'),

            // 4. Jika status pending_management, yang boleh approve hanya user yang punya permission Management
            'pending_management' => $user->can('leave-approve-management')
                ? Response::allow()
                : Response::deny('Anda tidak memiliki izin (Management) untuk menyetujui tahap ini.'),

            default => Response::deny('Pengajuan ini sedang tidak dalam tahap yang memerlukan persetujuan Anda atau sudah diproses.'),
        };
    }

    /**
     * Determine whether the user can view the specific leave request.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        // Pemohon, Backup, Atasan, atau HRD/Management bisa melihat
        return $user->id === $leaveRequest->user_id
            || $user->id === $leaveRequest->backup_person_id
            || optional($leaveRequest->user->direct_supervisor)->id === $user->id
            || $user->hasAnyPermission(['leave-view-all', 'leave-approval-center']);
    }
}
