<?php

namespace App\Livewire\Handler\Route;

use Illuminate\Support\Carbon;
use Livewire\Component;

class AllEmployees extends Component
{
    public ?string $date = null;

    public ?string $name = null;

    public ?string $role = null;

    public ?string $sort = null;

    public function search()
    {
        $this->validate([
            'date' => ['nullable', 'date'],
            'name' => ['nullable', 'string', 'max:30'],
            'role' => ['nullable', 'string', 'max:15'],
        ]);

        // Normalise the selected date so the query always receives a valid value.
        $this->date = $this->date
            ? Carbon::parse($this->date)->toDateString()
            : today()->toDateString();

        // Paksa reload halaman agar peta diinisialisasi ulang dengan data terbaru.
        return redirect()->route('map.distribution', [
            'd' => $this->date,
            'n' => $this->name,
            'r' => $this->role,
        ]);
    }

    protected function queryString()
    {
        return [
            'date' => [
                'as' => 'd',
            ],
            'name' => [
                'as' => 'n',
            ],
            'role' => [
                'as' => 'r',
            ],
        ];
    }

    public function cancel()
    {
        $this->redirectRoute('map.distribution');
    }

    public function render()
    {
        $date = $this->date ?: today();

        $data = \App\Models\Attendance::with('pegawaiRelasi')
            ->whereDate('created_at', $date)
            ->where('status', 1);

        if ($this->name) {
            $data->whereHas('pegawaiRelasi', fn ($pegawai) => $pegawai->where('full_name', 'like', '%'.$this->name.'%'));
        }

        if ($this->role) {
            $data->whereHas('user.roles', fn ($roles) => $roles->where('name', $this->role));
        } else {
            $data->whereHas('user.roles', fn ($roles) => $roles->whereIn('name', ['Mekanik', 'Teknisi']));
        }

        $data = $data
            ->orderBy('created_at', $this->sort ?? 'asc')
            ->get();

        $waypointsData = $data->map(function ($data) {
            return [
                'lat' => $data->latitude ?: 3.591516090416829,
                'lng' => $data->longitude ?: 98.66902828216554,
                'name' => $data->pegawaiRelasi->full_name,
                'role' => $data->user->roles->first()->name,
                'keterangan' => $data->keterangan,
            ];
        });

        return view('livewire.handler.route.all-employees', [
            'datas' => $data,
            'waypoints' => $waypointsData,
        ]);
    }
}
