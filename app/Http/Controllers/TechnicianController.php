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

        try {
            $response = Http::get($url);

            $data = $response->json();

            if ($data['status'] !== "success") {
                return new ApiResource(false, "Terjadi kesalahan saat mengambil data laporan", null);
            }

            $filteredData = array_merge(
                array_filter($data["data"], function ($item) {
                    return $item["NomorIdentitasTeknisi"] == Auth::user()->kode_pegawai && $item["UpdateTeknisi"] == '';
                }),
                array_filter($data["data"], function ($item) {
                    return $item["NomorIdentitasTeknisi"] == Auth::user()->kode_pegawai && $item["UpdateTeknisi"] != '';
                })
            );

            if ($request->ajax()) {
                return Datatables::of(collect($filteredData))
                    ->addIndexColumn()
                    ->addColumn('actions', function ($row) {
                        $actions = [
                            [
                                'id' => 'show-btn',
                                'action' => route('technician.show', Crypt::encryptString($row['NomorKunjungan'])),
                                'label' => 'Detail'
                            ],
                            [
                                'id' => 'edit-btn',
                                'action' => route('technician.create', Crypt::encryptString($row['NomorKunjungan'])),
                                'label' => 'Update'
                            ],
                        ];

                        return view('components.dashboard.action-buttons', [
                            'id' => $row['NomorIdentitasTeknisi'],
                            'datas' => $actions,
                        ])->render();
                    })
                    ->editColumn('NomorIdentitasTeknisi', function ($row) {

                        $user = Cache::remember('tech_data_' . $row['NomorIdentitasTeknisi'], now()->addHours(6), function () use ($row) {
                            return User::select('kode_pegawai', 'name')->where('kode_pegawai', $row['NomorIdentitasTeknisi'])->first();
                        });

                        if (!$user) {
                            return new ApiResource(false, "Nomor identitas teknisi tidak ditemukan", null);
                        }

                        return view('components.dashboard.name-w-code', [
                            'code' => $row['NomorKunjungan'],
                            'name' => $user->name ?? "Teknisi belum terdaftar di sistem",
                            'item3' => $row['NomorIdentitasTeknisi']
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
}
