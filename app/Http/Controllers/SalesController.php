<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sales::query()
            ->with(['pegawaiRelasi']);

        if (!Auth::user()->can('sales-approve')) {
            $query->where('kode_pegawai', Auth::user()->kode_pegawai);
        }

        $query->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'show-btn',
                            'action' => route('sales.show', $data->id),
                            'label' => 'Detail'
                        ]
                    ];

                    if (Auth::user()->hasRole('Admin')) {
                        $actions[] = [
                            'id' => 'edit-btn',
                            'action' => route('sales.edit', $data->id),
                            'label' => 'Edit'
                        ];

                        $actions[] = [
                            'id' => 'delete-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Hapus',
                        ];
                    }

                    if (Auth::user()->can('sales-approve')) {
                        return view('components.dashboard.action-buttons', [
                            'id' => $data->id,
                            'datas' => $actions,
                        ])->render();
                    } else {
                        return view('components.dashboard.single-button', [
                            'id' => $data->id,
                            'data' => [
                                'id' => 'detailBtn' . $data->id,
                                'action' => route('sales.show', $data->id),
                                'label' => 'Detail',
                            ]
                        ])->render();
                    }
                })
                ->editColumn('kode_pegawai', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->kode_pegawai ?? 'N/A',
                        'name' => $data->pegawaiRelasi->full_name ?? 'N/A',
                    ])->render();
                })
                ->editColumn('title', function ($data) {
                    return view('components.dashboard.title-w-status-two', [
                        'status' => $data->status,
                        'title' => $data->short_title,
                    ])->render();
                })
                ->editColumn('customer_name', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->customer_telp ?? 'N/A',
                        'name' => $data->customer_name ?? 'N/A',
                    ])->render();
                })
                ->editColumn('lokasi', function ($data) {
                    return view('components.dashboard.location-w-coordinate', [
                        'location' => $data->lokasi ?? 'N/A',
                        'long' => $data->longitude ?? 'N/A',
                        'lat' => $data->latitude ?? 'N/A',
                    ])->render();
                })
                ->editColumn('created_at', function ($data) {
                    return view('components.dashboard.created-updated', [
                        'created' => $data->created_at->locale('id')->isoFormat('D MMM YYYY / HH:MM:ss') ?? 'N/A',
                        'updated' => $data->updated_at->locale('id')->isoFormat('D MMM YYYY / HH:MM:ss') ?? 'N/A',
                    ])->render();
                })
                ->rawColumns(['actions', 'title', 'customer_name', 'kode_pegawai', 'lokasi', 'created_at'])
                ->toJson();
        }

        return view("dashboard.sales.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sales.add');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Sales::with(['pegawaiRelasi:kode_pegawai,full_name', 'photoCollectRelasi'])->findOrFail($id);

        $user = User::select('id', 'name')->where('id', $data->validate_by)->first();

        return view('dashboard.sales.detail', compact('data', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Sales::with(['pegawaiRelasi:kode_pegawai,full_name', 'photoCollectRelasi'])->findOrFail($id);

        return view('dashboard.sales.edit', compact('data'));
    }
}
