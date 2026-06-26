<?php

/** Goal: Handle CRUD views for Purchasing Request, Caller: routes/web.php, Deps: SpkMain, PurchasingRequest */

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
use Illuminate\View\View;

class PurchasingRequestController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', PurchasingRequest::class);

        return view('dashboard.spk.purchasing-request.index');
    }

    public function edit(string $id): View
    {
        $this->authorize('update', PurchasingRequest::class);

        $data = SpkMain::select('id', 'nomor_order', 'tipe_tagihan', 'customer', 'nomor_purchasing_request', 'revision_count', 'is_using_old_stock')
            ->findOrFail($id);

        if ($data->is_using_old_stock) {
            abort(403);
        }

        if (! empty($data->nomor_purchasing_request)) {
            abort(403);
        }

        return view('dashboard.spk.purchasing-request.edit', [
            'data' => $data,
        ]);
    }

    public function show(string $id): View
    {
        $this->authorize('view', PurchasingRequest::class);

        $spk = SpkMain::select('id', 'nomor_purchasing_request', 'nomor_purchasing_request_json', 'nomor_order', 'revision_count', 'customer', 'is_using_old_stock')
            ->findOrFail($id);

        $is_multiple = ! empty($spk->nomor_purchasing_request_json);

        $data = match (true) {
            ! empty($spk->nomor_purchasing_request) => PurchasingRequest::where('id_spk', $id)->get(),
            $is_multiple => PurchasingRequest::where('id_spk', $id)
                ->whereIn('nomor_purchasing_request', $spk->nomor_purchasing_request_json)
                ->get()
                ->groupBy('nomor_purchasing_request'),
            default => collect(),
        };

        return view('dashboard.spk.purchasing-request.show', [
            'spk' => $spk,
            'data' => $data,
            'is_multiple' => $is_multiple,
        ]);
    }

    public function editPr(string $id): View
    {
        $this->authorize('update', PurchasingRequest::class);

        $data = SpkMain::select('id', 'nomor_order', 'tipe_tagihan', 'customer', 'nomor_purchasing_request', 'nomor_purchasing_request_json', 'revision_count', 'is_using_old_stock')
            ->findOrFail($id);

        if ($data->is_using_old_stock) {
            abort(403);
        }

        if (empty($data->nomor_purchasing_request) && empty($data->nomor_purchasing_request_json)) {
            abort(403, 'SPK belum memiliki PR yang di-assign.');
        }

        return view('dashboard.spk.purchasing-request.edit-pr', [
            'data' => $data,
        ]);
    }
}
