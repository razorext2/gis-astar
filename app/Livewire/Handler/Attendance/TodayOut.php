<?php

namespace App\Livewire\Handler\Attendance;

use Livewire\Component;
use App\Models\AttendanceOut;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class TodayOut extends Component
{
    use WithPagination;

    public $attendance;
    public string $date;
    public string $role;
    public string $address;
    public bool $showModalOut = false;

    public function mount()
    {
        $this->date = Carbon::now()->toDateString();
        $this->role = '';
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
        if ($this->showModalOut) {
            return $this->showModalOut = false;
        }

        $this->showModalOut = true;

        $data = AttendanceOut::with('pegawaiRelasi')
            ->where('id', $id)
            ->first();

        $this->address = $this->fetchAddress($data->latitude, $data->longitude);
        $this->attendance = $data;
    }

    public function render()
    {
        $data = AttendanceOut::whereDate('created_at', $this->date)
            ->when($this->role, function ($query) {
                return $query->whereHas('user.roles', function ($role) {
                    $role->where('name', $this->role);
                });
            })
            ->paginate(6);

        return view('livewire.handler.attendance.today-out', compact('data'));
    }
}
