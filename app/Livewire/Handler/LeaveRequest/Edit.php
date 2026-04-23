<?php

namespace App\Livewire\Handler\LeaveRequest;

/** Goal: Handle Leave Request edit form, Caller: resources/views/dashboard/leave-request/edit.blade.php, Deps: User, LeaveRequest, LeaveType */

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use HandlesErrors, WithFileUploads;

    public $requestId;
    public $leave_type_id;
    public $backup_person_id;
    public $start_date;
    public $end_date;
    public $total_days = 3;
    public $reason;

    public function mount($id)
    {
        $this->requestId = $id;
        
        // Dummy loading data
        $this->leave_type_id = 1;
        $this->backup_person_id = 10;
        $this->start_date = '2026-04-25';
        $this->end_date = '2026-04-27';
        $this->reason = 'Urusan keluarga di luar kota';
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->calculateDays();
        }
    }

    protected function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            $this->total_days = $start->diffInDays($end) + 1;
        }
    }

    public function update()
    {
        $this->runSafely(function() {
            sleep(1); 
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Perubahan berhasil disimpan.');
            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function render()
    {
        $leaveTypes = collect([
            (object)['id' => 1, 'name' => 'Cuti Tahunan'],
            (object)['id' => 2, 'name' => 'Cuti Menikah'],
        ]);

        $employees = collect([
            (object)['id' => 10, 'name' => 'Budi Santoso'],
            (object)['id' => 11, 'name' => 'Siti Aminah'],
        ]);

        return view('livewire.handler.leave-request.edit', compact('leaveTypes', 'employees'));
    }
}
