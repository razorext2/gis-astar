<?php

namespace App\Http\Controllers;

use App\Models\CollectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CollectTask::with('pegawaiRelasi:kode_pegawai,full_name');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('sr_type', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'name' => $data->no_sr,
                        'code' => $data->sr_type
                    ]);
                })
                ->editColumn('customer_name', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => $data->customer_recipient,
                        'time' => $data->customer_name
                    ])->render();
                })
                ->editColumn('total_bill', function ($data) {
                    return 'Rp. ' . number_format($data->total_bill, 0, '', '.') . ',-';
                })
                ->addColumn('actions', function ($data) {
                    return view('components.dashboard.action-buttons', [
                        'id' => $data->id,
                        'datas' => [
                            [
                                'id' => 'show-btn',
                                'permission' => Auth::user()->can('collect-task-list'),
                                'action' => route('collect-task.show', $data->id),
                                'label' => 'Detail'
                            ],
                            [
                                'id' => 'edit-btn',
                                'permission' => Auth::user()->can('collect-task-edit'),
                                'action' => route('collect-task.edit', $data->id),
                                'label' => 'Edit'
                            ],
                            [
                                'id' => 'assign-btn',
                                'permission' => Auth::user()->can('collect-task-assign'),
                                'action' => 'javascript:void(0)',
                                'label' => 'Assign to'
                            ],
                            [
                                'id' => 'delete-btn',
                                'permission' => Auth::user()->can('collect-task-delete'),
                                'action' => 'javascript:void(0)',
                                'label' => 'Hapus',

                            ]
                        ]
                    ])->render();
                })
                ->editColumn('assign_date', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => Carbon::parse($data->assign_date)->locale('id')->isoFormat('DD MMM YYYY'),
                        'time' => $data->assign_to ? 'Oleh: ' . $data->assign_to : 'Belum ditentukan'
                    ])->render();
                })
                ->editColumn('customer_telp', function ($data) {
                    return view('components.dashboard.custom-date', [
                        'date' => 'Tel: ' . $data->customer_telp,
                        'time' => 'Fax: ' . $data->customer_fax
                    ])->render();
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

        return view('dashboard.collect-task.subcontent.main');
    }

    public function create()
    {
        return view('dashboard.collect-task.add');
    }
}
