<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CollectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collect-list', ['only' => 'index']);
        $this->middleware('permission:collect-create', ['only' => 'create']);
        $this->middleware('permission:collect-edit', ['only' => 'edit']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Collector::with(['pegawaiRelasi:kode_pegawai,full_name', 'collectTaskRelasi'])
                ->whereNull('deleted_at');

            if (!Auth::user()->can('collect-approve')) {
                $query->where('kode_pegawai', Auth::user()->kode_pegawai);
            }

            $query->orderBy('status', 'desc');

            return DataTables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('no_sr', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->short_title,
                        'name' => $data->no_sr
                    ]);
                })
                ->editColumn('title', function ($data) {
                    return view('components.dashboard.title-w-status', [
                        'title' => $data->collectTaskRelasi->customer_name,
                        'status' => $data->status,
                        'item3' => $data->collectTaskRelasi->short_customer_address
                    ]);
                })
                ->editColumn('payment_type', function ($data) {
                    if ($data->have_paid == 0) {
                        $status = 'Belum bayar';
                    } elseif ($data->have_paid == 1) {
                        $status = 'Cicilan';
                    } elseif ($data->have_paid == 2) {
                        $status = 'Lunas';
                    }

                    if ($data->payment_type == 0) {
                        $type = 'Tidak ada';
                    } elseif ($data->payment_type == 1) {
                        $type = 'Cash';
                    } elseif ($data->payment_type == 2) {
                        $type = 'Transfer';
                    } elseif ($data->payment_type == 3) {
                        $type = 'Giro';
                    }

                    return view('components.table-component.payment-detail', [
                        'data' => [
                            [
                                'title' => 'Status',
                                'data' => $status,
                            ],
                            [
                                'title' => 'Metode',
                                'data' => $type,
                            ],
                            [
                                'title' => 'Bayar',
                                'data' => 'Rp. ' . number_format($data->payment_amount, 0, ',', '.')
                            ],

                        ]
                    ]);
                })
                ->editColumn('created_at', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => $data->created_at->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => $data->created_at->locale('id')->isoFormat('HH:mm:ss')
                    ]);
                })
                ->addColumn('actions', function ($data) {
                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'datas' => [
                            [
                                'id' => 'show-btn',
                                'permission' => Auth::user()->can('collect-list'),
                                'action' => route('collect.show', $data->id),
                                'label' => 'Detail'
                            ],
                            [
                                'id' => 'edit-btn',
                                'permission' => Auth::user()->can('collect-edit'),
                                'action' => route('collect.edit', $data->id),
                                'label' => 'Edit'
                            ],
                            [
                                'id' => 'delete-btn',
                                'permission' => Auth::user()->can('collect-delete'),
                                'action' => 'javascript:void(0)',
                                'label' => 'Hapus',
                            ]
                        ],
                    ]);
                })
                // ->filter(function ($query) use ($request) {
                //     if ($request->filled("title")) {
                //         $query->where('title', "LIKE", "%{$request->title}%");
                //     }

                //     if ($request->filled("no_sr")) {
                //         $query->where('no_sr', "LIKE", "%{$request->no_sr}%");
                //     }

                //     if ($request->filled("status")) {
                //         $query->where('status', "LIKE", "%{$request->status}%");
                //     }

                //     if ($request->filled("startDate") && $request->filled("endDate")) {
                //         $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                //     }
                // })
                ->rawColumns(['actions', 'no_sr', 'title',  'payment_type', 'created_at'])
                ->toJson();
        }

        return view('dashboard.collect.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Cache::remember('collector_data_' . $id, 1800, function () use ($id) {
            return Collector::with('photoCollectRelasi', 'pegawaiRelasi')->findOrFail($id);
        });

        return view('dashboard.collect.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Cache::remember('collector_data_' . $id, 1800, function () use ($id) {
            return Collector::with('photoCollectRelasi', 'pegawaiRelasi', 'collectTaskRelasi')->findOrFail($id);
        });

        return view('dashboard.collect.edit', compact('data'));
    }
}
