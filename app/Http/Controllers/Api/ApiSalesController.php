<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifySalesNewReportJob;
use App\Models\PhotoCollect;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiSalesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|string',
            'title' => 'required|string|max:128|min:3',
            'customer_name' => 'required|string|max:128|min:3',
            'customer_telp' => 'required|string|max:128|min:3',
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

            $query = Sales::create([
                'kode_pegawai' => $data['kode_pegawai'],
                'title' => $data['title'],
                'customer_name' => $data['customer_name'],
                'customer_telp' => $data['customer_telp'],
                'lokasi' => $data['lokasi'],
                'keterangan' => $data['keterangan'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);

            $folderPath = "sales";

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
                        'id_sales' => $query->id,
                        'photourl' => $imageUrl,
                    ]);
                }
            }

            NotifySalesNewReportJob::dispatch($query->id, $query->created_at)->delay(now()->addSeconds(5));

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
            'customer_name' => 'string|max:128|min:3',
            'customer_telp' => 'string|max:128|min:3',
            'lokasi' => 'string|min:3',
            'keterangan' => 'string|min:3',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        $query = Sales::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update($data);

            return new ApiResource(true, 'Berhasil mengubah data laporan', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat mengubah data', $e->getMessage());
        }
    }

    public function confirm(Request $request, $id)
    {
        if ($request->user()->cannot('sales-approve')) {
            return abort(403);
        }

        $query = Sales::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 1,
                'validate_by' => Auth::id(),
            ]);

            return new ApiResource(true, 'Data berhasil dikonfirmasi', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat mengonfirmasi data', $e->getMessage());
        }
    }

    public function deny(Request $request, $id)
    {
        if ($request->user()->cannot('sales-approve')) {
            return abort(403);
        }

        $query = Sales::find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->update([
                'status' => 2,
                'validate_by' => Auth::id(),
                'notes' => $request->notes
            ]);

            return new ApiResource(true, 'Data berhasil ditolak', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat menolak data', $e->getMessage());
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->user()->cannot('sales-delete')) {
            return abort(403);
        }

        $query = Sales::find($id);

        if (!$query) { // Jika data tidak ditemukan
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        try {
            $query->delete();

            return new ApiResource(true, 'Berhasil menghapus data laporan', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat menghapus data', $e->getMessage());
        }
    }

    public function getById($id)
    {
        $query = Sales::with(['photoCollectRelasi:id_sales,photourl', 'pegawaiRelasi:kode_pegawai,full_name'])->find($id);

        if (!$query) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        return new ApiResource(true, 'Berhasil mengambil data', $query);
    }
}
