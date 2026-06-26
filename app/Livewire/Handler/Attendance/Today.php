<?php

/** Goal: Display check-in records for today, Caller: Dashboard, Deps: Attendance, Pegawai, User */

namespace App\Livewire\Handler\Attendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Today extends Component
{
    use WithPagination;

    public $attendance;

    public string $date;

    public string $role = '';

    public string $address = '';

    public bool $showModal = false;

    public function mount()
    {
        $this->date = Carbon::now()->toDateString();
    }

    /**
     * Centralized role options based on user permissions.
     */
    #[Computed]
    public function roleOptions()
    {
        $user = auth()->user();
        $options = [];

        if ($user->can('sales-export-medan') || $user->can('attendance-approve')) {
            $options['Sales'] = 'Sales Medan';
        }

        if ($user->can('sales-export-agrotec') || $user->can('attendance-approve')) {
            $options['Sales-Agrotec'] = 'Sales Agrotec';
        }

        if ($user->can('sales-export-pku') || $user->can('attendance-approve')) {
            $options['Sales-PKU'] = 'Sales Pekanbaru';
        }

        if ($user->can('sales-export-jkt') || $user->can('attendance-approve')) {
            $options['Sales-JKT'] = 'Sales Jakarta';
        }

        if ($user->can('sales-export-idy') || $user->can('attendance-approve')) {
            $options['Sales-IDY'] = 'Sales Indodaya';
        }

        if ($user->can('sales-export-kurir-bank') || $user->can('attendance-approve')) {
            $options['Kurir-Bank'] = 'Kurir Bank';
        }

        if ($user->can('driver-list-jkt') || $user->can('driver-approve') || $user->can('attendance-approve')) {
            $options['Driver-Jkt'] = 'Driver Jakarta';
        }

        if ($user->can('driver-list-medan') || $user->can('driver-approve') || $user->can('attendance-approve')) {
            $options['Driver-Medan'] = 'Driver Medan';
        }

        if ($user->can('attendance-approve')) {
            $options['Employee'] = 'Karyawan';
        }

        if ($user->can('technician-approve') || $user->can('attendance-approve')) {
            $options['Teknisi'] = 'Teknisi';
        }

        if ($user->can('spk-list') || $user->can('attendance-approve')) {
            $options['Mekanik'] = 'Mekanik';
        }

        return $options;
    }

    public function fetchAddress($lat, $long)
    {
        $cacheKey = 'address_lat_long_'.round($lat, 5).'_'.round($long, 5);

        return Cache::remember($cacheKey, 86400 * 30, function () use ($lat, $long) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'IndodacinFaceID/1.1 (indodacinfaceid@gmail.com)',
                ])->timeout(10)->get('https://nominatim.openstreetmap.org/reverse.php', [
                    'lat' => $lat,
                    'lon' => $long,
                    'zoom' => 18,
                    'format' => 'jsonv2',
                ]);

                if ($response->successful()) {
                    return $response->json()['display_name'] ?? 'Alamat tidak ditemukan';
                }

                return 'Gagal mengambil alamat';
            } catch (\Exception $e) {
                Log::error('Gagal fetch alamat: '.$e->getMessage());

                return 'Terjadi kesalahan atau API timeout';
            }
        });
    }

    public function openModal($id)
    {
        if ($this->showModal && $this->attendance?->id == $id) {
            return $this->showModal = false;
        }

        $data = Attendance::with(['pegawaiRelasi', 'user'])->find($id);

        if (! $data) {
            return;
        }

        $this->attendance = $data;
        $this->address = $this->fetchAddress($data->latitude, $data->longitude);
        $this->showModal = true;
    }

    public function getLateDuration($jamMasuk)
    {
        $masuk = Carbon::parse($jamMasuk);
        $target = $masuk->copy()->setTime(8, 0, 0);
        $diffInSeconds = $target->diffInSeconds($masuk, false);

        if ($diffInSeconds <= 0) {
            return null;
        }

        return gmdate('H:i:s', $diffInSeconds);
    }

    public function render()
    {
        $data = Attendance::with(['pegawaiRelasi', 'user.roles'])
            ->whereDate('created_at', $this->date)
            ->where('status', '=', 1)
            ->when($this->role, function ($query) {
                return $query->whereHas('user.roles', fn ($q) => $q->where('name', $this->role));
            })
            ->when(! $this->role, function ($query) {
                $targetRoles = array_keys($this->roleOptions);

                if (! empty($targetRoles)) {
                    return $query->whereHas('user.roles', function ($q) use ($targetRoles) {
                        $q->whereIn('name', $targetRoles);
                    });
                }

                return $query;
            })
            ->latest('waktuori')
            ->paginate(6);

        return view('livewire.handler.attendance.today', compact('data'));
    }
}
