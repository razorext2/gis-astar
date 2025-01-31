<?php

namespace App\Http\Controllers;

use App\Models\CollectIdyPpn;
use App\Models\Collector;
use App\Models\User;
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CollectIdyPpnController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:collect-idy-ppn-list', ['index', 'onProgress', 'pending', 'completed', 'show']);
        $this->middleware('permission:collect-idy-ppn-create', ['create']);
        $this->middleware('permission:collect-idy-ppn-assign', ['massAssign']);
    }

    public function index()
    {
        return view('dashboard.collect-idy-ppn.subcontent.main');
    }

    public function onProgress()
    {
        return view('dashboard.collect-idy-ppn.subcontent.on-progress');
    }

    public function pending()
    {
        return view('dashboard.collect-idy-ppn.subcontent.pending');
    }

    public function completed()
    {
        return view('dashboard.collect-idy-ppn.subcontent.completed');
    }

    public function showdata(Request $request)
    {
        $query = CollectIdyPpn::query()
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
                        'name' => $data->tax_invoice ?? 'N/A',
                        'code' => $data->sr_type ?? 'N/A',
                        'item3' => $data->sales_invoice ?? 'N/A',
                    ]);
                })
                ->editColumn('customer_name', function ($data) {
                    return view('components.dashboard.custom-view-name-w-address', [
                        'recipient' => $data->customer_recipient ?? 'N/A',
                        'name' => $data->short_customer_name ?? 'N/A',
                        'address' => $data->customer_address ?? 'N/A',
                    ]);
                })
                ->editColumn('total_bill', function ($data) {
                    return view('components.table-component.payment-detail', [
                        'status' => 1,
                        'data' => [
                            [
                                'title' => 'Total',
                                'data' => Number::currency($data->total_bill ?? 0, 'IDR', 'id'),
                            ],
                            [
                                'title' => 'Sisa',
                                'data' => Number::currency($data->remaining_bill ?? 0, 'IDR', 'id'),
                            ]
                        ]
                    ]);
                })
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'show-btn',
                            'action' => route('collect-idy-ppn.show', $data->id),
                            'label' => 'Detail'
                        ],
                    ];

                    if ($data->bill_status == 0) {
                        $actions[] = [
                            'id' => 'assign-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Assign to'
                        ];

                        $actions[] = [
                            'id' => 'reschedule-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Ubah jadwal'
                        ];

                        if (auth()->user()->can('collect-idy-ppn-delete')) {
                            $actions[] = [
                                'id' => 'delete-btn',
                                'action' => 'javascript:void(0)',
                                'label' => 'Hapus',
                            ];
                        }
                    }

                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'datas' => $actions
                    ]);
                })
                ->editColumn('assign_date', function ($data) {
                    return view('components.dashboard.date-w-name', [
                        'date' => Carbon::parse($data->assign_date)->locale('id')->isoFormat('DD MMM YYYY'),
                        'name' => $data->assign_to ? 'Oleh: ' . $data->userRelasi->name : 'Belum ditentukan',
                    ]);
                })
                ->editColumn('customer_telp', function ($data) {
                    return view('components.dashboard.custom-tel-and-fax', [
                        'tel' => 'Tel: ' . $data->customer_telp,
                        'fax' => 'Fax: ' . $data->customer_fax
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
        return view('dashboard.collect-idy-ppn.add');
    }

    public function show($id)
    {
        $data = CollectIdyPpn::findOrFail($id);
        $no_sr = $data->tax_invoice;

        $collect = Collector::where('no_sr', '=', $no_sr)
            ->orderBy('created_at', 'asc')
            ->get();

        $user = User::select('kode_pegawai', 'name')->where('kode_pegawai', $data->validate_by)->first();

        return view('dashboard.collect-idy-ppn.detail', compact('data', 'collect', 'user'));
    }

    public function massAssign()
    {
        return view('dashboard.collect-idy-ppn.mass-assign');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query'); // Mengambil input dari request

        // Cari nama pengguna berdasarkan input
        $data = CollectIdyPpn::select(['id', 'no_sr', 'customer_name', 'customer_address'])
            ->where('no_sr', 'LIKE', "%{$search}%")
            ->where('assign_to', '=', null)
            ->limit(10)
            ->get();

        return response()->json($data); // Kembalikan hasil sebagai JSON
    }
}
