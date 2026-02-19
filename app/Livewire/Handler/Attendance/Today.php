<?php

namespace App\Livewire\Handler\Attendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Today extends Component
{
    use WithPagination;

    public $attendance;

    public string $date;

    public string $role;

    public string $address;

    public bool $showModal = false;

    public function mount()
    {
        $this->date = Carbon::now()->toDateString();
        $this->role = '';
    }

    public function fetchAddress($lat, $long)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'IndodacinFaceID/1.1 (indodacinfaceid@gmail.com)',
            ])->get('https://nominatim.openstreetmap.org/reverse.php', [
                'lat' => $lat,
                'lon' => $long,
                'zoom' => 18,
                'format' => 'jsonv2',
            ]);

            if ($response->successful()) {
                return $response->json()['display_name'] ?? 'Alamat tidak ditemukan';
            } else {
                return 'Gagal mengambil alamat';
            }
        } catch (\Exception $e) {
            Log::error('Gagal fetch alamat: '.$e->getMessage());

            return 'Terjadi kesalahan';
        }
    }

    public function openModal($id)
    {
        if ($this->showModal) {
            return $this->showModal = false;
        }

        $this->showModal = true;

        $data = Attendance::with('pegawaiRelasi')
            ->where('id', $id)
            ->first();

        $this->address = $this->fetchAddress($data->latitude, $data->longitude);
        $this->attendance = $data;
    }

    public function getLateDuration($jamMasuk)
    {
        $masuk = Carbon::parse($jamMasuk);
        $target = $masuk->copy()->setTime(8, 0, 0);
        $diffInSeconds = $target->diffInSeconds($masuk, false);

        if ($diffInSeconds <= 0) {
            return null;
        }

        return gmdate('H \j\a\m i \m\e\n\i\t s \d\e\t\i\k', $diffInSeconds);
    }

    public function render()
    {
        $data = Attendance::whereDate('created_at', $this->date)
            ->where('status', '=', 1)
            ->when($this->role, fn ($query) => $query->whereHas('user.roles', fn ($role) => $role->where('name', $this->role)))
            ->when(! $this->role, function ($query) {
                if (auth()->user()->hasAnyRole(['HRD-IDY', 'Marketing-IDY'])) {
                    return $query->whereHas('user.roles', fn ($role) => $role->where('name', 'Sales-IDY'));
                }

                if (auth()->user()->hasRole('Produksi')) {
                    return $query->whereHas('user.roles', fn ($role) => $role->where('name', 'Mekanik'));
                }

                if (auth()->user()->hasRole('Service-Agrotec')) {
                    return $query->whereHas('user.roles', fn ($role) => $role->where('name', 'Sales-Agrotec'));
                }
            })
            ->paginate(6);

        return view('livewire.handler.attendance.today', compact('data'));
    }
}
