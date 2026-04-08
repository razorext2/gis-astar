<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\ProjectAssignment;
use App\Models\Spk\SpkMain;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    public function index()
    {
        return view('dashboard.spk.daily-report.index');
    }

    public function assign()
    {
        $id = request('spk_id');
        $spk = null;

        if ($id) {
            $spk = SpkMain::findOrFail($id);
        }

        return view('dashboard.spk.daily-report.assign', compact('spk'));
    }

    public function daily($id)
    {
        return view('dashboard.spk.daily-report.detail.daily', compact('id'));
    }

    public function customerAssignment($id)
    {
        return view('dashboard.spk.daily-report.detail.customer-assignment', compact('id'));
    }

    public function hourly($id, $daily)
    {
        return view('dashboard.spk.daily-report.detail.hourly', compact(['id', 'daily']));
    }

    public function general()
    {
        return view('dashboard.spk.daily-report.general.index');
    }

    public function generalAssign()
    {
        return view('dashboard.spk.daily-report.general.assign');
    }

    public function generalDaily($id)
    {
        return view('dashboard.spk.daily-report.general.detail.daily', compact('id'));
    }

    public function generalHourly($id, $daily)
    {
        return view('dashboard.spk.daily-report.general.detail.hourly', compact(['id', 'daily']));
    }

    public function generalCustomerAssignment($id)
    {
        return view('dashboard.spk.daily-report.general.detail.customer-assignment', compact('id'));
    }

    // laporan harian
    public function streamLaporanHarianPdf($assignmentId)
    {
        $query = ProjectAssignment::findOrFail($assignmentId);

        $pdf = Pdf::loadView('dashboard.pdf.preview-laporanharian', [
            'data' => $query,
        ])->setPaper('F5', 'portrait');

        return $pdf->stream('packing-list-'.$query->nomor_vt.'.pdf');
    }

    public function downloadDailyReportPdf($id)
    {
        // pastikan file ada
        abort_if(! Storage::disk('local')->exists('pdf/'.$id.'.pdf'), 404);

        return Storage::download('pdf/'.$id.'.pdf');
    }
}
