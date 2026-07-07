<?php

/** Goal: Encapsulate authorization logic for Attendance Inquiries, Caller: Controller/Livewire, Deps: User, AttendanceInquiry */

namespace App\Policies;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use App\Models\User;

class AttendanceInquiryPolicy
{
    /**
     * Determine whether the user can view list of inquiries.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['attendance-inquiry-list-own', 'attendance-inquiry-approval-center']);
    }

    /**
     * Determine whether the user can create an inquiry.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('attendance-inquiry-create');
    }

    /**
     * Determine whether the user can view the specific inquiry.
     */
    public function view(User $user, AttendanceInquiry $inquiry): bool
    {
        if ($user->kode_pegawai === $inquiry->kode_pegawai) {
            return true;
        }

        return $user->hasPermissionTo('attendance-inquiry-approval-center');
    }

    /**
     * Determine whether the user can approve/reject the inquiry.
     */
    public function approve(User $user, AttendanceInquiry $inquiry): bool
    {
        if ($inquiry->status !== 'pending') {
            return false;
        }

        $placement = $inquiry->user?->pegawai?->jabatanRelasi?->placementRelasi;

        if ($placement && $placement->hrds->contains('id', $user->id)) {
            return true;
        }

        // Fallback: Super Admin / global permission (misal Admin pusat)
        return $user->hasPermissionTo('attendance-inquiry-approve-hrd');
    }
}
