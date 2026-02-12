<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Jobs\ExportPdfJob;
use App\Models\Spk\SpkMain;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SpkController extends Controller
{
    // controller spk
    public function index()
    {
        $this->authorize('viewAny', SpkMain::class);

        return view('dashboard.spk.index');
    }

    public function create()
    {
        $this->authorize('create', SpkMain::class);

        return view('dashboard.spk.create');
    }

    public function show($id)
    {
        $this->authorize('view', SpkMain::class);

        $spk = SpkMain::select('id', 'nomor_order', 'tipe_tagihan', 'revision_count')
            ->findOrFail($id);

        return view('dashboard.spk.show', compact('spk'));
    }

    public function edit(SpkMain $spk)
    {
        $this->authorize('update', $spk);

        return view('dashboard.spk.edit', compact('spk'));
    }

    public function streamPdf()
    {
        $data = session('spk_pdf_data');

        $pdf = Pdf::loadView('dashboard.pdf.preview-spksummary', [
            'data' => $data,
        ]);

        return $pdf->stream('spk-'.$data['id'].'.pdf');
    }

    public function download($id)
    {
        // auth / permission check (opsional)
        abort_if(! auth()->check(), 403);

        // pastikan file ada
        abort_if(! Storage::disk('local')->exists('pdf/'.$id.'.pdf'), 404);

        return Storage::download('pdf/'.$id.'.pdf');
    }

    public function attachmentDownload(string $path)
    {
        // auth / permission check (opsional)
        abort_if(! auth()->check(), 403);

        // pastikan file ada
        abort_if(! Storage::disk('local')->exists($path), 404);

        // download (force)
        return Storage::download($path);
    }

    public function generatePdf($id)
    {
        $data = SpkMain::findOrFail($id);

        if ($data->assign_to === Auth::id()) {
            $data->update([
                'production_has_download_spk_pdf' => true,
                'production_has_download_spk_pdf_at' => now(),
            ]);
        }

        $data->spkHistories()->create([
            'title' => 'Laporan SPK Sedang Digenerate.',
            'keterangan' => Auth::user()->name.' melakukan generate laporan SPK.',
            'added_by' => Auth::id(),
        ]);

        ExportPdfJob::dispatch(
            Auth::id(),
            'App\Models\Spk\SpkMain',
            $data->id,
            'f4',
            'portrait',
            'dashboard.pdf.spksummary-for-produksi',
            "SPK $data->nomor_order anda telah siap untuk didownload. Silahkan klik tombol download dibawah ini:",
            'spk.download');

        return Redirect::back()->with('status', 'Laporan SPK sedang disiapkan sistem, mohon menunggu.');
    }
    // spk end

    // penagihan
    public function billingIndex()
    {
        $this->authorize('billingIndex', SpkMain::class);

        return view('dashboard.spk.billing.index');
    }

    public function billingEdit($id)
    {
        $this->authorize('billingUpdate', SpkMain::class);

        return view('dashboard.spk.billing.edit', compact('id'));
    }
    // penagihan end

    // delivery
    public function deliveryIndex()
    {
        $this->authorize('updateInformasiPengiriman', SpkMain::class);

        return view('dashboard.spk.delivery.index');
    }

    public function deliveryEdit($id)
    {
        $this->authorize('updateInformasiPengiriman', SpkMain::class);

        $data = SpkMain::findOrFail($id);

        return view('dashboard.spk.delivery.edit', [
            'id' => $id,
            'data' => $data,
        ]);
    }
}
