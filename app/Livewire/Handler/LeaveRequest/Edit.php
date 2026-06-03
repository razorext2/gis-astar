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

    public $intersected_sundays = [];

    public $search_backup = '';

    public $dateOverlapError = null;

    public $return_date;

    public function mount($id)
    {
        $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($id);

        // Guard: Hanya bisa edit jika masih pending_backup
        if ($request->status !== 'pending_backup') {
            abort(403, 'Pengajuan tidak dalam status yang bisa diedit.');
        }

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

    public function updated($propertyName)
    {
        if ($propertyName === 'leave_type_id') {
            $this->updateQuota();
            $this->calculateDays();
        }

        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->checkDateOverlap();
            if (! $this->dateOverlapError) {
                $this->calculateDays();
            } else {
                $this->total_days = 0;
                $this->return_date = null;
                $this->intersectedHolidays = [];
                $this->intersected_sundays = [];
            }
        }

        if ($propertyName === 'search_backup') {
            $this->reset('backup_person_id');
        }
    }

    protected function checkDateOverlap(): void
    {
        $this->dateOverlapError = null;

        if (! $this->start_date || ! $this->end_date) {
            return;
        }

        if (\Carbon\Carbon::parse($this->start_date)->greaterThan(\Carbon\Carbon::parse($this->end_date))) {
            $this->dateOverlapError = 'Tanggal mulai tidak boleh lebih besar dari tanggal berakhir.';

            return;
        }

        $overlap = auth()->user()->leaveRequests()
            ->where('id', '!=', $this->requestId)
            ->whereNotIn('status', ['rejected', 'auto_reject', 'canceled'])
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            })
            ->first();

        if ($overlap) {
            $from = \Carbon\Carbon::parse($overlap->start_date)->locale('id')->isoFormat('D MMM YYYY');
            $to = \Carbon\Carbon::parse($overlap->end_date)->locale('id')->isoFormat('D MMM YYYY');
            $this->dateOverlapError = "Tanggal bertabrakan dengan pengajuan cuti yang sudah ada ({$from} s/d {$to}).";
        }
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
            $quota = $balance ? $balance->remaining_quota : 0;

            if ($this->requestId) {
                $currentRequest = LeaveRequest::find($this->requestId);
                if ($currentRequest && $currentRequest->leave_type_id == $this->leave_type_id) {
                    $quota += $currentRequest->total_days;
                }
            }

            $this->remaining_quota = $quota;
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
            $this->return_date = null;
            $this->intersectedHolidays = [];
            $this->intersected_sundays = [];

            return;
        }

        $service = app(LeaveRequestService::class);
        $leaveType = LeaveType::find($this->leave_type_id);

        // Pilih rumus: Hari Kerja (Cuti Umum) atau Hari Kalender (Cuti Khusus/Melahirkan)
        $useBusinessDays = ! ($leaveType && $leaveType->use_calendar_days);

        // Tentukan batas maksimal hari
        $maxAllowedDays = $this->remaining_quota;
        if ($leaveType && $leaveType->is_anual_deduction) {
            $maxAllowedDays = min($this->remaining_quota, 6);
        }

        $this->total_days = $service->calculateTotalDays($this->start_date, $this->end_date, $useBusinessDays);

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

        $this->return_date = $service->calculateReturnDate($this->end_date);

        if ($useBusinessDays) {
            $this->intersectedHolidays = $service->getIntersectedHolidays($this->start_date, $this->end_date);

            $this->intersected_sundays = $service->getIntersectedSundays($this->start_date, $this->end_date);
        } else {
            $this->intersectedHolidays = [];
            $this->intersected_sundays = [];
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
            'leave_type_id'  => 'required|exists:tb_leave_types,id',
            'backup_person_id' => 'nullable|exists:users,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'reason'         => 'required|min:10',
            'attachments.*'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
        ];

        if ($leaveType->requires_attachment && empty($this->attachments) && empty($this->existingAttachments)) {
            $this->addError('attachments', 'Lampiran dokumen wajib diunggah untuk tipe cuti ini.');

            return;
        }

        // Re-validate Overlap
        $this->checkDateOverlap();
        if ($this->dateOverlapError) {
            $this->addError('start_date', $this->dateOverlapError);
            $this->addError('end_date', $this->dateOverlapError);
            $this->dispatch('swal', icon: 'error', title: 'Tanggal Tidak Valid', text: $this->dateOverlapError);

            return;
        }

        // Re-fetch quota fresh dari DB agar tidak stale
        $this->updateQuota();

        // Re-validate Total Days & Quota Limit
        $maxAllowed = $this->remaining_quota;
        if ($leaveType->is_anual_deduction) {
            $maxAllowed = min($this->remaining_quota, 6);
        }

        if ($this->total_days > $maxAllowed || $this->total_days <= 0) {
            $this->dispatch('swal', icon: 'error', title: 'Durasi Tidak Valid', text: 'Total hari cuti melebihi batas maksimal atau tidak valid.');

            return;
        }

        $this->validate($rules);

        $this->runSafely(function () use ($service) {
            $request = LeaveRequest::where('user_id', auth()->id())->findOrFail($this->requestId);

            // M1: Re-check status — pastikan belum diproses approver
            if ($request->status !== 'pending_backup') {
                $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pengajuan sudah tidak dapat diubah karena sudah diproses oleh approver.');

                return redirect()->route('leave-request.my-requests.index');
            }

            // Bersihkan file lama yang dihapus dari server
            $originalFiles = $request->attachments ?? [];
            $removedFiles = array_diff($originalFiles, $this->existingAttachments);
            foreach ($removedFiles as $file) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($file);
            }

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
        $leaveTypes = LeaveType::select(['id', 'name', 'code', 'is_anual_deduction', 'default_days', 'requires_attachment', 'use_calendar_days'])->get();
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
