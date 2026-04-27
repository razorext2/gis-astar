<?php
/** Goal: Display list of own leave requests, Caller: resources/views/dashboard/leave-request/index.blade.php, Deps: User, LeaveRequest */

namespace App\Livewire\Handler\LeaveRequest;

use App\Models\LeaveRequest\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $leaveRequests = LeaveRequest::with(['leaveType', 'backupPerson'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.handler.leave-request.index', compact('leaveRequests'));
    }
}
