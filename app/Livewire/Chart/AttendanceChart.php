<?php
/** Goal: Render dynamic stacked column chart for daily attendance, Caller: Dashboard, Deps: Attendance, AttendanceOut, LivewireCharts */

namespace App\Livewire\Chart;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceChart extends Component
{
    public int $days = 7;

    public function render()
    {
        $year = Carbon::now()->year;
        
        $startDate = Carbon::today()->subDays($this->days - 1);
        $endDate = Carbon::today();
        
        $formattedDateRange = $startDate->locale('id')->isoFormat('dddd, D MMM') . ' - ' . $endDate->locale('id')->isoFormat('dddd, D MMM');

        // Query Absen Masuk (Attendance In) - Unique per employee per day
        $attendanceIn = Attendance::query()->where('created_at', '>=', $startDate->copy()->startOfDay())
            ->where('created_at', '<=', $endDate->copy()->endOfDay())
            ->selectRaw('DATE(created_at) as date, kode_pegawai')
            ->groupByRaw('DATE(created_at), kode_pegawai')
            ->get()
            ->groupBy('date');

        // Query Absen Keluar (Attendance Out) - Unique per employee per day
        $attendanceOut = AttendanceOut::query()->where('created_at', '>=', $startDate->copy()->startOfDay())
            ->where('created_at', '<=', $endDate->copy()->endOfDay())
            ->selectRaw('DATE(created_at) as date, kode_pegawai')
            ->groupByRaw('DATE(created_at), kode_pegawai')
            ->get()
            ->groupBy('date');

        // Generate date range
        $dateRange = collect(range(0, $this->days - 1))
            ->map(fn ($day) => Carbon::today()->subDays($day)->format('Y-m-d'))
            ->reverse()
            ->values();

        // Initialize stacked column chart model
        $columnChartModel = LivewireCharts::multiColumnChartModel()
            ->setAnimated(true)
            ->stacked()
            ->withOnColumnClickEventName('onColumnClick')
            ->setColors([
                '#3b82f6', // Blue for Absen Masuk
                '#dc2626', // Red for Absen Keluar
            ]);

        // Add data points
        foreach ($dateRange as $date) {
            $formattedDate = Carbon::parse($date)->locale('id')->isoFormat('D MMM');
            
            $dailyIn = $attendanceIn[$date] ?? collect([]);
            $dailyOut = $attendanceOut[$date] ?? collect([]);

            $columnChartModel
                ->addSeriesColumn('Absen Masuk', $formattedDate, $dailyIn->count())
                ->addSeriesColumn('Absen Keluar', $formattedDate, $dailyOut->count());
        }

        return view('livewire.chart.attendance-chart', [
            'columnChartModel' => $columnChartModel,
            'year' => $year,
            'formattedDateRange' => $formattedDateRange
        ]);
    }
}
