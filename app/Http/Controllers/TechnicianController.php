<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjunganAll";

        try {
            $response = Http::get($url);
            $data = $response->json();

            if ($data['status'] !== "success") {
                return new ApiResource(false, "Terjadi kesalahan saat mengambil data laporan", null);
            }

            // Filter specific columns
            $filteredData = array_map(function ($item) {
                return [
                    'NomorKunjungan' => $item['NomorKunjungan'],
                    'NomorIdentitasTeknisi' => $item['NomorIdentitasTeknisi'],
                    'RincianPekerjaan' => $item['RincianPekerjaan'],
                    'CustomerContact' => $item['CustomerContact'],
                    'AlamatLengkapKunjungan' => $item['AlamatLengkapKunjungan'],
                    'JenisTimbangan' => $item['JenisTimbangan'],
                    'UpdateTeknisi' => $item['UpdateTeknisi'],
                ];
            }, $data['data']);

            if ($request->ajax()) {
                return Datatables::of($filteredData)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($row) {
                        $actions = [
                            [
                                'id' => 'show-btn',
                                'action' => route('sales.show', $row['NomorIdentitasTeknisi']),
                                'label' => 'Detail'
                            ],
                            [
                                'id' => 'edit-btn',
                                'action' => route('sales.edit', $row['NomorIdentitasTeknisi']),
                                'label' => 'Edit'
                            ],
                            [
                                'id' => 'delete-btn',
                                'action' => 'javascript:void(0)',
                                'label' => 'Hapus',
                            ]
                        ];

                        return view('components.dashboard.action-buttons', [
                            'id' => $row['NomorIdentitasTeknisi'],
                            'datas' => $actions,
                        ])->render();
                    })
                    ->editColumn('NomorIdentitasTeknisi', function ($row) {
                        return view('components.dashboard.name-w-code', [
                            'code' => $row['NomorIdentitasTeknisi'],
                            'name' => $row['nama_pegawai'] ?? 'N/A'
                        ])->render();
                    })
                    ->editColumn('RincianPekerjaan', function ($row) {
                        return view('components.dashboard.name-w-code', [
                            'code' => $row['NomorKunjungan'],
                            'name' => $row['RincianPekerjaan']
                        ])->render();
                    })
                    ->editColumn('AlamatLengkapKunjungan', function ($row) {
                        return view('components.dashboard.custom-view-name-w-address', [
                            'recipient' => $row['CustomerContact'],
                            'address' => $row['AlamatLengkapKunjungan'],
                        ])->render();
                    })
                    ->editColumn('UpdateTeknisi', function ($row) {
                        return $row['UpdateTeknisi'] ? Carbon::parse($row['UpdateTeknisi'])->locale('id')->isoFormat('D MMM YYYY / HH:MM:ss') : 'N/A';
                    })
                    ->rawColumns(['actions', 'NomorIdentitasTeknisi', 'RincianPekerjaan', 'AlamatLengkapKunjungan'])
                    ->make(true);
            }

            return view("dashboard.technician.index");
        } catch (\Exception $e) {
            return new ApiResource(false, "Terjadi kesalahan saat mengambil data laporan", $e->getMessage());
        }
    }

    public function create()
    {
        return view('dashboard.technician.add');
    }
}
