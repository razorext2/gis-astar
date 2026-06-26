<?php

/** Goal: Count pending leave requests awaiting current user's approval, Caller: Navigation sidebar, Deps: LeaveRequest */

namespace App\Livewire\Utils\Counter;

use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;

class LeaveRequestApprovalCenterCounter extends Component
{
    public string $counterKey = 'leave-approval';

    public function render()
    {
        $user = auth()->user();

        $count = LeaveRequest::whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->where(function ($q) use ($user) {
                $q->where(function ($sq) use ($user) {
                    $sq->where('status', 'pending_backup')->where('backup_person_id', $user->id);
                });

                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_spv')
                        ->whereHas('user.pegawai.jabatanRelasi.supervisors', fn ($jq) => $jq->where('users.id', $user->id));
                });

                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_hrd')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn ($jq) => $jq->where('users.id', $user->id));
                });

                $q->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_management')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.managements', fn ($jq) => $jq->where('users.id', $user->id));
                });
            })
            ->count();

        return view('livewire.utils.counter.leave-request-approval-center-counter', compact('count'));
    }
}
