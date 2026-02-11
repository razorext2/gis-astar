<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\PurchasingRequest;

class PurchasingRequestController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', PurchasingRequest::class);

        return view('dashboard.spk.purchasing-request.index');
    }

    public function edit($id)
    {
        $this->authorize('update', PurchasingRequest::class);

        $data = \App\Models\Spk\SpkMain::select('id', 'nomor_order', 'tipe_tagihan', 'customer', 'nomor_purchasing_request', 'revision_count', 'is_using_old_stock')
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

    public function show($id)
    {
        $this->authorize('view', PurchasingRequest::class);

        // cek apakah spk ini sudah memiliki purchasing request
        $spk = \App\Models\Spk\SpkMain::select('id', 'nomor_purchasing_request', 'nomor_purchasing_request_json', 'nomor_order', 'revision_count', 'customer', 'is_using_old_stock')
            ->findOrFail($id);

        $data = PurchasingRequest::where('id_spk', $id);

        $is_multiple = ! empty($spk->nomor_purchasing_request_json);

        if (! empty($spk->nomor_purchasing_request)) {
            $data = $data->where('id_spk', $id)
                ->get();
        } elseif (! empty($spk->nomor_purchasing_request_json)) {
            $data = $data->whereIn('nomor_purchasing_request', $spk->nomor_purchasing_request_json)
                ->get()
                ->groupBy('nomor_purchasing_request');
        } else {
            $data = [];
        }

        return view('dashboard.spk.purchasing-request.show', [
            'spk' => $spk,
            'data' => $data,
            'is_multiple' => $is_multiple,
        ]);
    }
}
