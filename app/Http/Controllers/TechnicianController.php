<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\PhotoCollect;
use App\Models\Technician;
use App\Models\TechnicianPoints;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class TechnicianController extends Controller
{
    function __construct()
    {
        $this->middleware("permission:technician-list", ["only" => "index"]);
        $this->middleware("permission:technician-create", ["only" => "create"]);
    }

    public function index()
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
            'no_vt' => 'required|string',
            'kode_pegawai' => 'required|string',
            'id_permintaan' => 'required|string',
            'customer_contact' => 'required|string',
            'customer_address' => 'required|string',
            'job_detail' => 'required|string',
            'weight_type' => 'required|string',
            'size' => 'required|string',
            'capacity' => 'required|string',
            'indicator_type' => 'required|string',
            'indicator_sn' => 'required|string',
            'loadcell_type' => 'string',
            'loadcell_sn' => 'required|string',
            'loadcell_qty' => 'required|string',
            'junction_type' => 'required|string',
            'job_update' => 'required|string',
            'visit_date' => 'required|string',
            'point' => 'required',
            'partner' => 'required|array',
            // 'partner.*' => 'array',
            'status' => 'integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        try {
            DB::beginTransaction();

            foreach ($data['partner'] as $partner) {
                // decode json partner
                $partner = json_decode($partner, true);

                // Cek apakah sudah ada data di database
                $technician = Technician::where('no_vt', $partner['no_vt'])
                    ->where('id_permintaan', $data['id_permintaan'])
                    ->first();

                // cek apakah sudah ada data poinnya?
                $point = TechnicianPoints::where('from_vt', $partner['no_vt'])
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
                        'revised_by' => Auth::id(),
                        'revised_at' => now(),
                        'status' => $data['status'],
                    ]);
                } else {
                    // validasi ada dokumen gak?
                    $validate = Validator::make($request->allFiles(), [
                        'bast_document' => 'required|file|mimes:pdf|max:10240',
                    ]);

                    if ($validate->fails()) {
                        return new ApiResource(false, 'Validasi gagal', $validate->errors()->first());
                    }

                    $technician = Technician::create([
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
                        'visit_date' => $data['visit_date'],
                        'status' => $data['status'],
                    ]);

                    // kalo blm ada, tambah
                    if (!$point) {
                        TechnicianPoints::create([
                            'from_vt' => $partner['no_vt'],
                            'point' => $data['point'],
                            'kode_pegawai' => $partner['kode_pegawai'],
                        ]);
                    } else { // kalo sudah ada, update
                        $point->update([
                            'point' => $data['point'],
                            'kode_pegawai' => $partner['kode_pegawai'],
                            'is_redeemable' => 0,
                            'is_redeeemed' => 0,
                            'redeemed_status' => 0,
                            'redeemed_date' => null,
                            'deleted_at' => null,
                        ]);
                    }
                }

                if ($request->file('bast_document')) {
                    // simpan dokumen
                    $no_vt = strtoupper($partner['no_vt']);

                    $document = $request->file('bast_document');
                    $documentName = 'dokumen_bast_' . $no_vt . '.' . $document->getClientOriginalExtension();
                    $document->storeAs('public/technician/pdf', $documentName);

                    $check = PhotoCollect::where('no_vt', $no_vt)
                        ->where('photourl', 'pdf/' . $documentName)
                        ->first();

                    if ($check) {
                        $upload = $check->update([
                            'updated_at' => now(),
                        ]);
                    } else {
                        $upload = PhotoCollect::create([
                            'no_vt' => $no_vt,
                            'photourl' => 'pdf/' . $documentName,
                        ]);
                    }

                    if (!$upload) {
                        return new ApiResource(false, 'Gagal mengupload dokumen.');
                    }
                }
            }

            DB::commit();
            return new ApiResource(true, 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Gagal memperbarui kunjungan', $e->getMessage());
        }
    }

    public function show($id)
    {
        $query = Technician::with('pegawai', 'photo_collects:id,no_vt,photourl')
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
                'validate_by' => Auth::id(),
                'validate_at' => now(),
            ]);

            $point->update([
                'is_redeemable' => 1,
            ]);

            // kirim update ke API
            Http::asForm()->post("https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=updateKunjungan", [
                "NomorKunjungan" => $query->no_vt,
                "UpdatePekerjaan" => $query->job_update,
                "JenisTimbangan" => $query->weight_type,
                "Ukuran" => $query->size,
                "Kapasitas" => $query->capacity,
                "TipeIndikator" => $query->indicator_type,
                "TipeIndikatorSN" => $query->indicator_sn,
                "TipeLoadcell" => $query->loadcell_type,
                "TipeLoadcellSN" => $query->loadcell_sn,
                "TipeJunctionBox" => $query->junction_type,
                "TipeJunctionBoxSN" => $query->loadcell_qty,
            ]);

            DB::commit();

            return new ApiResource(true, 'Berhasil', 'Laporan kunjungan telah dikonfirmasi, laporan telah diteruskan ke server.');
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
                'validate_by' => Auth::id(),
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
                'validate_by' => Auth::id(),
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

        $technician = Technician::with('pegawai:kode_pegawai,full_name', 'technician_points:id,from_vt,point', 'photo_collects:id,no_vt,photourl')
            ->where('no_vt', $no_vt)
            ->first();

        if (!$technician) {
            return new ApiResource(false, 'Data tidak ditemukan', 'Laporan kunjungan tidak ditemukan');
        }

        // if ($technician->kode_pegawai != Auth::user()->kode_pegawai && Auth::user()->can('technician-approve')) {
        //     return new ApiResource(false, 'Anda tidak memiliki akses', 'Anda tidak memiliki akses untuk melihat data ini');
        // }

        if ($technician->status == 1) {
            return new ApiResource(true, 'Laporan telah diperiksa');
        }

        $technician->technician_name = $technician->pegawai->full_name ?? 'Teknisi tidak terdaftar disistem.';
        $technician->point = $technician->technician_points()->first()?->point;
        $technician->photo_collects = $technician->photo_collects->map(function ($photo_collect) {
            return [
                'id' => $photo_collect->id,
                'no_vt' => $photo_collect->no_vt,
                'photourl' => $photo_collect->photourl
            ];
        });

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

    public function fetchUpdate($id)
    {
        return view('dashboard.technician.fetch-update', [
            'id' => $id
        ]);
    }
}
