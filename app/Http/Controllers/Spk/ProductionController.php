<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\Production;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductionController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Production::class);

        return view('dashboard.spk.production.index');
    }

    public function show($id)
    {
        $this->authorize('view', Production::class);

        $data = $this->getData($id);

        return view('dashboard.spk.production.show', [
            'data' => $data,
        ]);
    }

    public function packingListCreate($id)
    {
        $this->authorize('updatePackingList', Production::class);

        $data = $this->getData($id);

        return view('dashboard.spk.production.packing-list.create', [
            'data' => $data,
        ]);
    }

    public function packingListKits($production, $idbarang)
    {
        $this->authorize('updatePackingList', Production::class);

        $data = $this->getData($production);

        $barang = collect($data->packing_list)->firstWhere('id_barang', $idbarang);

        return view('dashboard.spk.production.packing-list.kits', [
            'data' => $data,
            'barang' => $barang,
        ]);
    }

    public function streamPackingListPdf()
    {
        $data = session('packing_list_data');

        $pdf = Pdf::loadView('dashboard.pdf.preview-packinglist', [
            'data' => $data,
        ])->setPaper('F5', 'portrait');

        return $pdf->stream('packing-list-'.$data['id'].'.pdf');
    }

    private function getData($id)
    {
        return Production::with(['spk', 'productionHistories'])
            ->findOrFail($id);
    }
}
