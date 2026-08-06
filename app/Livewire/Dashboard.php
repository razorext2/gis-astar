<?php

/** Goal: Main Dashboard Livewire Page Component, Caller: routes/web.php (dashboard), Livewire: Yes */

namespace App\Livewire;

use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public int $selectedYear;

    public function mount(): void
    {
        $this->selectedYear = now()->year;
    }

    /** @return array<string, mixed> */
    public function getStatsProperty(): array
    {
        return [
            'total_pasien' => Pasien::count(),
            'total_rs' => RumahSakit::count(),
            'total_rujukan' => Rujukan::count(),
            'rujukan_hari_ini' => Rujukan::whereDate('created_at', today())->count(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRujukanTerbaruProperty(): array
    {
        return Rujukan::with(['pasien', 'rumahSakit', 'detailRujukan'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function (Rujukan $r, int $i): array {
                return [
                    'no' => $i + 1,
                    'pasien' => $r->pasien?->nama ?? '-',
                    'rumah_sakit' => $r->rumahSakit?->nama_rumah_sakit ?? '-',
                    'jarak' => $r->detailRujukan?->jarak_km ? number_format($r->detailRujukan->jarak_km, 1).' km' : '-',
                    'tanggal' => Carbon::parse($r->tanggal_rujukan)->format('d/m/Y'),
                    'id' => $r->id_rujukan,
                ];
            })
            ->all();
    }

    /**
     * Monthly rujukan count for selected year.
     *
     * @return array<int, int>
     */
    public function getChartDataProperty(): array
    {
        $counts = Rujukan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $this->selectedYear)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        return collect(range(1, 12))
            ->map(fn (int $m): int => $counts->get($m, 0))
            ->values()
            ->all();
    }

    /**
     * Pasien coordinates for map.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPasienCoordsProperty(): array
    {
        return Pasien::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(['id_pasien', 'nama', 'latitude', 'longitude'])
            ->limit(100)
            ->get()
            ->map(fn (Pasien $p): array => [
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'nama' => $p->nama,
            ])
            ->all();
    }

    /**
     * Rumah sakit coordinates for map.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRsCoordsProperty(): array
    {
        return RumahSakit::select(['id_rumah_sakit', 'nama_rumah_sakit', 'latitude', 'longitude'])
            ->get()
            ->map(fn (RumahSakit $rs): array => [
                'lat' => (float) $rs->latitude,
                'lng' => (float) $rs->longitude,
                'nama' => $rs->nama_rumah_sakit,
            ])
            ->all();
    }

    /** @return array<int, int> */
    public function getAvailableYearsProperty(): array
    {
        $min = Rujukan::selectRaw('MIN(YEAR(created_at)) as y')->value('y') ?? now()->year;

        return range(now()->year, (int) $min);
    }

    public function updatedSelectedYear(): void {}

    public function render(): View
    {
        return view('livewire.dashboard', [
            'stats' => $this->stats,
            'rujukanTerbaru' => $this->rujukanTerbaru,
            'chartData' => $this->chartData,
            'pasienCoords' => $this->pasienCoords,
            'rsCoords' => $this->rsCoords,
            'availableYears' => $this->availableYears,
        ]);
    }
}
