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
    public string $address;
    public bool $showModal = false;

    public function mount()
    {
        $this->date = Carbon::now()->toDateString();
    }

    public function fetchAddress($lat, $long)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'MyAbsensiApp/1.0 (email@example.com)',
            ])->get("https://nominatim.openstreetmap.org/reverse.php", [
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
            Log::error('Gagal fetch alamat: ' . $e->getMessage());
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

        if ($diffInSeconds <= 0)
            return null;

        return gmdate('H \j\a\m i \m\e\n\i\t s \d\e\t\i\k', $diffInSeconds);
    }

    public function changeDate()
    {
        $this->date = Carbon::parse($this->date)->toDateString();
    }

    public function render()
    {
        $data = Attendance::whereDate('created_at', $this->date)->paginate(6);

        return view('livewire.handler.attendance.today', compact('data'));
    }
}
