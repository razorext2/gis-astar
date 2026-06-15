<?php

namespace App\Policies;

/** Goal: Encapsulate authorization logic for Leave Requests (relasi-based), Caller: Controller/Livewire, Deps: User, LeaveRequest */

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeaveRequestPolicy
{
    /**
     * Determine whether the user can view the approval center index.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['leave-approval-center', 'leave-list-all']);
    }

    /**
     * Determine whether the user can manage leave types and balances.
     */
    public function manage(User $user): bool
    {
        return $user->hasAnyPermission(['leave-balance-manage', 'leave-type-manage']);
    }

    /**
     * Determine whether the user can view the specific leave request.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        // Pemohon sendiri
        if ($user->id === $leaveRequest->user_id) {
            return true;
        }

        // Backup person
        if ($user->id === $leaveRequest->backup_person_id) {
            return true;
        }

        // Atasan langsung (via jabatan supervisors)
        $jabatan = $leaveRequest->user->pegawai?->jabatanRelasi;
        if ($jabatan && $jabatan->supervisors->contains('id', $user->id)) {
            return true;
        }

        // HRD atau Management di placement pemohon
        $placement = $jabatan?->placementRelasi;
        if ($placement) {
            if ($placement->hrds->contains('id', $user->id) || $placement->managements->contains('id', $user->id)) {
                return true;
            }
        }

        // Global permission
        return $user->hasPermissionTo('leave-list-all');
    }

    /**
     * Determine whether the user can approve the leave request.
     */
    public function approve(User $user, LeaveRequest $leaveRequest): Response
    {
        return match ($leaveRequest->status) {
            'pending_backup' => $user->id === $leaveRequest->backup_person_id
                ? Response::allow()
                : Response::deny('Hanya orang yang ditunjuk sebagai backup yang dapat menyetujui tahap ini.'),

            'pending_spv' => (bool) $leaveRequest->user->pegawai?->jabatanRelasi?->supervisors->contains('id', $user->id)
                ? Response::allow()
                : Response::deny('Hanya atasan langsung yang dapat menyetujui tahap ini.'),

            'pending_hrd' => (bool) $leaveRequest->user->pegawai?->jabatanRelasi?->placementRelasi?->hrds->contains('id', $user->id)
                ? Response::allow()
                : Response::deny('Anda tidak terdaftar sebagai HRD untuk placement pemohon ini.'),

            'pending_management' => (bool) $leaveRequest->user->pegawai?->jabatanRelasi?->placementRelasi?->managements->contains('id', $user->id)
                ? Response::allow()
                : Response::deny('Anda tidak terdaftar sebagai Manajemen untuk placement pemohon ini.'),

            default => Response::deny('Pengajuan ini sedang tidak dalam tahap yang memerlukan persetujuan Anda atau sudah diproses.'),
        };
    }
}
