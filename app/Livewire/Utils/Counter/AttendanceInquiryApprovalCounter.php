<?php

/** Goal: Count pending attendance inquiries awaiting HRD approval, Caller: Navigation sidebar, Deps: AttendanceInquiry */

namespace App\Livewire\Utils\Counter;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use Livewire\Component;

class AttendanceInquiryApprovalCounter extends Component
{
    public string $counterKey = 'attendance-inquiry-approval';

    public function render()
    {
        $count = AttendanceInquiry::where('status', 'pending')->count();

        return view('livewire.utils.counter.attendance-inquiry-approval-counter', compact('count'));
    }
}
