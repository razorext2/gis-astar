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

        $data = \App\Models\Spk\SpkMain::select('id', 'nomor_order', 'tipe_tagihan', 'customer', 'nomor_purchasing_request')
            ->findOrFail($id);

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

        $data = \App\Models\Spk\SpkMain::with('purchasingRequests')
            ->findOrFail($id);

        return view('dashboard.spk.purchasing-request.show', [
            'data' => $data,
        ]);
    }
}
