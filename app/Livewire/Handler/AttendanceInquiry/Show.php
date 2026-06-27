<?php

/** Goal: Display detail of own attendance inquiry, Caller: resources/views/dashboard/attendance-inquiry/show.blade.php, Deps: AttendanceInquiry */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use Livewire\Component;

class Show extends Component
{
    public AttendanceInquiry $inquiry;

    public function mount(AttendanceInquiry $inquiry): void
    {
        $this->inquiry = $inquiry;
    }

    public function render()
    {
        return view('livewire.handler.attendance-inquiry.show');
    }
}
