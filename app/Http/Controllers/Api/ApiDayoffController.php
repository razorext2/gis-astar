<?php

namespace App\Http\Controllers\Api;

use App\Models\Dayoff;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\PhotoCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Validator;

class ApiDayoffController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer|max_digits:32',
            'dayoff_for' => 'required|string|min:2|max:10',
            'tgl_dari' => 'required|date|min:5|max:32',
            'tgl_hingga' => 'required|date|min:5|max:32',
            'keterangan' => 'required|string|min:5',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi data
        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $validator->validated();

        try {
            DB::beginTransaction();

            $query = Dayoff::create([
                'kode_pegawai' => $data['kode_pegawai'],
                'dayoff_for' => $data['dayoff_for'],
                'tgl_dari' => $data['tgl_dari'],
                'tgl_hingga' => $data['tgl_hingga'],
                'keterangan' => $data['keterangan'],
            ]);

            $folderPath = "dayoff";

            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            // save images
            $imgUrl = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs($folderPath, $image, $imageName);
                    $imageUrl = '/storage/' . $folderPath . '/' . $imageName;
                    $imgUrl[] = $imageUrl;
                }
            }

            if ($imgUrl) {
                $query->update([
                    'url' => json_encode($imgUrl),
                ]);
            }

            DB::commit();

            // kembalikan response JSON
            return new ApiResource(true, 'Berhasil membuat pengajuan.', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat menyimpan data', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dayoff_for' => 'required|string',
            'tgl_dari' => 'required|date',
            'tgl_hingga' => 'required|date',
            'keterangan' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $query = Dayoff::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'dayoff_for' => $request->dayoff_for,
                'tgl_dari' => $request->tgl_dari,
                'tgl_hingga' => $request->tgl_hingga,
                'keterangan' => $request->keterangan,
            ]);

            return new ApiResource(true, 'Data berhasil diubah!', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat memperbarui data', $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'validate_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $query = Dayoff::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 1,
                'validate_by' => $request->validate_by,
            ]);

            return new ApiResource(true, 'Data berhasil dikonfirmasi', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat memperbarui data', $e->getMessage());
        }
    }

    public function deny(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
            'validate_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $query = Dayoff::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 2,
                'notes' => $request->notes,
                'validate_by' => $request->validate_by,
            ]);

            return new ApiResource(true, 'Data berhasil dikonfirmasi', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat memperbarui data', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $query = Dayoff::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->delete();

            return new ApiResource(true, 'Data berhasil dihapus!', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat menghapus data', $e->getMessage());
        }
    }
}
