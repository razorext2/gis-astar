<?php

/** Goal: Display detail of own attendance inquiry, Caller: resources/views/dashboard/attendance-inquiry/show.blade.php, Deps: AttendanceInquiry */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Models\AttendanceInquiry\AttendanceInquiry;
use Illuminate\Support\Collection;
use Livewire\Component;

class Show extends Component
{
    public AttendanceInquiry $inquiry;

    public Collection $allowedHrds;

    public function mount(AttendanceInquiry $inquiry): void
    {
        $inquiry->load(['user.pegawai.jabatanRelasi.placementRelasi.hrds']);

        $this->inquiry = $inquiry;
        $this->allowedHrds = $inquiry->user
            ?->pegawai
            ?->jabatanRelasi
            ?->placementRelasi
            ?->hrds
            ?? collect();
    }

    public function render()
    {
        return view('livewire.handler.attendance-inquiry.show', [
            'allowedHrds' => $this->allowedHrds,
        ]);
    }
}
