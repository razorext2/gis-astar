<?php

namespace App\Livewire\Plugin;

use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TechReportPercentage extends Component
{
    public $requested;
    public $draft;
    public $revised;
    public $accepted;
    public $rejected;
    public $selectedMonth;
    public $availableMonths = [];

    public function mount()
    {
        $this->selectedMonth = now()->format('Y-m');
        $this->generateAvailableMonths();
        $this->fetchLocalStats();
    }

    public function generateAvailableMonths()
    {
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $this->availableMonths[$date->format('Y-m')] = $date->translatedFormat('F Y');
        }
    }

    public function updatedSelectedMonth()
    {
        $this->fetchLocalStats();
    }

    public function fetchLocalStats()
    {
        $date = Carbon::parse($this->selectedMonth);
        $start = $date->copy()->startOfMonth()->toDateTimeString();
        $end = $date->copy()->endOfMonth()->toDateTimeString();

        $query = Technician::where('kode_pegawai', auth()->user()->kode_pegawai)
            ->whereBetween('created_at', [$start, $end]);

        $stats = $query->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $this->requested = $stats[0] ?? 0;
        $this->draft = $stats[4] ?? 0;
        $this->revised = $stats[2] ?? 0;
        $this->accepted = $stats[1] ?? 0;
        $this->rejected = $stats[3] ?? 0;
    }

    public function getApiData()
    {
        $kode_pegawai = auth()->user()->kode_pegawai;
        $cacheKey = "tech_report_api_{$kode_pegawai}";

        $api = Cache::remember($cacheKey, now()->addHours(1), function () use ($kode_pegawai) {
            return Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchCountPoint&NomorIdentitasTeknisi=' . $kode_pegawai)->json();
        });

        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $result = [];
        foreach ($months as $bulan) {
            $monthData = array_values(array_filter($api['data'] ?? [], function ($item) use ($bulan) {
                return isset($item['Bulan']) && $item['Bulan'] === $bulan;
            }));

            $items = $monthData[0] ?? null;
            $total = $items['TotalKunjungan'] ?? 0;
            $filled = $items['SudahTerisi'] ?? 0;
            $percentage = $total > 0 ? ($filled / $total) * 100 : 0;

            $color = 'bg-emerald-500';
            if ($percentage <= 50) {
                $color = 'bg-rose-500';
            } elseif ($percentage <= 80) {
                $color = 'bg-amber-500';
            }

            $result[] = [
                'month_key' => $bulan,
                'month_label' => Carbon::parse($bulan)->translatedFormat('F Y'),
                'label' => "{$filled}/{$total}",
                'percentage' => $percentage,
                'color' => $color,
                'is_low' => $percentage <= 50,
                'is_high' => $percentage > 80,
            ];
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.plugin.tech-report-percentage', [
            'historicalData' => $this->getApiData()
        ]);
    }
}
