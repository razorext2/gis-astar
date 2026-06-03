<?php

/** Goal: Handle Leave Request borrowing form, Caller: resources/views/dashboard/leave-request/borrow.blade.php, Deps: User, LeaveRequest, LeaveType, LeaveRequestService */

namespace App\Livewire\Handler\LeaveRequest;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Concerns\HasLeaveRequestForm;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use App\Services\LeaveRequest\LeaveRequestService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Borrow extends Component
{
    use HandlesErrors, HasLeaveRequestForm, WithFileUploads;

    public $leave_type_id;

    public $backup_person_id;

    public $start_date;

    public $end_date;

    public $total_days = 0;

    public $reason;

    public $return_date;

    public $intersected_holidays = [];

    public $intersected_sundays = [];

    public $attachments = [];

    // Search for backup person
    public $search_backup = '';

    public $selected_leave_type;

    public $remaining_quota = 0;

    public $activeRequest = null;

    public $dateOverlapError = null;

    public $hrd_approvers = [];

    public $management_approvers = [];

    public function mount()
    {
        $this->activeRequest = auth()->user()->leaveRequests()
            ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->first();

        // Cek apakah punya akun pegawai?
        $user = auth()->user();

        if (! $user->pegawai) {
            return redirect()->route('leave-request.my-requests.index')->with('status', 'Akses ditolak, anda tidak memiliki akun pegawai.');
        }

        // Load Approvers
        $placement = $user->pegawai?->jabatanRelasi?->placementRelasi ?? null;
        if ($placement) {
            $this->hrd_approvers = $placement->hrds->pluck('name')->toArray();
            $this->management_approvers = $placement->managements->pluck('name')->toArray();
        }

        // Cek apakah join_date terisi
        if (! $user->join_date) {
            return redirect()->route('leave-request.my-requests.index')
                ->with('status', 'Data tanggal bergabung belum diisi. Hubungi HRD.');
        }

        // Cek apakah masa kerjanya sudah > 1 tahun
        if ($user->join_date) {
            $anniversary = \Carbon\Carbon::parse($user->join_date)->addYear();
            if (now()->greaterThanOrEqualTo($anniversary)) {
                return redirect()->route('leave-request.my-requests.index')
                    ->with('status', 'Anda sudah berhak menggunakan Cuti Tahunan biasa. Silakan gunakan menu Pengajuan Cuti.');
            }
        }

        // Set otomatis tipe cuti ke Cuti Tahunan (is_anual_deduction = true)
        $leaveType = LeaveType::where('is_anual_deduction', true)->first();
        if ($leaveType) {
            $this->leave_type_id = $leaveType->id;
            $this->loadLeaveTypeInfo();
        }
    }

    protected $rules = [
        'leave_type_id' => 'required|exists:tb_leave_types,id',
        'backup_person_id' => 'nullable|exists:users,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|min:10',
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3072',
    ];

    public function updated($propertyName)
    {
        // leave_type_id is fixed to annual leave in mount, but just in case
        if ($propertyName === 'leave_type_id') {
            $this->loadLeaveTypeInfo();
        }

        if (in_array($propertyName, ['start_date', 'end_date'])) {
            if ($propertyName === 'start_date' && ! $this->checkMinAdvanceDays()) {
                $this->start_date = null;
                $this->total_days = 0;
                $this->return_date = null;
                $this->reset(['intersected_holidays', 'intersected_sundays']);
                return;
            }

            $this->checkDateOverlap();
            if (! $this->dateOverlapError) {
                $this->calculateDays();
            } else {
                $this->total_days = 0;
                $this->return_date = null;
                $this->reset(['intersected_holidays', 'intersected_sundays']);
            }
        }

        if ($propertyName === 'search_backup') {
            $this->reset('backup_person_id');
        }
    }



    protected function loadLeaveTypeInfo()
    {
        if (! $this->leave_type_id) {
            $this->reset(['selected_leave_type', 'remaining_quota']);

            return;
        }

        $this->selected_leave_type = LeaveType::find($this->leave_type_id);

        // Get dynamic config for max borrow days
        $maxBorrowDays = (int) config('app.max_borrow_leave_days', 3);

        // Get total borrowed days that are approved or pending this year
        $borrowedThisYear = auth()->user()->leaveRequests()
            ->where('is_borrowed', true)
            ->whereYear('created_at', now()->year)
            ->whereNotIn('status', ['rejected', 'canceled'])
            ->sum('total_days');

        $this->remaining_quota = max(0, $maxBorrowDays - $borrowedThisYear);

        $this->calculateDays();
    }

    protected function calculateDays()
    {
        if ($this->start_date && $this->end_date && $this->selected_leave_type) {
            $service = app(LeaveRequestService::class);

            $exclude = ! $this->selected_leave_type->use_calendar_days;

            $calculated = $service->calculateTotalDays($this->start_date, $this->end_date, $exclude);

            // Validasi Batas Maksimal Kuota Pinjaman
            $maxAllowed = $this->remaining_quota;

            if ($calculated > $maxAllowed) {
                // Otomatis geser end_date ke batas maksimal
                $this->end_date = $service->calculateEndDate($this->start_date, $maxAllowed, $exclude);
                $this->total_days = $maxAllowed;

                $this->dispatch('swal', icon: 'warning', title: 'Batas Maksimal Pinjaman', text: 'Durasi cuti melebihi kuota pinjaman yang tersedia. Tanggal berakhir telah disesuaikan secara otomatis.');
            } else {
                $this->total_days = $calculated;
            }

            $this->return_date = $service->calculateReturnDate($this->end_date);

            if ($exclude) {
                $this->intersected_holidays = $service->getIntersectedHolidays($this->start_date, $this->end_date);

                $this->intersected_sundays = $service->getIntersectedSundays($this->start_date, $this->end_date);
            } else {
                $this->reset(['intersected_holidays', 'intersected_sundays']);
            }
        }
    }

    public function save(LeaveRequestService $service)
    {
        // Re-check active request for safety
        $hasActive = auth()->user()->leaveRequests()
            ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->exists();

        if ($hasActive) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda masih memiliki pengajuan cuti yang sedang dalam proses.');

            return;
        }

        if ($this->selected_leave_type?->requires_attachment && empty($this->attachments)) {
            $this->addError('attachments', 'Tipe cuti ini mewajibkan lampiran (Surat Dokter/Dokumen Pendukung).');

            return;
        }

        // Bypass the 1-year tenure validation because this is Pinjam Cuti.
        // We only check if they have enough borrow quota, which is handled in calculateDays and remaining_quota.

        // Validasi: tanggal mulai cuti minimal 7 hari dari hari pengajuan
        if (! $this->checkMinAdvanceDays()) {
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

        $maxAllowed = $this->remaining_quota; // batas dari config max_borrow_leave_days, bukan 6
        if ($this->total_days <= 0 || $this->total_days > $maxAllowed) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Hari cuti tidak valid atau melebihi kuota pinjaman Anda.');

            return;
        }

        $this->validate();

        $this->runSafely(function () use ($service) {
            $storedFiles = [];
            foreach ($this->attachments as $file) {
                $storedFiles[] = $file->store('cuti-attachments');
            }

            $request = $service->createRequest([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'attachments' => $storedFiles,
                'is_borrowed' => true,
                'total_days' => $this->total_days,
            ], auth()->user());

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan pinjam cuti berhasil dikirim.');

            return redirect()->route('leave-request.my-requests.show', $request->id);
        });
    }



    public function render()
    {
        // Only fetch the Annual Leave
        $leaveTypes = LeaveType::where('is_anual_deduction', true)->get();

        $employees = User::query()
            ->with('currentLeave')
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

        return view('livewire.handler.leave-request.borrow', [
            'leaveTypes' => $leaveTypes,
            'employees' => $employees,
        ]);
    }
}
