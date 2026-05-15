<?php

/** Goal: Handle Leave Request edit form, Caller: resources/views/dashboard/leave-request/edit.blade.php, Deps: User, LeaveRequest, LeaveType, LeaveRequestService */

namespace App\Livewire\Handler\LeaveRequest;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use App\Services\LeaveRequest\LeaveRequestService;
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

    public $total_days = 0;

    public $reason;

    public $attachments = [];

    public $existingAttachments = [];

    public $remaining_quota = 0;

    public $intersectedHolidays = [];

    public $search_backup = '';

    public function mount($id)
    {
        $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($id);

        // check status
        app(LeaveRequestService::class)->checkStatus($request->status, $request->user_id);

        $this->requestId = $request->id;
        $this->leave_type_id = $request->leave_type_id;
        $this->backup_person_id = $request->backup_person_id;
        $this->start_date = $request->start_date->format('Y-m-d');
        $this->end_date = $request->end_date->format('Y-m-d');
        $this->total_days = $request->total_days;
        $this->reason = $request->reason;
        $this->existingAttachments = $request->attachments ?? [];

        if ($request->backupPerson) {
            $this->search_backup = $request->backupPerson->name;
        }

        $this->loadInitialData();
    }

    protected function loadInitialData()
    {
        $this->updateQuota();
        $this->calculateDays();
    }

    public function updatedLeaveTypeId()
    {
        $this->updateQuota();
        $this->calculateDays();
    }

    public function updatedStartDate()
    {
        $this->calculateDays();
    }

    public function updatedEndDate()
    {
        $this->calculateDays();
    }

    public function updatedSearchBackup()
    {
        $this->reset('backup_person_id');
    }

    protected function updateQuota()
    {
        if (! $this->leave_type_id) {
            $this->remaining_quota = 0;

            return;
        }

        $leaveType = LeaveType::find($this->leave_type_id);
        if (! $leaveType) {
            return;
        }

        if ($leaveType->is_anual_deduction) {
            $balance = auth()->user()->currentLeaveBalance();
            $this->remaining_quota = $balance ? $balance->remaining_quota : 0;
        } else {
            // Logic for Special Leave: default_quota - usage this year
            $usage = auth()->user()->getLeaveUsageCount($leaveType->code);

            // Exclude current request from usage count if we are editing the same type
            if ($this->requestId) {
                $currentRequest = LeaveRequest::find($this->requestId);
                if ($currentRequest && $currentRequest->leave_type_id == $this->leave_type_id) {
                    $usage -= $currentRequest->total_days;
                }
            }

            $this->remaining_quota = max(0, ($leaveType->default_days ?? 0) - $usage);
        }
    }

    protected function calculateDays()
    {
        if (! $this->start_date || ! $this->end_date || ! $this->leave_type_id) {
            $this->total_days = 0;
            $this->intersectedHolidays = [];

            return;
        }

        $service = app(LeaveRequestService::class);
        $leaveType = LeaveType::find($this->leave_type_id);

        // Pilih rumus: Hari Kerja (Cuti Umum) atau Hari Kalender (Cuti Khusus/Melahirkan)
        $useBusinessDays = ! ($leaveType && $leaveType->code === 'CT-MELAHIRKAN');

        // Tentukan batas maksimal hari
        $maxAllowedDays = $this->remaining_quota;
        if ($leaveType && $leaveType->is_anual_deduction) {
            $maxAllowedDays = min($this->remaining_quota, 6);
        }

        $this->total_days = $service->calculateTotalDays($this->start_date, $this->end_date, $useBusinessDays);
        $this->intersectedHolidays = $service->getIntersectedHolidays($this->start_date, $this->end_date);

        // Langsung sesuaikan jika melebihi batas (Kuota atau Aturan 6 Hari)
        if ($this->total_days > $maxAllowedDays) {
            $this->end_date = $service->calculateEndDate($this->start_date, $maxAllowedDays, $useBusinessDays);
            $this->total_days = $maxAllowedDays;

            $title = $maxAllowedDays < $this->remaining_quota ? 'Batas Maksimal' : 'Kuota Terlampaui';
            $text = $maxAllowedDays < $this->remaining_quota
                ? 'Cuti tahunan maksimal adalah 6 hari per pengajuan. Durasi telah disesuaikan.'
                : "Durasi disesuaikan menjadi maksimal {$this->remaining_quota} hari sesuai sisa kuota Anda.";

            $this->dispatch('swal', icon: 'warning', title: $title, text: $text);
        }
    }

    public function removeAttachment($index, $isExisting = false)
    {
        if ($isExisting) {
            unset($this->existingAttachments[$index]);
            $this->existingAttachments = array_values($this->existingAttachments);
        } else {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function update(LeaveRequestService $service)
    {
        $leaveType = LeaveType::findOrFail($this->leave_type_id);

        $rules = [
            'leave_type_id' => 'required|exists:tb_leave_types,id',
            'backup_person_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf|max:3072',
        ];

        // Validasi lampiran jika wajib
        if ($leaveType->requires_attachment && empty($this->attachments) && empty($this->existingAttachments)) {
            $this->addError('attachments', 'Lampiran dokumen wajib diunggah untuk tipe cuti ini.');

            return;
        }

        $this->validate($rules);

        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($this->requestId);

            // Simpan file baru
            $storedFiles = $this->existingAttachments;
            foreach ($this->attachments as $attachment) {
                $path = $attachment->store('cuti-attachments', 'local');
                $storedFiles[] = $path;
            }

            $request->update([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'return_date' => $service->calculateReturnDate($this->end_date),
                'total_days' => $this->total_days,
                'reason' => $this->reason,
                'attachments' => $storedFiles,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Perubahan pengajuan berhasil disimpan.');

            return redirect()->route('leave-request.my-requests.index');
        });
    }

    public function render()
    {
        $leaveTypes = LeaveType::all();
        $employees = User::query()
            ->has('pegawai')
            ->where('id', '!=', auth()->id())
            ->where('is_active', true)
            ->when($this->search_backup, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search_backup.'%')
                        ->orWhere('kode_pegawai', 'like', '%'.$this->search_backup.'%');
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get();

        return view('livewire.handler.leave-request.edit', [
            'leaveTypes' => $leaveTypes,
            'employees' => $employees,
        ]);
    }
}
