<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TechnicianController extends Controller
{
    function __construct()
    {
        $this->middleware("permission:technician-list", ["only" => "index"]);
        $this->middleware("permission:technician-create", ["only" => "create"]);
    }

    public function index(Request $request)
    {
        $technician = [
            [
                'kode_vt' => 'VT-001',
                'kode_pegawai' => 'P-101',
                'nama_pegawai' => 'John Doe',
                'title' => 'Perbaikan AC',
                'location' => 'Jakarta Pusat',
                'customer_name' => 'PT Maju Jaya',
                'created_at' => '2023-05-15 09:30:00',
                'updated_at' => '2023-05-15 09:30:00',
            ],
            [
                'kode_vt' => 'VT-002',
                'kode_pegawai' => 'P-102',
                'nama_pegawai' => 'Jane Smith',
                'title' => 'Instalasi Jaringan',
                'location' => 'Surabaya',
                'customer_name' => 'CV Teknologi Unggul',
                'created_at' => '2023-05-20 14:45:00',
                'updated_at' => '2023-05-20 14:45:00',
            ],
            [
                'kode_vt' => 'VT-003',
                'kode_pegawai' => 'P-103',
                'nama_pegawai' => 'Mike Johnson',
                'title' => 'Pemeliharaan Server',
                'location' => 'Bandung',
                'customer_name' => 'PT Data Sentosa',
                'created_at' => '2023-05-25 11:15:00',
                'updated_at' => '2023-05-25 11:15:00',
            ],
            [
                'kode_vt' => 'VT-004',
                'kode_pegawai' => 'P-104',
                'nama_pegawai' => 'Emily Brown',
                'title' => 'Upgrade Sistem',
                'location' => 'Semarang',
                'customer_name' => 'CV Solusi Pintar',
                'created_at' => '2023-05-30 16:00:00',
                'updated_at' => '2023-05-30 16:00:00',
            ],
            [
                'kode_vt' => 'VT-005',
                'kode_pegawai' => 'P-105',
                'nama_pegawai' => 'David Lee',
                'title' => 'Troubleshooting Jaringan',
                'location' => 'Medan',
                'customer_name' => 'PT Koneksi Andalan',
                'created_at' => '2023-06-05 10:30:00',
                'updated_at' => '2023-06-05 10:30:00',
            ]
        ];

        if ($request->ajax()) {
            return Datatables::of(collect($technician))
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $actions = [
                        [
                            'id' => 'show-btn',
                            'action' => route('sales.show', $data['kode_pegawai']),
                            'label' => 'Detail'
                        ],
                        [
                            'id' => 'edit-btn',
                            'action' => route('sales.edit', $data['kode_pegawai']),
                            'label' => 'Edit'
                        ],
                        [
                            'id' => 'delete-btn',
                            'action' => 'javascript:void(0)',
                            'label' => 'Hapus',
                        ]
                    ];

                    return view('components.dashboard.action-buttons', [
                        'id' => $data['kode_pegawai'],
                        'datas' => $actions,
                    ])->render();
                })
                ->editColumn('kode_pegawai', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data['kode_pegawai'],
                        'name' => $data['nama_pegawai']
                    ])->render();
                })
                ->editColumn('title', function ($data) {
                    return view('components.dashboard.name-w-code', [
                        'code' => $data['kode_vt'],
                        'name' => $data['title']
                    ])->render();
                })
                ->editColumn('location', function ($data) {
                    return view('components.dashboard.custom-view-name-w-address', [
                        'recipient' => $data['customer_name'],
                        'address' => $data['location'],
                    ])->render();
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data['created_at'])->locale('id')->isoFormat('dddd, D MMMM YYYY');
                })
                ->rawColumns(['actions', 'kode_pegawai', 'title', 'location'])
                ->make(true);
        }

        return view("dashboard.technician.index");
    }

    public function create()
    {
        return view('dashboard.technician.add');
    }
}
