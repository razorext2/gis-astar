<?php

namespace App\Livewire\Chart;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Livewire\Component;

class Line extends Component
{
    public function render()
    {
        // Ambil data 7 hari terakhir dari database
        $ontime = Attendance::where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereRaw("time(created_at) <= '08:00:00'")
            ->get()
            ->groupBy(fn($attendance) => Carbon::parse($attendance->created_at)->format('Y-m-d'));

        $backOntime = AttendanceOut::where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereRaw("time(created_at) >= '17:00:00'")
            ->get()
            ->groupBy(fn($attendance) => Carbon::parse($attendance->created_at)->format('Y-m-d'));

        $late = Attendance::where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereRaw("time(created_at) > '08:00:00'")
            ->get()
            ->groupBy(fn($attendance) => Carbon::parse($attendance->created_at)->format('Y-m-d'));

        $backTooFast = AttendanceOut::where('created_at', '>=', Carbon::now()->subDays(7))
            ->whereRaw("time(created_at) < '17:00:00'")
            ->get()
            ->groupBy(fn($attendance) => Carbon::parse($attendance->created_at)->format('Y-m-d'));

        // Buat array dengan tanggal lengkap selama 7 hari terakhir
        $dateRange = collect(range(0, 6))->map(fn($day) => Carbon::now()->subDays($day)->format('Y-m-d'))->reverse()->values();

        // Inisialisasi model grafik
        $multiLineChartModel = LivewireCharts::multiLineChartModel()
            ->setAnimated(true)
            ->withOnPointClickEvent('onPointClick')
            ->setSmoothCurve()
            ->multiLine()
            ->setColors([
                '#3b82f6',
                '#9333ea',
                '#f43f5e',
                '#f59e0b'
            ]);

        // Tambahkan data ke grafik
        foreach ($dateRange as $date) {
            $dailyOntime = $ontime[$date] ?? collect([]);
            $dailyBackOntime = $backOntime[$date] ?? collect([]);
            $dailyLate = $late[$date] ?? collect([]);
            $dailyBackTooFast = $backTooFast[$date] ?? collect([]);

            // Tambahkan hanya yang statusnya diterima (1)
            $multiLineChartModel
                ->addSeriesPoint('Tepat waktu', $date, $dailyOntime->count())
                ->addSeriesPoint('Pulang tepat waktu', $date, $dailyBackOntime->count())
                ->addSeriesPoint('Terlambat', $date, $dailyLate->count())
                ->addSeriesPoint('Pulang cepat', $date, $dailyBackTooFast->count());
        }

        return view('livewire.chart.line', ['multiLineChartModel' => $multiLineChartModel]);
    }
}
