<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CollectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collect-list', ['only' => 'index']);
        $this->middleware('permission:collect-create', ['only' => 'create']);
        $this->middleware('permission:collect-edit', ['only' => 'edit']);
    }

    public function index()
    {
        return view('dashboard.collect.subcontent.main');
    }

    public function approved()
    {
        return view('dashboard.collect.subcontent.approved');
    }

    public function submitted()
    {
        return view('dashboard.collect.subcontent.submitted');
    }

    public function rejected()
    {
        return view('dashboard.collect.subcontent.rejected');
    }

    public function showdata(Request $request)
    {
        $query = Collector::query()
            ->with(['pegawaiRelasi:kode_pegawai,full_name', 'collectTaskRelasi'])
            ->whereNull('deleted_at');

        if (!Auth::user()->can('collect-approve')) {
            $query->where('kode_pegawai', Auth::user()->kode_pegawai);
        }

        $status = $request->get('s');

        if ($status == 'approved') {
            // filter status = 1 (disetujui)
            $query->where('status', '=', 1);
        } elseif ($status == 'submitted') {
            // filter status = 2 (diajukan)
            $query->where('status', '=', 2);
        } elseif ($status == 'rejected') {
            // filter status = 3 (ditolak)
            $query->where('status', '=', 3);
        } else {
            $query->where('status', '=', 0);
        }

        $query->latest();

        if ($request->ajax()) {
            return DataTables::of($query->latest())
                ->addIndexColumn()
                ->editColumn('no_sr', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->collectTaskRelasi->sr_type . ' / ' . $data->short_title,
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

                    if (is_null($data->assign_at)) {
                        $date = $data->collectTaskRelasi->assign_date;
                    } else {
                        $date = $data->assign_at;
                    }

                    return view('components.dashboard.custom-date', [
                        'date' => Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => Carbon::parse($date)->locale('id')->isoFormat('HH:mm:ss')
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
                ->filter(function ($query) use ($request) {
                    if ($request->filled("customer_name")) {
                        $query->where('title', "LIKE", "%{$request->customer_name}%");
                    }

                    if ($request->filled("no_sr")) {
                        $query->where('no_sr', "LIKE", "%{$request->no_sr}%");
                    }

                    if ($request->filled("status")) {
                        $query->where('status', "LIKE", "%{$request->status}%");
                    }

                    if ($request->filled("startDate") && $request->filled("endDate")) {
                        $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }
                })
                ->rawColumns(['actions', 'no_sr', 'title',  'payment_type', 'created_at'])
                ->toJson();
        }
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
