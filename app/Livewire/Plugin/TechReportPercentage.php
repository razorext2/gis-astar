<?php

namespace App\Livewire\Plugin;

use App\Models\Technician;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TechReportPercentage extends Component
{
    public $requested;
    public $draft;
    public $revised;
    public $accepted;
    public $rejected;
    public $lastSixMonths = [];

    public function mount()
    {
        $query = Technician::all()
            ->where('created_at', '>=', today()->startOfMonth()->toDateTimeString())
            ->where('created_at', '<=', today()->endOfMonth()->toDateTimeString())
            ->where('kode_pegawai', auth()->user()->kode_pegawai);

        $this->getMonth();

        $this->requested = $query->where('status', 0)->count();
        $this->draft = $query->where('status', 4)->count();
        $this->revised = $query->where('status', 2)->count();
        $this->accepted = $query->where('status', 1)->count();
        $this->rejected = $query->where('status', 3)->count();
    }

    public function getMonth()
    {
        $this->lastSixMonths = [];
        for ($i = 0; $i < 6; $i++) {
            $this->lastSixMonths[] = now()->subMonths($i)->translatedFormat('F Y');
        }

        return $this->lastSixMonths;
    }

    public function getApi()
    {
        $api = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchCountPoint&NomorIdentitasTeknisi=' . auth()->user()->kode_pegawai)->json();

        // Ambil semua bulan (format 'YYYY-MM') dari getMonth()
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $result = [];
        foreach ($months as $bulan) {
            $result[$bulan] = array_values(array_filter($api['data'] ?? [], function ($item) use ($bulan) {
                return isset($item['Bulan']) && $item['Bulan'] === $bulan;
            }));
        }
        return $result;
    }

    public function render()
    {
        return view('livewire.plugin.tech-report-percentage', [
            'data' => $this->getApi()
        ]);
    }
}
