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

    public $activeRequest = null;

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
            return redirect()->route('leave-request.my-requests.index')->with('status', 'Akses ditolak, anda tidak memiliki akun pegawai. Silahkan buat pengajuan menggunakan akun pegawai.');
        }

        // Load Approvers
        $placement = $user->pegawai->jabatanRelasi->placementRelasi ?? null;
        if ($placement) {
            $this->hrd_approvers = $placement->hrds->pluck('name')->toArray();
            $this->management_approvers = $placement->managements->pluck('name')->toArray();
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
            // Logic for Special Leave: default_quota - usage this year
            $usage = auth()->user()->getLeaveUsageCount($this->selected_leave_type->code);
            $this->remaining_quota = max(0, ($this->selected_leave_type->default_days ?? 0) - $usage);
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

            // Tentukan batas maksimal: 6 hari untuk cuti tahunan, atau sisa kuota
            $maxAllowed = $this->remaining_quota;
            if ($this->selected_leave_type->is_anual_deduction) {
                $maxAllowed = min($this->remaining_quota, 6);
            }

            // Validasi Batas (Kuota atau Aturan 6 Hari)
            if ($calculated > $maxAllowed) {
                // Otomatis geser end_date ke batas maksimal
                $this->end_date = $service->calculateEndDate($this->start_date, $maxAllowed, $exclude);
                $this->total_days = $maxAllowed;

                $title = $maxAllowed < $this->remaining_quota ? 'Batas Maksimal' : 'Kuota Terbatas';
                $text = $maxAllowed < $this->remaining_quota
                    ? 'Pengajuan cuti tahunan maksimal adalah 6 hari kerja. Tanggal berakhir telah disesuaikan.'
                    : 'Durasi cuti melebihi kuota tersedia. Tanggal berakhir telah disesuaikan secara otomatis.';

                $this->dispatch('swal', icon: 'warning', title: $title, text: $text);
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
        // Re-check active request for safety
        $hasActive = auth()->user()->leaveRequests()
            ->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->exists();

        if ($hasActive) {
            $this->dispatch('swal', icon: 'error', title: 'Akses Ditolak', text: 'Anda masih memiliki pengajuan cuti yang sedang dalam proses.');

            return;
        }

        // Validasi Dinamis: Jika tipe cuti mewajibkan lampiran
        if ($this->selected_leave_type?->requires_attachment && empty($this->attachments)) {
            $this->addError('attachments', 'Tipe cuti ini mewajibkan lampiran (Surat Dokter/Dokumen Pendukung).');

            return;
        }

        // Validasi Cuti Tahunan: Masa kerja minimal 1 tahun
        if ($this->selected_leave_type?->is_anual_deduction) {
            $user = auth()->user();
            if ($user->join_date) {
                $anniversary = \Carbon\Carbon::parse($user->join_date)->addYear();
                $startDate = \Carbon\Carbon::parse($this->start_date);
                if ($startDate->lessThan($anniversary)) {
                    $formattedAnniversary = $anniversary->locale('id')->isoFormat('DD MMMM YYYY');
                    $this->dispatch('swal', icon: 'error', title: 'Belum Memenuhi Syarat', text: "Cuti tahunan baru dapat digunakan setelah masa kerja 1 tahun (Mulai {$formattedAnniversary}).");

                    return;
                }
            }
        }

        $this->validate();

        $this->runSafely(function () use ($service) {
            $storedFiles = [];
            foreach ($this->attachments as $file) {
                // Simpan ke storage/app/cuti-attachments
                $storedFiles[] = $file->store('cuti-attachments');
            }

            $request = $service->createRequest([
                'leave_type_id' => $this->leave_type_id,
                'backup_person_id' => $this->backup_person_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'reason' => $this->reason,
                'attachments' => $storedFiles, // Kirim daftar path file
            ], auth()->user());

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengajuan cuti berhasil dikirim.');

            return redirect()->route('leave-request.my-requests.show', $request->id);
        });
    }

    public function selectBackupPerson($id, $name)
    {
        $this->backup_person_id = $id;
        $this->search_backup = $name;
    }

    public function showOnLeaveError($name)
    {
        $this->dispatch('swal', icon: 'error', title: 'Tidak Dapat Dipilih', text: "{$name} saat ini sedang dalam masa cuti dan tidak dapat dijadikan personel backup.");
    }

    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    public function render()
    {
        $leaveTypes = LeaveType::all();

        // Ambil semua user kecuali diri sendiri untuk backup
        $employees = User::query()
            ->with('currentLeave')
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
