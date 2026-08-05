<?php

/** Goal: Form edit Rumah Sakit, Caller: rs.edit */

namespace App\Livewire\Handler\RumahSakit;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public RumahSakit $rumahSakit;

    public ?string $nama_rumah_sakit = null;

    public ?string $alamat = null;

    public ?string $no_telepon = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    public array $layanan_operasi = [];

    public array $layananPool = [
        'IGD', 'ICU', 'NICU', 'Bedah', 'Penyakit Dalam',
        'Jantung', 'Saraf', 'Kebidanan', 'Anak', 'Radiologi',
        'Ortopedi', 'THT', 'Mata', 'Kulit', 'Psikiatri',
    ];

    public function mount(RumahSakit $rumahSakit): void
    {
        $this->rumahSakit = $rumahSakit;
        $this->nama_rumah_sakit = $rumahSakit->nama_rumah_sakit;
        $this->alamat = $rumahSakit->alamat;
        $this->no_telepon = $rumahSakit->no_telepon;
        $this->latitude = $rumahSakit->latitude;
        $this->longitude = $rumahSakit->longitude;
        $layanan = $rumahSakit->layanan_operasi;
        if (is_string($layanan)) {
            $layanan = json_decode($layanan, true) ?? [];
        }
        $this->layanan_operasi = is_array($layanan) ? $layanan : [];
    }

    protected function rules(): array
    {
        return [
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'layanan_operasi' => 'required|array|min:1',
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
                $this->rumahSakit->update([
                    'nama_rumah_sakit' => $this->nama_rumah_sakit,
                    'alamat' => $this->alamat,
                    'no_telepon' => $this->no_telepon,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'layanan_operasi' => array_values($this->layanan_operasi),
                ]);
            });

            $this->dispatch('swal', title: 'Berhasil', text: 'Data RS berhasil diperbarui.', icon: 'success');
            $this->redirect(route('rs.index'), navigate: true);
        }, 'Gagal memperbarui data RS', ['rs_id' => $this->rumahSakit->id_rumah_sakit]);
    }

    public function render(): View
    {
        return view('livewire.handler.rumah-sakit.edit');
    }
}
