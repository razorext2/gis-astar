<?php

namespace App\Livewire\Handler\Route;

use Carbon\Carbon;
use Livewire\Component;

class Collector extends Component
{
    public int $kode_pegawai;

    public ?string $date = null;

    public function mount(int $kode_pegawai)
    {
        $this->kode_pegawai = $kode_pegawai;
    }

    public function search()
    {
        $this->validate([
            'date' => ['nullable', 'date'],
        ]);

        // Normalise the selected date so the query always receives a valid value.
        $this->date = $this->date
            ? Carbon::parse($this->date)->toDateString()
            : today()->toDateString();

        // Paksa reload halaman agar peta diinisialisasi ulang dengan data terbaru.
        return redirect()->route('routes.collector.detail', [
            'pegawai' => $this->kode_pegawai,
            'd' => $this->date,
        ]);
    }

    protected function queryString()
    {
        return [
            'date' => [
                'as' => 'd',
            ],
        ];
    }

    public function render()
    {
        $date = $this->date ?: today()->toDateString();

        $data = \App\Models\Collector::where('kode_pegawai', $this->kode_pegawai)
            ->whereDate('assign_date', $date)
            ->orderBy('assign_at', 'asc')
            ->get();

        $waypointsData = $data->map(function ($data) {
            $type = match ($data->bill_type) {
                'idcnonppn' => 'collectTaskRelasi',
                'idcppn' => 'collectTaskPpnRelasi',
                'idyppn' => 'collectIdyPpnRelasi',
                default => 'collectTaskRelasi',
            };

            return [
                'lat' => $data->latitude ?: 3.591516090416829,
                'lng' => $data->longitude ?: 98.66902828216554,
                'title' => $data->title,
                'customer_name' => $data->$type->customer_name ?? '-',
                'location' => $data->location,
            ];
        });

        return view('livewire.handler.route.collector', [
            'data' => $data,
            'waypointsData' => $waypointsData,
        ]);
    }
}
