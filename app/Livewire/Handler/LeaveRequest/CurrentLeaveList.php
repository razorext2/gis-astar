<?php

/** Goal: Display list of employees currently on leave today with Flight Board style, Caller: ManageBalances\Index, Deps: LeaveRequest, User */

namespace App\Livewire\Handler\LeaveRequest;

use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class CurrentLeaveList extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $today = now()->format('Y-m-d');

        $leaves = LeaveRequest::with(['user.pegawai', 'leaveType'])
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->whereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_pegawai', 'like', '%' . $this->search . '%');
            })
            ->latest('start_date')
            ->paginate(10);

        return view('livewire.handler.leave-request.current-leave-list', [
            'leaves' => $leaves,
        ]);
    }
}
