<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function driver()
    {
        return view('dashboard.routes.driver.show');
    }

    public function detailDriver($id, Request $request)
    {
        $date = Carbon::today(); // Ambil tanggal dari query string

        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        }

        $report = Pegawai::with([
            'driverReport' => function ($query) use ($date) {
                $query->whereDate('created_at', $date)
                    ->orderBy('created_at', 'asc');
            },
        ])->whereHas('userRelasi', fn ($query) => $query->where('id', $id))
            ->firstOrFail();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.driver.detail', [
            'report' => $report->driverReport,
            'pegawai' => $report,
        ]);
    }

    public function collector()
    {
        return view('dashboard.routes.collector.show');
    }

    public function detailCollector($id)
    {
        $pegawai = Pegawai::select('kode_pegawai', 'full_name')
            ->where('kode_pegawai', $id)
            ->firstOrFail();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.collector.detail', [
            'pegawai' => $pegawai,
        ]);
    }

    public function sales()
    {
        return view('dashboard.routes.sales.show');
    }

    public function detailSales($id, Request $request)
    {
        $date = Carbon::today();

        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        }

        $pegawai = Pegawai::with([
            'salesReport' => function ($query) use ($date) {
                $query->with('pegawaiRelasi')
                    ->whereDate('created_at', $date)
                    ->orderBy('created_at', 'asc');
            },
        ])->where('kode_pegawai', $id)->firstOrFail();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.sales.detail', [
            'report' => $pegawai->salesReport,
            'pegawai' => $pegawai,
        ]);
    }
}
