<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\SpkMain;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SpkController extends Controller
{
    // controller spk
    public function index()
    {
        return view('dashboard.spk.index');
    }

    public function create()
    {
        return view('dashboard.spk.create');
    }

    public function show($id)
    {
        $spk = SpkMain::select('id', 'nomor_order', 'tipe_tagihan')
            ->findOrFail($id);

        return view('dashboard.spk.show', compact('spk'));
    }

    public function edit($id)
    {
        $spk = SpkMain::select('id', 'nomor_order', 'tipe_tagihan')
            ->findOrFail($id);

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
        return Storage::download('pdf/'.$id.'.pdf');
    }
    // spk end

    // penagihan
    public function billingIndex()
    {
        return view('dashboard.spk.billing.index');
    }

    public function billingEdit($id)
    {
        return view('dashboard.spk.billing.edit', compact('id'));
    }
    // penagihan end

    // delivery
    public function deliveryIndex()
    {
        return view('dashboard.spk.delivery.index');
    }

    public function deliveryEdit($id)
    {
        return view('dashboard.spk.delivery.edit', compact('id'));
    }
    // delivery end
}
