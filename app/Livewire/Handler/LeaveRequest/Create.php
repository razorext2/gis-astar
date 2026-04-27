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

    public $return_date;

    public $intersected_holidays = [];

    public $intersected_sundays = [];

    public $attachments = [];

    // Search for backup person
    public $search_backup = '';

    public $selected_leave_type;

    public $remaining_quota = 0;

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
        if ($propertyName === 'leave_type_id') {
            $this->loadLeaveTypeInfo();
        }

        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->calculateDays();
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

        if ($this->selected_leave_type->is_anual_deduction) {
            $balance = auth()->user()->currentLeaveBalance();
            $this->remaining_quota = $balance ? $balance->remaining_quota : 0;
        } else {
            // Untuk cuti khusus/ijin, gunakan default_days jika ada
            $this->remaining_quota = $this->selected_leave_type->default_days ?: 999;
        }

        $this->calculateDays();
    }

    protected function calculateDays()
    {
        if ($this->start_date && $this->end_date && $this->selected_leave_type) {
            $service = app(LeaveRequestService::class);

            // Logika: Cuti Melahirkan (CT-LAHIR) biasanya dihitung hari kalender murni.
            // Selain itu (Tahunan, Menikah, dll) dihitung hari kerja.
            $exclude = $this->selected_leave_type->code !== 'CT-LAHIR';

            $calculated = $service->calculateTotalDays($this->start_date, $this->end_date, $exclude);

            // Validasi Kuota
            if ($calculated > $this->remaining_quota) {
                // Otomatis geser end_date ke batas kuota maksimal
                $this->end_date = $service->calculateEndDate($this->start_date, $this->remaining_quota, $exclude);
                $this->total_days = $this->remaining_quota;

                $this->dispatch('swal', icon: 'warning', title: 'Kuota Terbatas', text: 'Durasi cuti melebihi kuota tersedia. Tanggal berakhir telah disesuaikan secara otomatis.');
            } else {
                $this->total_days = $calculated;
            }

            $this->return_date = $service->calculateReturnDate($this->end_date);

            // Tampilkan info hari libur hanya jika rumus yang digunakan adalah "Hari Kerja"
            if ($exclude) {
                $this->intersected_holidays = $service->getIntersectedHolidays($this->start_date, $this->end_date);

                // Hitung Hari Minggu
                $this->intersected_sundays = [];
                $current = \Carbon\Carbon::parse($this->start_date);
                $end = \Carbon\Carbon::parse($this->end_date);
                while ($current <= $end) {
                    if ($current->isSunday()) {
                        $this->intersected_sundays[] = $current->toDateString();
                    }
                    $current->addDay();
                }
            } else {
                $this->reset(['intersected_holidays', 'intersected_sundays']);
            }
        }
    }

    public function save(LeaveRequestService $service)
    {
        // Validasi Dinamis: Jika tipe cuti mewajibkan lampiran
        if ($this->selected_leave_type?->requires_attachment && empty($this->attachments)) {
            $this->addError('attachments', 'Tipe cuti ini mewajibkan lampiran (Surat Dokter/Dokumen Pendukung).');
            return;
        }

        $this->validate();

        $this->runSafely(function () use ($service) {
            $storedFiles = [];
            foreach ($this->attachments as $file) {
                // Simpan ke storage/app/cuti-attachments
                $storedFiles[] = $file->store('cuti-attachments');
            }

            $service->createRequest([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'attachments' => $storedFiles, // Kirim daftar path file
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

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }
}
