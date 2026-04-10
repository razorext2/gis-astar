<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Attendance\AttendanceCounterService;
use Livewire\Component;

class AttendanceOutCounter extends Component
{
    public string $counterKey = 'attendance-out';

    public function render()
    {
        $service = app(AttendanceCounterService::class);
        $count = $service->countAttendanceOutNotVerified();

        return view('livewire.utils.counter.attendance-out-counter', compact('count'));
    }
}
