<?php

/** Goal: Form tambah data pasien baru, Caller: routes/web.php pasien.create */

namespace App\Livewire\Handler\Pasien;

use App\Enums\JenisKelamin;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    public ?string $nik = null;

    public ?string $no_rm = null;

    public ?string $nama = null;

    public ?string $jenis_kelamin = null;

    public ?string $tanggal_lahir = null;

    public ?string $alamat = null;

    public ?string $no_telepon = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    protected function rules(): array
    {
        return [
            'nik' => 'required|string|max:20|unique:pasien,nik',
            'no_rm' => 'nullable|string|max:20',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki_laki,perempuan',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];
    }

    protected array $messages = [
        'nik.required' => 'NIK wajib diisi.',
        'nik.unique' => 'NIK ini sudah terdaftar.',
        'nama.required' => 'Nama pasien wajib diisi.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
    ];

    /** Dipanggil dari Alpine/JS saat GPS berhasil detect atau marker dipindah */
    public function updateCoordinates(float $lat, float $lng): void
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function save(): void
    {
        $this->validate();

        $this->runSafely(function () {
            DB::transaction(function () {
                Pasien::create([
                    'id_user' => auth()->id(),
                    'nik' => $this->nik,
                    'no_rm' => $this->no_rm,
                    'nama' => $this->nama,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'alamat' => $this->alamat,
                    'no_telepon' => $this->no_telepon,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]);
            });

            $this->dispatch('swal', title: 'Berhasil', text: "Pasien {$this->nama} berhasil ditambahkan.", icon: 'success');
            $this->redirect(route('pasien.index'), navigate: true);
        }, 'Gagal menambah data pasien', ['action' => 'create pasien', 'user_id' => auth()->id()]);
    }

    public function render(): View
    {
        return view('livewire.handler.pasien.create', [
            'jenisKelaminList' => JenisKelamin::cases(),
        ]);
    }
}
