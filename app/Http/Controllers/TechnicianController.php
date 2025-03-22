<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Technician;
use App\Models\TechnicianPoints;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
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
        return view("dashboard.technician.index");
    }

    public function create()
    {
        return view('dashboard.technician.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_vt' => 'required|string|max:32',
            'kode_pegawai' => 'required|string|max:32',
            'id_permintaan' => 'required|string|max:100',
            'customer_contact' => 'required|string|max:100',
            'customer_address' => 'required|string|max:100',
            'job_detail' => 'required|string',
            'weight_type' => 'required|string|max:100',
            'size' => 'required|string|max:100',
            'capacity' => 'required|string|max:100',
            'indicator_type' => 'required|string|max:100',
            'indicator_sn' => 'required|string|max:100',
            'loadcell_type' => 'required|string|max:100',
            'loadcell_sn' => 'required|string|max:100',
            'loadcell_qty' => 'required|string|max:50',
            'junction_type' => 'required|string|max:100',
            'job_update' => 'required|string',
            'visit_date' => 'required|string',
            'point' => 'required',
            'partner' => 'required|array',
            // 'partner.*' => 'array',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        try {
            // foreach ($data['partner'] as $partner) {
            //     $response = Http::asForm()->post("https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=updateKunjungan", [
            //         "NomorKunjungan" => $partner,
            //         "UpdatePekerjaan" => $data['job_detail'],
            //         "JenisTimbangan" => $data['weight_type'],
            //         "Ukuran" => $data['size'],
            //         "Kapasitas" => $data['capacity'],
            //         "TipeIndikator" => $data['indicator_type'],
            //         "TipeIndikatorSN" => $data['indicator_sn'],
            //         "TipeLoadcell" => $data['loadcell_type'],
            //         "TipeLoadcellSN" => $data['loadcell_sn'],
            //         "TipeJunctionBox" => $data['junction_type'],
            //         "TipeJunctionBoxSN" => $data['junction_sn'],
            //     ]);
            // }

            foreach ($data['partner'] as $partner) {
                // Cek apakah sudah ada data di database
                $technician = Technician::where('no_vt', $partner['no_vt'])
                    ->where('id_permintaan', $data['id_permintaan'])
                    ->first();

                // Jika data sudah ada, update
                if ($technician) {
                    $technician->update([
                        'weight_type' => $data['weight_type'],
                        'size' => $data['size'],
                        'capacity' => $data['capacity'],
                        'indicator_type' => $data['indicator_type'],
                        'indicator_sn' => $data['indicator_sn'],
                        'loadcell_type' => $data['loadcell_type'],
                        'loadcell_sn' => $data['loadcell_sn'],
                        'loadcell_qty' => $data['loadcell_qty'],
                        'junction_type' => $data['junction_type'],
                        'job_update' => $data['job_update'],
                        'visit_date' => $data['visit_date'],
                        'revised_by' => auth()->user()->id,
                        'revised_at' => now()
                    ]);
                } else {
                    try {
                        DB::beginTransaction();

                        Technician::create([
                            'no_vt' => $partner['no_vt'],
                            'id_permintaan' => $data['id_permintaan'],
                            'kode_pegawai' => $partner['kode_pegawai'],
                            'customer_contact' => $data['customer_contact'],
                            'customer_address' => $data['customer_address'],
                            'job_detail' => $data['job_detail'],
                            'weight_type' => $data['weight_type'],
                            'size' => $data['size'],
                            'capacity' => $data['capacity'],
                            'indicator_type' => $data['indicator_type'],
                            'indicator_sn' => $data['indicator_sn'],
                            'loadcell_type' => $data['loadcell_type'],
                            'loadcell_sn' => $data['loadcell_sn'],
                            'loadcell_qty' => $data['loadcell_qty'],
                            'junction_type' => $data['junction_type'],
                            'job_update' => $data['job_update'],
                            'visit_date' => $data['visit_date']
                        ]);

                        // $kode_pegawai = Technician::where('no_vt', $partner['no_vt'])->pluck('kode_pegawai')->first();

                        TechnicianPoints::create([
                            'from_vt' => $partner['no_vt'],
                            'point' => $data['point'],
                            'kode_pegawai' => $partner['kode_pegawai'],
                        ]);

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return new ApiResource(false, 'Gagal memperbarui kunjungan', $e->getMessage());
                    }
                }
            }

            return new ApiResource(true, 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
            return new ApiResource(false, 'Gagal memperbarui kunjungan', $e->getMessage());
        }
    }

    public function show($id)
    {
        $query = Technician::with('pegawai')
            ->where('no_vt', $id)
            ->first();

        if (!$query) {
            return new ApiResource(false, 'Gagal', 'Laporan kunjungan tidak ditemukan');
        }

        $query->technician_name = $query->pegawai->full_name ?? 'Teknisi belum terdaftar di sistem';
        $query->no_telp = $query->pegawai->no_telp ?? '-';
        $query->update_teknisi = Carbon::parse($query->updated_at)->locale('id')->isoFormat('HH:mm:ss, DD MMMM YYYY');

        return view('dashboard.technician.detail', [
            'data' => $query
        ]);
    }

    public function confirm($id)
    {
        $query = Technician::where('no_vt', $id)->first();
        $point = TechnicianPoints::where('from_vt', $id)->first();

        if (!$query) {
            return new ApiResource(false, 'Gagal', 'Laporan kunjungan tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $query->update([
                'status' => 1,
                'validate_by' => auth()->user()->id,
                'validate_at' => now(),
            ]);

            $point->update([
                'is_redeemable' => 1,
            ]);

            DB::commit();

            return new ApiResource(true, 'Berhasil', 'Laporan kunjungan telah dikonfirmasi');
        } catch (\Exception $e) {
            return new ApiResource(false, 'Gagal', $e->getMessage());
        }
    }
    public function deny(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string|max:200'
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Terjadi kegagalan saat validasi', $validator->errors()->first());
        }

        $query = Technician::where('no_vt', $id)->first();

        if (!$query) {
            return new ApiResource(false, 'Terjadi kegagalan saat mengambil data', 'Laporan kunjungan tidak ditemukan');
        }

        try {
            $query->update([
                'status' => 3,
                'validate_by' => auth()->user()->id,
                'validate_at' => now(),
                'notes' => $request->note
            ]);
            return new ApiResource(true, 'Berhasil', 'Laporan kunjungan telah ditolak');
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kegagalan pada server', $e->getMessage());
        }
    }

    public function revision(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string|max:200'
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Terjadi kegagalan saat validasi', $validator->errors()->first());
        }

        $query = Technician::where('no_vt', $id)->first();

        if (!$query) {
            return new ApiResource(false, 'Terjadi kegagalan saat mengambil data', 'Laporan kunjungan tidak ditemukan');
        }

        try {
            $query->update([
                'status' => 2,
                'validate_by' => auth()->user()->id,
                'validate_at' => now(),
                'notes' => $request->note,
                'total_revision' => $query->total_revision + 1
            ]);
            return new ApiResource(true, 'Berhasil', 'Permintaan revisi telah dikirim');
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kegagalan pada server', $e->getMessage());
        }
    }

    public function getVTFromDB(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_vt' => 'required|string|min:3|max:12',
        ]);

        if ($validator->fails()) {
            return new ApiResource(true, 'Validasi gagal', $validator->errors()->first());
        }

        $no_vt = $request->query('no_vt');

        $technician = Technician::with('pegawai', 'technician_points')
            ->where('no_vt', $no_vt)
            ->first();

        if (!$technician) {
            return new ApiResource(false, 'Data tidak ditemukan', 'Laporan kunjungan tidak ditemukan');
        }

        if ($technician->status == 3 || $technician->status == 1) {
            return new ApiResource(true, 'Laporan telah dikonfirmasi');
        }

        $technician->technician_name = $technician->pegawai->full_name ?? 'Teknisi tidak terdaftar disistem.';
        $technician->point = $technician->technician_points->point;

        $id = rawurlencode($technician->id_permintaan);
        $date = $technician->visit_date;

        $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchKunjunganRelasi&IDPermintaanKunjungan=' . $id . '&TanggalKunjungan=' . $date;

        $response = Http::get($url);

        $partner = $response->json();

        if ($partner['status'] != 'success') {
            return new ApiResource(false, 'Terjadi kegagalan saat mengambil data', $partner['message']);
        }

        $technician->partner = $partner['data'];

        return new ApiResource(true, 'Berhasil mengambil data dari database', $technician);
    }
}
