<?php

/** Goal: Form edit data pasien, Caller: routes/web.php pasien.edit */

namespace App\Livewire\Handler\Pasien;

use App\Enums\JenisKelamin;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public Pasien $pasien;

    public ?string $nik = null;

    public ?string $no_rm = null;

    public ?string $nama = null;

    public ?string $jenis_kelamin = null;

    public ?string $tanggal_lahir = null;

    public ?string $alamat = null;

    public ?string $no_telepon = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    public function mount(Pasien $pasien): void
    {
        $this->pasien = $pasien;
        $this->nik = $pasien->nik;
        $this->no_rm = $pasien->no_rm;
        $this->nama = $pasien->nama;
        $this->jenis_kelamin = $pasien->jenis_kelamin->value;
        $this->tanggal_lahir = $pasien->tanggal_lahir?->format('Y-m-d');
        $this->alamat = $pasien->alamat;
        $this->no_telepon = $pasien->no_telepon;
        $this->latitude = $pasien->latitude;
        $this->longitude = $pasien->longitude;
    }

    protected function rules(): array
    {
        return [
            'nik' => "required|string|max:20|unique:pasien,nik,{$this->pasien->id_pasien},id_pasien",
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
                $this->pasien->update([
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

            $this->dispatch('swal', title: 'Berhasil', text: "Data pasien {$this->nama} berhasil diperbarui.", icon: 'success');
            $this->redirect(route('pasien.index'), navigate: true);
        }, 'Gagal memperbarui data pasien', ['action' => 'update pasien', 'pasien_id' => $this->pasien->id_pasien]);
    }

    public function render(): View
    {
        return view('livewire.handler.pasien.edit', [
            'jenisKelaminList' => JenisKelamin::cases(),
        ]);
    }
}
