<?php

namespace App\Livewire\Handler\LeaveRequest;

/** Goal: Handle Leave Request creation form, Caller: resources/views/dashboard/leave-request/create.blade.php, Deps: User, LeaveRequest, LeaveType */

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

    public $leave_type_id;
    public $backup_person_id;
    public $start_date;
    public $end_date;
    public $total_days = 0;
    public $reason;
    public $attachments = [];

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

    public function save()
    {
        $this->runSafely(function() {
            // Logika simpan dummy
            sleep(1); 
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan cuti berhasil dikirim.');
            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function render()
    {
        // Dummy data untuk dropdown
        $leaveTypes = collect([
            (object)['id' => 1, 'name' => 'Cuti Tahunan', 'code' => 'CT-ANNUAL'],
            (object)['id' => 2, 'name' => 'Cuti Menikah', 'code' => 'CT-MENIKAH'],
            (object)['id' => 3, 'name' => 'Cuti Melahirkan', 'code' => 'CT-MELAHIRKAN'],
            (object)['id' => 4, 'name' => 'Cuti Kedukaan (Kemalangan)', 'code' => 'CT-DUKA'],
        ]);

        $employees = collect([
            (object)['id' => 10, 'name' => 'Budi Santoso', 'kode_pegawai' => 'PEG-001'],
            (object)['id' => 11, 'name' => 'Siti Aminah', 'kode_pegawai' => 'PEG-002'],
        ]);

        return view('livewire.handler.leave-request.create', compact('leaveTypes', 'employees'));
    }
}
