<?php

/** Goal: Handle Leave Request creation form, Caller: resources/views/dashboard/leave-request/create.blade.php, Deps: User, LeaveRequest, LeaveType, LeaveRequestService */

namespace App\Livewire\Handler\LeaveRequest;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use App\Services\LeaveRequest\LeaveRequestService;
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

    // Search for backup person
    public $search_backup = '';

    protected $rules = [
        'leave_type_id' => 'required|exists:tb_leave_types,id',
        'backup_person_id' => 'nullable|exists:users,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|min:10',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->calculateDays();
        }

        if ($propertyName === 'search_backup') {
            $this->reset('backup_person_id');
        }
    }

    protected function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $service = app(LeaveRequestService::class);
            $this->total_days = $service->calculateTotalDays($this->start_date, $this->end_date);
        }
    }

    public function save(LeaveRequestService $service)
    {
        $this->validate();

        $this->runSafely(function () use ($service) {
            $service->createRequest([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'attachments' => $this->attachments, // Handle file upload logic later if needed
            ], auth()->user());

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan cuti berhasil dikirim.');

            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function render()
    {
        $leaveTypes = LeaveType::all();

        // Ambil semua user kecuali diri sendiri untuk backup
        $employees = User::query()
            ->has('pegawai') // Pastikan memiliki relasi pegawai
            ->where('id', '!=', auth()->id())
            ->where('is_active', true)
            ->when($this->search_backup, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search_backup.'%')
                        ->orWhere('kode_pegawai', 'like', '%'.$this->search_backup.'%');
                });
            })
            ->orderBy('name')
            ->limit(10) // Batasi hasil agar tidak terlalu banyak
            ->get();

        return view('livewire.handler.leave-request.create', [
            'leaveTypes' => $leaveTypes,
            'employees' => $employees,
        ]);
    }
}
