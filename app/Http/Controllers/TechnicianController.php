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
            'loadcell_type' => 'string|max:100',
            'loadcell_sn' => 'required|string|max:100',
            'loadcell_qty' => 'required|string|max:50',
            'junction_type' => 'required|string|max:100',
            'job_update' => 'required|string',
            'visit_date' => 'required|string',
            'point' => 'required',
            'partner' => 'required|array',
            // 'partner.*' => 'array',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        try {
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
                    try {
                        DB::beginTransaction();

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

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return new ApiResource(false, 'Gagal memperbarui kunjungan', $e->getMessage());
                    }
                }

                // upload image
                $folderPath = "technician";

                if (!Storage::disk('public')->exists($folderPath)) {
                    Storage::disk('public')->makeDirectory($folderPath);
                }

                if ($request->hasFile('images')) {
                    $manager = ImageManager::gd();

                    foreach ($request->file('images') as $image) {
                        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                        $img = $manager->read($image);

                        // Baca logo dan resize dulu watermark-nya
                        $logo = $manager->read(public_path('assets/img/logo.png'))
                            ->resize(100, 22);

                        // Tempelkan logo ke pojok kanan bawah
                        $img->place($logo, 'top-left', 10, $img->height() - 75, 90); // 90 itu opacity

                        // Tambahkan watermark
                        $img->text($technician->customer_contact, 10, $img->height() - 40, function (FontFactory $font) {
                            $font->filename(public_path('assets/fonts/OpenSans-Regular.ttf'));
                            $font->size(10);
                            $font->color('#ffffff');
                            $font->align('left');
                            $font->valign('bottom');
                        });

                        $img->text($technician->customer_address, 10, $img->height() - 30, function (FontFactory $font) {
                            $font->filename(public_path('assets/fonts/OpenSans-Regular.ttf'));
                            $font->size(8);
                            $font->color('#ffffff');
                            $font->align('left');
                            $font->valign('bottom');
                        });

                        $img->text($technician->kode_pegawai . ' - ' . ($technician->pegawai?->full_name ?? 'Teknisi belum terdaftar disistem'), 10, $img->height() - 20, function (FontFactory $font) {
                            $font->filename(public_path('assets/fonts/OpenSans-Regular.ttf'));
                            $font->size(8);
                            $font->color('#ffffff');
                            $font->align('left');
                            $font->valign('bottom');
                        });

                        $img->text($technician->updated_at, 10, $img->height() - 10, function (FontFactory $font) {
                            $font->filename(public_path('assets/fonts/OpenSans-Regular.ttf'));
                            $font->size(8);
                            $font->color('#ffffff');
                            $font->align('left');
                            $font->valign('bottom');
                        });

                        // Simpan gambar ke storage
                        $path = $folderPath . '/' . $imageName;
                        Storage::disk('public')->put($path, (string) $img->encode());

                        $imageUrl = '/storage/' . $path;

                        $upload = PhotoCollect::create([
                            'no_vt' => $partner['no_vt'],
                            'photourl' => $imageUrl,
                        ]);

                        if (!$upload) {
                            return new ApiResource(false, 'Gagal menyimpan gambar');
                        }
                    }
                } else {
                    return new ApiResource(false, 'Dokumentasi tidak boleh kosong', 'Anda harus menyertakan dokumentasi setiap update laporan.');
                }
            }

            return new ApiResource(true, 'Laporan berhasil diperbarui');
        } catch (\Exception $e) {
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

        if ($technician->kode_pegawai != Auth::user()->kode_pegawai) {
            return new ApiResource(false, 'Anda tidak memiliki akses', 'Anda tidak memiliki akses untuk melihat data ini');
        }

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
