<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Pegawai;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Sales::query()->with(['pegawaiRelasi']);

                $user = Auth::user();

                // Jika user tidak memiliki izin 'sales-approve', batasi berdasarkan kode pegawai
                if (! $user->can('sales-approve')) {
                    $query->where('kode_pegawai', $user->kode_pegawai);
                }

                // Filter relasi user yang memiliki role 'Kurir-Bank
                if ($user->hasRole('Kasir')) {
                    $query->whereHas('userRelasi.roles', function ($role) {
                        $role->where('name', 'Kurir-Bank');
                    });
                }

                // Filter relasi user yang memiliki role 'Sales'
                if ($user->hasRole('Marketing')) {
                    $query->orWhereHas('userRelasi.roles', function ($r) {
                        $r->where('name', 'Sales');
                    });
                }

                // Filter relasi user yang memiliki role 'Sales-JKT'
                if ($user->hasAnyRole(['Marketing-JKT', 'Management-JKT'])) {
                    $query->orWhereHas('userRelasi.roles', function ($r) {
                        $r->where('name', 'Sales-JKT');
                    });
                }

                // Filter relasi user yang memiliki role 'Sales-PKU'
                if ($user->hasAnyRole(['Marketing-PKU', 'Management-PKU'])) {
                    $query->orWhereHas('userRelasi.roles', function ($r) {
                        $r->where('name', 'Sales-PKU');
                    });
                }

                $query->orderBy('status')
                    ->latest();

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($data) {
                        $actions = [
                            [
                                'id' => 'show-btn',
                                'action' => route('sales.show', $data->id),
                                'label' => 'Detail',
                            ],
                        ];

                        if (auth()->user()->can('sales-approve')) {
                            $confirm = false;

                            if ($data->status == 0) {
                                $confirm = true;
                            }

                            if (auth()->user()->can('sales-delete')) {
                                $actions[] = [
                                    'id' => 'edit-btn',
                                    'action' => route('sales.edit', $data->id),
                                    'label' => 'Edit',
                                ];

                                $actions[] = [
                                    'id' => 'delete-btn',
                                    'action' => 'javascript:void(0)',
                                    'label' => 'Hapus',
                                ];
                            }

                            return view('components.dashboard.action-buttons', [
                                'id' => $data->id,
                                'datas' => $actions,
                                'confirm' => $confirm,
                            ])->render();
                        } else {
                            return view('components.dashboard.single-button', [
                                'id' => $data->id,
                                'data' => [
                                    'id' => 'detailBtn'.$data->id,
                                    'action' => route('sales.show', $data->id),
                                    'label' => 'Detail',
                                ],
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
                            'created' => $data->created_at,
                            'updated' => '',
                        ])->render();
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('kode_pegawai')) {
                            $query->whereHas('pegawaiRelasi', function ($query) use ($request) {
                                $query->where('full_name', 'LIKE', "%{$request->kode_pegawai}%");
                            });
                        }

                        if ($request->filled('title')) {
                            $query->where('title', 'LIKE', "%{$request->title}%");
                        }

                        if ($request->filled('customer_name')) {
                            $query->where('customer_name', 'LIKE', "%{$request->customer_name}%");
                        }

                        if ($request->filled('status')) {
                            $query->where('status', 'LIKE', "%{$request->status}%");
                        }

                        if ($request->filled('startDate') && $request->filled('endDate')) {
                            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
                        }

                        if ($request->filled('roles')) {
                            $query->whereHas('userRelasi.roles', function ($query) use ($request) {
                                $query->whereIn('name', (array) $request->roles);
                            });
                        }

                    })
                    ->rawColumns(['actions', 'title', 'customer_name', 'kode_pegawai', 'lokasi', 'created_at'])
                    ->toJson();
            } catch (\Exception $e) {
                return new ApiResource(false, 'Terjadi kesalahan saat mengambil data', $e->getMessage());
            }
        }

        return view('dashboard.sales.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('sales-create')) {
            return abort(403);
        }

        return view('dashboard.sales.add');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Sales::with(['pegawaiRelasi:kode_pegawai,full_name', 'photoCollectRelasi', 'validateBy'])->findOrFail($id);

        if ($data->kode_pegawai != auth()->user()->kode_pegawai && ! auth()->user()->can('sales-approve')) {
            return abort(403);
        }

        return view('dashboard.sales.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Sales::with(['pegawaiRelasi:kode_pegawai,full_name', 'photoCollectRelasi'])->findOrFail($id);

        if ($data->kode_pegawai != auth()->user()->kode_pegawai && ! auth()->user()->can('sales-approve')) {
            return abort(403);
        }

        return view('dashboard.sales.edit', compact('data'));
    }
}
