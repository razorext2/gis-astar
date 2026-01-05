<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;

class PurchasingRequestController extends Controller
{
    public function index()
    {
        return view('dashboard.spk.purchasing-request.index');
    }

    public function edit($id)
    {
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
        $data = \App\Models\Spk\SpkMain::with('purchasingRequests')
            ->findOrFail($id);

        return view('dashboard.spk.purchasing-request.show', [
            'data' => $data,
        ]);
    }
}
