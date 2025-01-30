<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
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
            ->with(['pegawaiRelasi:kode_pegawai,full_name', 'collectTaskRelasi', 'collectTaskPpnRelasi'])
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

        if (!Auth::user()->can('collect-approve')) {
            $query->whereDate('assign_date', Carbon::now());
        }

        $query->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_sr', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data->short_title ?? 'N/A',
                        'name' => $data->no_sr ?? 'N/A',
                        'item3' => $data->pegawaiRelasi->full_name ?? 'N/A',
                    ]);
                })
                ->editColumn('title', function ($data) {
                    return view('components.dashboard.title-w-status', [
                        'title' => match ($data->bill_type) {
                            'idcnonppn' => strtoupper($data->collectTaskRelasi->customer_recipient ?? 'N/A'),
                            'idcppn' => strtoupper($data->collectTaskPpnRelasi->customer_recipient ?? 'N/A'),
                            'idyppn' => strtoupper($data->collectIdyPpnRelasi->customer_recipient ?? 'N/A'),
                            default => 'N/A',
                        } . " ( " . strtoupper($data->bill_type ?? 'N/A') . " )",
                        'status' => $data->status ?? 'N/A',
                        'item3' => $data->location ?? 'N/A'
                    ]);
                })
                ->editColumn('payment_type', function ($data) {
                    if ($data->have_paid == 0) {
                        $status = 'Belum bayar';
                    } elseif ($data->have_paid == 1) {
                        $status = 'Cicilan';
                    } elseif ($data->have_paid == 2) {
                        $status = 'Lunas';
                    } elseif ($data->have_paid == 3) {
                        $status = 'Tanda Terima';
                    } elseif ($data->have_paid == 4) {
                        $status = 'Belum sempat';
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

                    if ($data->have_paid == 1 || $data->have_paid == 2) {
                        return view('components.table-component.payment-detail', [
                            'status' => $data->have_paid,
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
                                    'data' => Number::currency($data->payment_amount ?? 0, 'IDR', 'id')
                                ],

                            ]
                        ]);
                    } else {
                        return $status;
                    }
                })
                ->editColumn('created_at', function ($data) {

                    if (is_null($data->assign_at)) {
                        $date = $data->assign_date ?? '00:00:00';
                    } else {
                        $date = $data->assign_at;
                    }

                    return view('components.dashboard.custom-date', [
                        'date' => Carbon::parse($date)->locale('id')->isoFormat('D MMMM YYYY'),
                        'time' => Carbon::parse($date)->locale('id')->isoFormat('HH:mm:ss')
                    ]);
                })
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'show-btn',
                            'action' => route('collect.show', $data->id),
                            'label' => 'Detail'
                        ]
                    ];

                    if (Auth::user()->hasRole('Admin')) {
                        $actions[] = [
                            'id' => 'edit-btn',
                            'action' => route('collect.edit', $data->id),
                            'label' => 'Edit'
                        ];

                        $actions[] = [
                            'id' => 'delete-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Hapus',
                        ];
                    }

                    if (Auth::user()->can('collect-approve')) {
                        return view('components.dashboard.action-buttons', [
                            'id' => $data->id,
                            'datas' => $actions,
                        ]);
                    } else {
                        if ($data->status == 0) {
                            return view('components.dashboard.single-button', [
                                'id' => $data->id,
                                'data' => [
                                    'id' => 'editBtn' . $data->id,
                                    'action' => route('collect.edit', $data->id),
                                    'label' => 'Lengkapi',
                                ]
                            ]);
                        } else {
                            return view('components.dashboard.single-button', [
                                'id' => $data->id,
                                'data' => [
                                    'id' => 'detailBtn' . $data->id,
                                    'action' => route('collect.show', $data->id),
                                    'label' => 'Detail',
                                ]
                            ]);
                        }
                    }
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

        $user =  User::select('id', 'name')->where('id', $data->validate_by)->first();

        return view('dashboard.collect.detail', compact('data', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Cache::remember('collector_data_' . $id, 1800, function () use ($id) {
            return Collector::with('photoCollectRelasi', 'pegawaiRelasi', 'collectTaskRelasi', 'collectTaskPpnRelasi')->findOrFail($id);
        });

        return view('dashboard.collect.edit', compact('data'));
    }
}
