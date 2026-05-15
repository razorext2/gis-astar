<?php

/** Goal: Count employees currently on approved leave, Caller: Navigation sidebar, Deps: LeaveRequest */

namespace App\Livewire\Utils\Counter;

use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;

class LeaveRequestManageCounter extends Component
{
    public string $counterKey = 'leave-on-duty';

    public function render()
    {
        $count = LeaveRequest::where('status', 'approved')
            ->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString())
            ->count();

        return view('livewire.utils.counter.leave-request-manage-counter', compact('count'));
    }
}
