<?php

/** Goal: Handle Attendance Inquiry creation form, Caller: resources/views/dashboard/attendance-inquiry/create.blade.php, Deps: AttendanceInquiry, HandlesErrors, WithFileUploads */

namespace App\Livewire\Handler\AttendanceInquiry;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

    public $type_absen = 'in';

    public $position_status = 3; // default: onsite

    public $waktu_absen;

    public $keterangan;

    public $no_vt;

    public $bukti = [];

    public $newBukti = [];

    public $longitude;

    public $latitude;

    public function mount(): void
    {
        $this->waktu_absen = now()->format('Y-m-d\TH:i');
    }

    protected $rules = [
        'type_absen' => 'required|in:in,out',
        'position_status' => 'required|in:1,2,3',
        'waktu_absen' => 'required|date',
        'keterangan' => 'required|string|min:10',
        'no_vt' => 'nullable|string|max:32',
        'bukti' => 'required|array|min:1',
        'bukti.*' => 'required|file|image|mimes:jpg,jpeg,png|max:3072',
        'longitude' => 'nullable|string',
        'latitude' => 'nullable|string',
    ];

    public function updatedNewBukti()
    {
        $this->validate([
            'newBukti.*' => 'required|file|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $this->bukti = array_values(array_merge($this->bukti, $this->newBukti));
        $this->newBukti = [];
    }

    public function removeBukti($index)
    {
        if (isset($this->bukti[$index])) {
            $file = $this->bukti[$index];
            if (method_exists($file, 'delete')) {
                try {
                    $file->delete();
                } catch (\Exception $e) {
                    // ignore if delete fails
                }
            }
            unset($this->bukti[$index]);
            $this->bukti = array_values($this->bukti);
        }
    }

    public function save()
    {
        // Auto-extract VT number if VT is in keterangan and no_vt is empty
        if (empty($this->no_vt) && ! empty($this->keterangan)) {
            if (preg_match('/\bVT\s*-?\s*(\d+)\b/i', $this->keterangan, $m)) {
                $this->no_vt = 'VT-'.$m[1];
            }
        }

        $this->validate();

        $user = auth()->user();
        if (! $user->kode_pegawai) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Anda tidak memiliki akun pegawai.');

            return;
        }

        $this->runSafely(function () use ($user) {
            $storedFiles = [];
            foreach ($this->bukti as $file) {
                $storedFiles[] = $file->store('bukti-inquiries', 'public');
            }

            $inquiry = AttendanceInquiry::create([
                'kode_pegawai' => $user->kode_pegawai,
                'type_absen' => $this->type_absen,
                'position_status' => $this->position_status,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'waktu_absen' => $this->waktu_absen,
                'keterangan' => $this->keterangan,
                'no_vt' => $this->no_vt,
                'bukti' => $storedFiles,
                'status' => 'pending',
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Laporan absensi berhasil diajukan.');

            return redirect()->route('attendance-inquiry.my-inquiries.show', $inquiry->id);
        }, 'Gagal menyimpan pengajuan laporan absensi.');
    }

    public function render()
    {
        return view('livewire.handler.attendance-inquiry.create');
    }
}
