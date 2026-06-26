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
        $today = \Carbon\Carbon::today()->toDateString();
        $nextWeek = \Carbon\Carbon::today()->addDays(7)->toDateString();

        $leaves = LeaveRequest::with(['user.pegawai', 'leaveType'])
            ->where('status', 'approved')
            ->whereDate('end_date', '>=', $today)
            ->whereDate('start_date', '<=', $nextWeek)
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($sub) {
                    $sub->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('kode_pegawai', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('livewire.handler.leave-request.current-leave-list', [
            'leaves' => $leaves,
        ]);
    }
}
