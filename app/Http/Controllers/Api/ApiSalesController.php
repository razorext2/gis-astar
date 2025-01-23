<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifySalesNewReportJob;
use App\Models\PhotoCollect;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiSalesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer',
            'title' => 'required|string|max:128|min:3',
            'lokasi' => 'required|string|max:128|min:3',
            'keterangan' => 'required|string|min:3',
            'latitude' => 'required|string|max:128|min:3',
            'longitude' => 'required|string|max:128|min:3',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // validasi
        if ($validator->fails()) { // Jika validasi gagal
            return response()->json([ // Kembalikan response
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Kode status 422 untuk validasi gagal
        }

        $data = $validator->validated();

        $query = Sales::create([
            'kode_pegawai' => $data['kode_pegawai'],
            'title' => $data['title'],
            'lokasi' => $data['lokasi'],
            'keterangan' => $data['keterangan'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        $folderPath = "public/sales";

        // Jika folder belum ada, maka buat folder
        if (!Storage::disk('public')->exists($folderPath)) { // Jika folder belum ada
            Storage::disk('public')->makeDirectory($folderPath); // Buat folder

            // Mengatur permission folder
            chmod(storage_path('app/public/' . $folderPath), 0755);
        }

        // Jika request memiliki file 'images'
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) { // Looping setiap gambar
                // Membuat nama gambar baru
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Menyimpan gambar ke storage
                $imagePath = $folderPath . "/" . $imageName; // Path gambar
                Storage::put($imagePath, file_get_contents($image)); // Simpan gambar

                // Mendapatkan URL gambar
                $imageUrl = Storage::url('sales/' . $imageName); // URL gambar

                // Menyimpan informasi gambar ke tabel tb_photo_collect
                PhotoCollect::create([ // Simpan data
                    'id_sales' => $query->id,
                    'photourl' => $imageUrl,
                ]);
            }
        }

        if ($query) {
            try {
                NotifySalesNewReportJob::dispatch($query->id, $query->created_at)->delay(now()->addSecons(5));
            } catch (\Exception $e) {
                Log::error('Notify sales has new report failed' . $e->getMessage());
            }
        }


        return new ApiResource(true, 'Berhasil menambah data laporan', $query);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'string|max:128|min:3',
            'lokasi' => 'string|max:128|min:3',
            'keterangan' => 'string|min:3',
        ]);

        if ($validator->fails()) { // Jika validasi gagal
            return response()->json([ // Kembalikan response
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Kode status 422 untuk validasi gagal
        }

        $data = $validator->validated();

        $query = Sales::find($id);

        $query->update($data);

        return new ApiResource(true, 'Berhasil mengubah data laporan', $query);
    }

    public function confirm(Request $request,  $id)
    {
        $validateBy = Crypt::decryptString($request->user_id);

        $query = Sales::findOrFail($id);

        if ($query) {
            try {
                $query->update([
                    'status' => 1,
                    'validate_by' => $validateBy,
                ]);

                return new ApiResource(true, 'Data berhasil dikonfirmasi', $query);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function deny(Request $request, $id)
    {
        $validateBy = Crypt::decryptString($request->user_id);

        $query = Sales::findOrFail($id);

        if ($query) {
            try {
                $query->update([
                    'status' => 2,
                    'validate_by' => $validateBy,
                    'notes' => $request->notes
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function destroy($id)
    {
        $query = Sales::findOrFail($id);

        if (!$query) { // Jika data tidak ditemukan
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404); // Kembalikan response
        }

        $query->delete();

        return new ApiResource(false, 'Berhasil menghapus data laporan', $query);
    }
}
