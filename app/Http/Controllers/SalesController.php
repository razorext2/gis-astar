<?php

/** Goal: Controller for sales report operations and validation, Caller: Routes web.php, Deps: App\Models\Sales, App\Models\Pegawai */

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Sales;
use App\Services\Sales\SalesRegionResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sales-list', ['only' => 'index', 'show']);
        $this->middleware('permission:sales-create', ['only' => 'create']);
        $this->middleware('permission:sales-edit', ['only' => 'edit']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        return view('dashboard.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        if (! auth()->user()->can('sales-create')) {
            abort(403);
        }

        return view('dashboard.sales.add');
    }

    /**
     * Display the specified resource.
     */
    public function show(int|string $id): \Illuminate\Contracts\View\View
    {
        $data = Sales::with([
            'pegawaiRelasi:id,kode_pegawai,full_name',
            'pegawaiRelasi.userRelasi:id,kode_pegawai,is_active',
            'photoCollectRelasi',
            'validateBy:id,name,is_active'
        ])->findOrFail($id);

        if ($data->kode_pegawai != auth()->user()->kode_pegawai && ! auth()->user()->can('sales-approve')) {
            abort(403);
        }

        return view('dashboard.sales.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int|string $id): \Illuminate\Contracts\View\View
    {
        $data = Sales::with(['pegawaiRelasi:kode_pegawai,full_name', 'photoCollectRelasi'])->findOrFail($id);

        if ($data->kode_pegawai != auth()->user()->kode_pegawai && ! auth()->user()->can('sales-approve')) {
            abort(403);
        }

        return view('dashboard.sales.edit', compact('data'));
    }
}
