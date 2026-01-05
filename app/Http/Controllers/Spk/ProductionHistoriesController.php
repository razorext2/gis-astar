<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\Spk\Production;

class ProductionHistoriesController extends Controller
{
    public function create($id)
    {
        $data = Production::with(['spk'])
            ->findOrFail($id);

        return view('dashboard.spk.production.history.create',
            ['data' => $data]);
    }
}
