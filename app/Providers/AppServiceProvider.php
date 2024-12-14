<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app['url']->forceRootUrl($this->app['config']->get('app.url'));
        // tampung nilai total atIn dan atOut
        View::composer('*', function ($view) {
            $totalAtIn = Attendance::count();
            $totalAtOut = AttendanceOut::count();
            $jamMasuk = Carbon::createFromTimeString('08:00:00');
            $jamKeluar = Carbon::createFromTimeString('17:00:00');

            if (Attendance::exists()) {
                $ontimeAttendance = Attendance::whereTime('jam_masuk', '<=', $jamMasuk)->count();
                $terlambat = Attendance::whereTime('jam_masuk', '>=', $jamMasuk)->count();
                $outtimeAttendance = AttendanceOut::whereTime('jam_keluar', '>=', $jamKeluar)->count();
                $kecepatan = AttendanceOut::whereTime('jam_keluar', '<=', $jamKeluar)->count();
            } else {
                $ontimeAttendance = 0;
                $outtimeAttendance = 0;
                $terlambat = 0;
                $kecepatan = 0;
            }

            $view->with('ontimeAttendance', $ontimeAttendance);
            $view->with('outtimeAttendance', $outtimeAttendance);
            $view->with('terlambat', $terlambat);
            $view->with('kecepatan', $kecepatan);
            $view->with('totalAtIn', $totalAtIn);
            $view->with('totalAtOut', $totalAtOut);
            $this->loadLateAttendanceData($view);
        });
    }

    protected function loadLateAttendanceData($view)
    {
        $startDate = Carbon::now()->subDays(7); // 7 hari kebelakang
        $endDate = Carbon::now();
        $inTime = Carbon::createFromTimeString('08:00:00'); // Jam standar untuk pembanding
        $outTime = Carbon::createFromTimeString('17:00:00');

        // Query untuk mendapatkan jumlah keterlambatan per hari (berdasarkan jam_masuk)
        $lateData = DB::table('tb_attendance')
            ->select(DB::raw('DATE(jam_masuk) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('jam_masuk', [$startDate, $endDate])
            ->whereRaw('TIME(jam_masuk) > ?', [$inTime->toTimeString()]) // Bandingkan jam_masuk dengan 08:00:00
            ->groupBy(DB::raw('DATE(jam_masuk)'))
            ->pluck('total', 'date'); // Mengambil total terlambat dan tanggal

        $ontimeData = DB::table('tb_attendance')
            ->select(DB::raw('DATE(jam_masuk) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('jam_masuk', [$startDate, $endDate])
            ->whereRaw('TIME(jam_masuk) < ?', [$inTime->toTimeString()]) // Bandingkan jam_masuk dengan 08:00:00
            ->groupBy(DB::raw('DATE(jam_masuk)'))
            ->pluck('total', 'date'); // Mengambil total terlambat dan tanggal

        $fastData = DB::table('tb_attendance_out')
            ->select(DB::raw('DATE(jam_keluar) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('jam_keluar', [$startDate, $endDate])
            ->whereRaw('TIME(jam_keluar) < ?', [$outTime->toTimeString()]) // Bandingkan jam_keluar dengan 08:00:00
            ->groupBy(DB::raw('DATE(jam_keluar)'))
            ->pluck('total', 'date'); // Mengambil total terlambat dan tanggal

        $outtimeData = DB::table('tb_attendance_out')
            ->select(DB::raw('DATE(jam_keluar) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('jam_keluar', [$startDate, $endDate])
            ->whereRaw('TIME(jam_keluar) > ?', [$outTime->toTimeString()]) // Bandingkan jam_keluar dengan 08:00:00
            ->groupBy(DB::raw('DATE(jam_keluar)'))
            ->pluck('total', 'date'); // Mengambil total terlambat dan tanggal


        // Buat array tanggal 7 hari terakhir dengan jumlah terlambat
        $dates = [];
        $lateCounts = [];
        $ontimeCounts = [];
        $outtimeCounts = [];
        $fastCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::now()->subDays($i)->locale('id')->isoFormat('D MMM');
            $lateCounts[] = $lateData->get($date, 0); // Isi dengan 0 jika tidak ada data di tanggal tersebut
            $ontimeCounts[] = $ontimeData->get($date, 0);
            $outtimeCounts[] = $outtimeData->get($date, 0);
            $fastCounts[] = $fastData->get($date, 0);
        }

        // Bagikan data ke semua view
        $view->with('dates', $dates);
        $view->with('lateCounts', $lateCounts);
        $view->with('ontimeCounts', $ontimeCounts);

        $view->with('fastCounts', $fastCounts);
        $view->with('outtimeCounts', $outtimeCounts);
    }
}
