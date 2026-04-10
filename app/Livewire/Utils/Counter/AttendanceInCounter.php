<?php

namespace App\Livewire\Utils\Counter;

use App\Services\Attendance\AttendanceCounterService;
use Livewire\Component;

class AttendanceInCounter extends Component
{
    public string $counterKey = 'attendance-in';

    public function render()
    {
        $service = app(AttendanceCounterService::class);

        $count = $service->countAttendanceInNotVerified();

        return view('livewire.utils.counter.attendance-in-counter', compact('count'));
    }
}
