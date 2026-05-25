<?php

/** Goal: Controller untuk halaman Laporan Export, Caller: routes/features/report.php, Deps: None */

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;

class ReportExportController extends Controller
{
    public function absensi(): \Illuminate\View\View
    {
        return view('dashboard.report.absensi', ['title' => 'Laporan Absensi']);
    }

    public function cuti(): \Illuminate\View\View
    {
        return view('dashboard.report.cuti', ['title' => 'Laporan Cuti']);
    }

    public function piutang(): \Illuminate\View\View
    {
        return view('dashboard.report.piutang', ['title' => 'Laporan Piutang']);
    }

    public function kolektor(): \Illuminate\View\View
    {
        return view('dashboard.report.kolektor', ['title' => 'Laporan Kolektor']);
    }

    public function invoice(): \Illuminate\View\View
    {
        return view('dashboard.report.invoice', ['title' => 'Laporan Invoice']);
    }

    public function spk(): \Illuminate\View\View
    {
        return view('dashboard.report.spk', ['title' => 'Laporan SPK']);
    }

    public function driver(): \Illuminate\View\View
    {
        return view('dashboard.report.driver', ['title' => 'Laporan Driver']);
    }

    public function sales(): \Illuminate\View\View
    {
        return view('dashboard.report.sales', ['title' => 'Laporan Sales']);
    }
}
