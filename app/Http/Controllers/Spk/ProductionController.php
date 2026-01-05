<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\Production;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductionController extends Controller
{
    public function index()
    {
        return view('dashboard.spk.production.index');
    }

    public function show($id)
    {
        $data = $this->getData($id);

        return view('dashboard.spk.production.show', [
            'data' => $data,
        ]);
    }

    public function packingListCreate($id)
    {
        $data = $this->getData($id);

        return view('dashboard.spk.production.packing-list.create', [
            'data' => $data,
        ]);
    }

    public function streamPackingListPdf()
    {
        $data = session('packing_list_data');

        $pdf = Pdf::loadView('dashboard.pdf.preview-packinglist', [
            'data' => $data,
        ]);

        return $pdf->stream('packing-list-'.$data['id'].'.pdf');
    }

    private function getData($id)
    {
        return Production::with(['spk', 'productionHistories'])
            ->findOrFail($id);
    }
}
