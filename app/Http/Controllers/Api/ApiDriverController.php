<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Driver;
use App\Models\PhotoCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiDriverController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|string',
            'title' => 'required|string|max:128|min:3',
            'lokasi' => 'required|string|min:3',
            'keterangan' => 'required|string|min:3',
            'latitude' => 'required|string|max:128|min:3',
            'longitude' => 'required|string|max:128|min:3',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $validator->validated();

        try {
            DB::beginTransaction();

            $query = Driver::create([
                'kode_pegawai' => $data['kode_pegawai'],
                'title' => $data['title'],
                'lokasi' => $data['lokasi'],
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude'],
                'keterangan' => $data['keterangan'],
            ]);

            $folderPath = "driver";

            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                    Storage::disk('public')->putFileAs($folderPath, $image, $imageName);

                    $imageUrl = '/storage/' . $folderPath . '/' . $imageName;

                    PhotoCollect::create([
                        'id_driver' => $query->id,
                        'photourl' => $imageUrl,
                    ]);
                }
            }

            DB::commit();
            return new ApiResource(true, 'Berhasil menambah data laporan', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat menambah data', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'string|max:128|min:3',
            'lokasi' => 'string|min:3',
            'keterangan' => 'string|min:3',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        $query = Driver::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update($data);

            $query->update([
                'revised_by' => auth()->user()->id,
                'status' => 0,
            ]);

            return new ApiResource(true, 'Berhasil mengubah data laporan', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat mengubah data', $e->getMessage());
        }
    }

    public function confirm($id)
    {
        $query = Driver::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 1,
                'validate_by' => auth()->user()->id,
            ]);

            return new ApiResource(true, 'Data berhasil dikonfirmasi', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat mengonfirmasi data', $e->getMessage());
        }
    }

    public function deny(Request $request, $id)
    {
        $query = Driver::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 2,
                'validate_by' => auth()->user()->id,
                'notes' => $request->notes
            ]);

            return new ApiResource(true, 'Data berhasil ditolak', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat menolak data', $e->getMessage());
        }
    }

    public function revision(Request $request, $id)
    {
        $query = Driver::find($id); // Cari data berdasarkan ID

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        if ($query->total_revision >= 2) {
            return new ApiResource(false, 'Tidak dapat memberikan revisi', 'Laporan sudah mencapai batas revisi');
        }

        $validate_by = $request->input('user_id'); // Decrypt user_id

        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
            'user_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $query->update([
                'status' => 3,
                'notes' => $request->notes,
                'validate_by' => $validate_by,
                'total_revision' => $query->total_revision + 1,
            ]);

            DB::commit();
            return new ApiResource(true, 'Permintaan revisi sudah dikirim.', null); // Kembalikan response JSON
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat memproses request', $e->getMessage());
        }
    }
}
