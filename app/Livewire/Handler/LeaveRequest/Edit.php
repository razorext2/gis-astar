<?php
/** Goal: Handle Leave Request edit form, Caller: resources/views/dashboard/leave-request/edit.blade.php, Deps: User, LeaveRequest, LeaveType, LeaveRequestService */

namespace App\Livewire\Handler\LeaveRequest;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use App\Services\LeaveRequest\LeaveRequestService;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public $requestId;
    public $leave_type_id;
    public $backup_person_id;
    public $start_date;
    public $end_date;
    public $total_days = 0;
    public $reason;

    public function mount($id)
    {
        $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($id);
        
        // Cek apakah masih boleh di-edit (hanya jika status pending_backup atau pending_spv)
        if (!in_array($request->status, ['pending_backup', 'pending_spv'])) {
            session()->flash('error', 'Pengajuan yang sudah diproses oleh HRD tidak dapat diubah.');
            return redirect()->route('leave-request.my-requests.index');
        }

        $this->requestId = $request->id;
        $this->leave_type_id = $request->leave_type_id;
        $this->backup_person_id = $request->backup_person_id;
        $this->start_date = $request->start_date->format('Y-m-d');
        $this->end_date = $request->end_date->format('Y-m-d');
        $this->total_days = $request->total_days;
        $this->reason = $request->reason;
    }

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
    }

    protected function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $service = app(LeaveRequestService::class);
            $this->total_days = $service->calculateTotalDays($this->start_date, $this->end_date);
        }
    }

    public function update(LeaveRequestService $service)
    {
        $this->validate();

        $this->runSafely(function() use ($service) {
            $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($this->requestId);
            
            $request->update([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $this->total_days,
                'reason' => $this->reason,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Perubahan pengajuan berhasil disimpan.');
            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function render()
    {
        $leaveTypes = LeaveType::all();
        $employees = User::where('id', '!=', auth()->id())->where('is_active', true)->get();

        return view('livewire.handler.leave-request.edit', [
            'leaveTypes' => $leaveTypes,
            'employees' => $employees,
        ]);
    }
}
