<?php

namespace App\Livewire\Handler\LeaveRequest;

/** Goal: Handle Leave Request list for current user, Caller: resources/views/dashboard/leave-request/index.blade.php, Deps: User, LeaveRequest */

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;

class Index extends Component
{
    use HandlesErrors;

    public function render()
    {
        // Data dummy untuk perancangan UI
        $leaveRequests = collect([
            (object) [
                'id' => 1,
                'leave_type' => (object) ['name' => 'Cuti Tahunan'],
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(4),
                'total_days' => 3,
                'status' => 'pending_spv',
                'reason' => 'Urusan keluarga di luar kota',
                'created_at' => now()->subDays(1),
            ],
            (object) [
                'id' => 2,
                'leave_type' => (object) ['name' => 'Cuti Menikah'],
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(7),
                'total_days' => 3,
                'status' => 'approved',
                'reason' => 'Acara pernikahan pribadi',
                'created_at' => now()->subDays(15),
            ],
            (object) [
                'id' => 3,
                'leave_type' => (object) ['name' => 'Sakit'],
                'start_date' => now()->subDays(2),
                'end_date' => now()->subDays(2),
                'total_days' => 1,
                'status' => 'rejected',
                'reason' => 'Demam tinggi',
                'created_at' => now()->subDays(2),
            ],
        ]);

        return view('livewire.handler.leave-request.index', compact('leaveRequests'));
    }
}
