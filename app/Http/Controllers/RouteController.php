<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\Driver;
use App\Models\Pegawai;
use App\Models\Sales;
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
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today(); // Ambil tanggal dari query string
        }

        $pegawai = Pegawai::select('kode_pegawai', 'full_name')->where('kode_pegawai', $id)->firstOrFail();

        $report = Driver::where('kode_pegawai', $id)
            ->whereDate('created_at', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.driver.detail', compact('pegawai', 'report'));
    }

    public function collector()
    {
        return view('dashboard.routes.collector.show');
    }

    public function detailCollector($id, Request $request)
    {
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today();
        }

        $pegawai = Pegawai::select('kode_pegawai', 'full_name')->where('kode_pegawai', $id)->firstOrFail();

        $report = Collector::where('kode_pegawai', $id)
            ->whereDate('created_at', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.collector.detail', compact('pegawai', 'report'));
    }

    public function sales()
    {
        return view('dashboard.routes.sales.show');
    }

    public function detailSales($id, Request $request)
    {
        if ($request->query('date')) {
            $date = Carbon::parse($request->query('date'))->isoFormat('YYYY-MM-DD');
        } else {
            $date = Carbon::today();
        }

        $pegawai = Pegawai::select('kode_pegawai', 'full_name')->where('kode_pegawai', $id)->firstOrFail();

        $report = Sales::where('kode_pegawai', $id)
            ->whereDate('created_at', $date)
            ->get();

        // Kembalikan view dengan data $pegawai
        return view('dashboard.routes.sales.detail', compact('pegawai', 'report'));
    }
}
