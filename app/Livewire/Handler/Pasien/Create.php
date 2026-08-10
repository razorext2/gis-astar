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

    public array $addressSuggestions = [];

    public function geocodeAddress(): void
    {
        if (empty($this->alamat)) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Masukkan alamat terlebih dahulu.', icon: 'warning');

            return;
        }

        $results = app(\App\Services\GeocodingService::class)->search($this->alamat, 5);

        if (empty($results)) {
            $this->dispatch('swal', title: 'Gagal', text: 'Alamat tidak ditemukan atau tidak dapat dilokalisasi.', icon: 'error');
            return;
        }

        if (count($results) === 1) {
            $this->latitude = $results[0]['lat'];
            $this->longitude = $results[0]['lng'];
            $this->dispatch('coordinates-updated', lat: $results[0]['lat'], lng: $results[0]['lng']);
            $this->dispatch('swal', title: 'Berhasil', text: 'Koordinat ditemukan dan peta diperbarui.', icon: 'success');
            return;
        }

        // Simpan suggestions dan kirim ke Javascript
        $this->addressSuggestions = $results;
        $this->dispatch('show-address-suggestions', suggestions: $results);
    }

    public function selectAddressSuggestion(int $index): void
    {
        if (isset($this->addressSuggestions[$index])) {
            $selected = $this->addressSuggestions[$index];
            $this->latitude = $selected['lat'];
            $this->longitude = $selected['lng'];
            $this->alamat = $selected['display_name']; // Optional: auto-complete input alamat
            $this->dispatch('coordinates-updated', lat: $selected['lat'], lng: $selected['lng']);
            $this->dispatch('swal', title: 'Berhasil', text: 'Koordinat diperbarui ke lokasi yang dipilih.', icon: 'success');
        }

        $this->addressSuggestions = [];
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
