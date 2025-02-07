<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
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

        if ($request->ajax()) {
            try {
                $response = Http::get($url);

                $data = $response->json();

                if ($data['status'] !== "success") {
                    return new ApiResource(false, "Terjadi kesalahan saat mengambil data laporan", null);
                }

                $filteredData = array_slice(
                    array_filter($data["data"], function ($item) use ($request) {
                        $status = $request->status;

                        $data = ($status == 1 ? $item["UpdateTeknisi"] != '' : $item["UpdateTeknisi"] == '');

                        if ($request->filled('no_vt')) {
                            $data = $item['NomorKunjungan'] == $request->no_vt;
                            return $data;
                        }

                        if ($request->filled('customer_name')) {
                            $data = strpos($item['CustomerContact'], $request->customer_name) !== false;
                            return $data;
                        }

                        if ($request->filled('kode_pegawai')) {
                            $data = $item['NomorIdentitasTeknisi'] == $request->kode_pegawai;
                            return $data;
                        }

                        return $data;
                    }),
                    0,
                    $request->filled('total_data') ? $request->total_data : 100
                );

                return Datatables::of(collect($filteredData))
                    ->addIndexColumn()
                    ->addColumn('actions', function ($row) {
                        $actions = [
                            [
                                'id' => 'show-btn',
                                'action' => route('technician.show', $row['NomorKunjungan']),
                                'label' => 'Detail'
                            ],
                            [
                                'id' => 'edit-btn',
                                'action' => route('technician.create', $row['NomorKunjungan']),
                                'label' => 'Update'
                            ],
                        ];

                        return view('components.dashboard.action-buttons', [
                            'id' => $row['NomorIdentitasTeknisi'],
                            'datas' => $actions,
                        ])->render();
                    })
                    ->editColumn('NomorIdentitasTeknisi', function ($row) {
                        return view('components.dashboard.name-w-code', [
                            'code' => $row['NomorKunjungan'] ?? 'N/A',
                            'name' => "Teknisi belum terdaftar di sistem",
                            'item3' => $row['NomorIdentitasTeknisi'] ?? 'N/A'
                        ])->render();
                    })
                    ->editColumn('AlamatLengkapKunjungan', function ($row) {
                        return view('components.dashboard.custom-view-name-w-address', [
                            'address' => $row['AlamatLengkapKunjungan'],
                            'recipient' => $row['CustomerContact'],
                            'name' => Carbon::parse($row['TanggalKunjungan'])->locale('id')->isoFormat('D MMMM YYYY'),
                        ])->render();
                    })
                    ->editColumn('JenisTimbangan', function ($row) {
                        return $row['JenisTimbangan'] == '' ? '-' : $row['JenisTimbangan'];
                    })
                    ->editColumn('UpdateTeknisi', function ($row) {
                        return $row['UpdateTeknisi'] ? Carbon::parse($row['UpdateTeknisi'])->locale('id')->isoFormat('DD MMM YYYY, HH:MM:ss') : 'Belum diupdate';
                    })
                    ->rawColumns(['actions', 'NomorIdentitasTeknisi', 'AlamatLengkapKunjungan', 'UpdateTeknisi'])
                    ->make(true);
            } catch (\Exception $e) {
                return new ApiResource(false, "Terjadi kesalahan saat mengambil data laporan", $e->getMessage());
            }
        }
        return view("dashboard.technician.index");
    }

    public function create()
    {
        return view('dashboard.technician.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_vt' => 'required|string|max:256',
            'job_detail' => 'required|string|max:256',
            'weight_type' => 'required|string|max:256',
            'size' => 'required|string|max:256',
            'capacity' => 'required|string|max:256',
            'indicator_type' => 'required|string|max:256',
            'indicator_sn' => 'required|string|max:256',
            'loadcell_type' => 'required|string|max:256',
            'loadcell_sn' => 'required|string|max:256',
            'junction_type' => 'required|string|max:256',
            'junction_sn' => 'required|string|max:256',
            'partner' => 'required|array',
            'partner.*' => 'string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        try {
            foreach ($data['partner'] as $partner) {
                $response = Http::asForm()->post("https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=updateKunjungan", [
                    "NomorKunjungan" => $partner,
                    "UpdatePekerjaan" => $data['job_detail'],
                    "JenisTimbangan" => $data['weight_type'],
                    "Ukuran" => $data['size'],
                    "Kapasitas" => $data['capacity'],
                    "TipeIndikator" => $data['indicator_type'],
                    "TipeIndikatorSN" => $data['indicator_sn'],
                    "TipeLoadcell" => $data['loadcell_type'],
                    "TipeLoadcellSN" => $data['loadcell_sn'],
                    "TipeJunctionBox" => $data['junction_type'],
                    "TipeJunctionBoxSN" => $data['junction_sn'],
                ]);
            }

            $result = $response->json();

            return new ApiResource(true, 'Data berhasil diupdate', $result);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Gagal memperbarui kunjungan', $e->getMessage());
        }
    }

    public function show(Request $request, $no_vt)
    {
        $user = User::select('kode_pegawai', 'name');

        if ($request->ajax()) {
            $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjungan&NomorKunjungan=" . $no_vt;

            try {
                $response = Http::get($url);
                $result = $response->json();

                if ($result['status'] != 'success') {
                    return new ApiResource(false, 'Gagal mengambil data kunjungan', $result['message']);
                }

                $data = $result['data'][0];

                return new ApiResource(true, 'Data berhasil diambil', $data);
            } catch (\Exception $e) {
                return new ApiResource(false, 'Gagal mengambil data kunjungan', $e->getMessage());
            }
        }

        return view('dashboard.technician.detail', compact(['user', 'no_vt']));
    }
}
