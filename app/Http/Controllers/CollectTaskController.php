<?php

namespace App\Http\Controllers;

use App\Models\CollectTask;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CollectTaskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collect-task-list', ['only' => 'index']);
        $this->middleware('permission:collect-task-create', ['only' => 'create']);
        $this->middleware('permission:collect-task-edit', ['only' => 'edit']);
        $this->middleware('permission:collect-task-assign', ['only' => 'assign']);
    }

    public function index()
    {
        return view('dashboard.collect-task.subcontent.main');
    }

    public function onProgress()
    {
        return view('dashboard.collect-task.subcontent.on-progress');
    }

    public function pending()
    {
        return view('dashboard.collect-task.subcontent.pending');
    }

    public function completed()
    {
        return view('dashboard.collect-task.subcontent.completed');
    }

    public function showdata(Request $request)
    {
        $query = CollectTask::query()
            ->with(['pegawaiRelasi:id,kode_pegawai,full_name']);

        $status = $request->get('status');

        if ($status == 'on-progress') {
            // filter bill_status = 1 (sedang berjalan)
            $query->where('bill_status', '=', 1);
        } elseif ($status == 'pending') {
            // filter bill_status = 3 (tertunda)
            $query->where('bill_status', '=', 3);
        } elseif ($status == 'completed') {
            // filter bill_status = 2 (selesai)
            $query->where('bill_status', '=', 2);
        } else {
            $query->whereNull('assign_to');
        }

        // urutkan data berdasarkan data terakhir
        $query->latest();

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('sr_type', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'name' => $data->no_sr ?? 'N/A',
                        'code' => $data->sr_type ?? 'N/A'
                    ]);
                })
                ->editColumn('customer_name', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => $data->customer_recipient ?? 'N/A',
                        'time' => $data->short_customer_name ?? 'N/A'
                    ]);
                })
                ->editColumn('total_bill', function ($data) {
                    return view('components.table-component.payment-detail', [
                        'status' => 1,
                        'data' => [
                            [
                                'title' => 'Total',
                                'data' => 'Rp. ' . number_format($data->total_bill, 0, ',', '.'),
                            ],
                            [
                                'title' => 'Sisa',
                                'data' => 'Rp. ' . number_format($data->remaining_bill, 0, ',', '.'),
                            ]
                        ]
                    ]);
                })
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'show-btn',
                            'action' => route('collect-task.show', $data->id),
                            'label' => 'Detail'
                        ],
                    ];

                    if ($data->bill_status == 0) {
                        $actions[] = [
                            [
                                'id' => 'assign-btn',
                                'action' => 'javascript:void(0)',
                                'label' => 'Assign to'
                            ],
                            [
                                'id' => 'delete-btn',
                                'action' => 'javascript:void(0)',
                                'label' => 'Hapus',
                            ]
                        ];
                    }

                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'datas' => $actions
                    ]);
                })
                ->editColumn('assign_date', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => Carbon::parse($data->assign_date)->locale('id')->isoFormat('DD MMM YYYY'),
                        'time' => $data->assign_to ? 'Oleh: ' . $data->pegawaiRelasi->full_name : 'Belum ditentukan'
                    ]);
                })
                ->editColumn('customer_telp', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => 'Tel: ' . $data->customer_telp,
                        'time' => 'Fax: ' . $data->customer_fax
                    ]);
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled("customer_name")) {
                        $query->where('customer_name', "LIKE", "%{$request->customer_name}%");
                    }

                    if ($request->filled("no_sr")) {
                        $query->where('no_sr', "LIKE", "%{$request->no_sr}%");
                    }

                    if ($request->filled("sr_type")) {
                        $query->where('sr_type', "LIKE", "%{$request->sr_type}%");
                    }

                    if ($request->filled("startDate") && $request->filled("endDate")) {
                        $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }
                })
                ->rawColumns(['actions', 'customer_name', 'sr_type', 'assign_date', 'customer_telp'])
                ->toJson();
        }
    }

    public function create()
    {
        return view('dashboard.collect-task.add');
    }

    public function show($id)
    {
        $data = CollectTask::findOrFail($id);
        $no_sr = $data->no_sr;

        $collect = Collector::where('no_sr', '=', $no_sr)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dashboard.collect-task.detail', compact('data', 'collect'));
    }

    public function massAssign()
    {
        return view('dashboard.collect-task.mass-assign');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query'); // Mengambil input dari request

        // Cari nama pengguna berdasarkan input
        $data = CollectTask::select(['id', 'no_sr', 'customer_name', 'customer_address'])
            ->where('no_sr', 'LIKE', "%{$search}%")
            ->where('assign_to', '=', null)
            ->limit(10)
            ->get();

        return response()->json($data); // Kembalikan hasil sebagai JSON
    }
}
