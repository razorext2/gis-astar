<?php

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Models\PhotoCollect;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

// class ApiCollectorController extends Controller
class ApiCollectController extends Controller
{
    /**
     * Display spesicif list of the resource.
     */
    public function show($id)
    {
        $query = Collector::with('pegawaiRelasi')->find($id);
        return new CollectResource(true, 'Detail data', $query);
    }

    /**
     * Save resource to database.
     */
    public function store(Request $request)
    {
        // Mendefinisikan validator
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer|max_digits:12',
            'title' => 'required|string|max:128|min:5',
            'keterangan' => 'required|string|min:5',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'location' => 'required|string|min:1',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validasi data
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422); // Mengirim status 422 untuk validasi gagal
        }

        // Menambah data jika validasi berhasil
        $data = $validator->validated();
        $collector = Collector::create($data);

        // Memastikan folder 'public/collector' ada, buat jika belum ada

        $folderPath = "public/collectors"; // Consistent path

        // Always use public disk
        if (!Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->makeDirectory($folderPath);

            // Optional: Set permissions if needed
            chmod(storage_path('app/public/' . $folderPath), 0755);
        }

        // Menyimpan gambar dan menambahkan ke tabel tb_photo_collect
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Membuat nama gambar random
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Menyimpan gambar ke folder 'public/collector'
                $imagePath = $folderPath . "/" . $imageName;
                Storage::put($imagePath, file_get_contents($image));

                // Mendapatkan URL gambar
                $imageUrl = Storage::url('collectors/' . $imageName); // Change path to storage/app/public

                // Menyimpan informasi gambar ke tabel tb_photo_collect
                PhotoCollect::create([
                    'id_collect' => $collector->id,
                    'photourl' => $imageUrl,
                ]);
            }
        }

        // Jika request JSON, kembalikan response JSON
        if ($request->isJson()) {
            return new CollectResource(true, 'Data berhasil ditambah!', $collector);
        }

        // Response default jika bukan request JSON
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambah!',
            'data' => $collector
        ]);
    }

    /**
     * Update resource from database.
     */
    public function update(Request $request, $id)
    {
        // define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:128|min:5',
            'keterangan' => 'required|string|min:5',
            'location' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = Collector::find($id);
        $query->update([
            'title' => $request->title,
            'keterangan' => $request->keterangan,
            'location' => $request->location,
        ]);

        // Jika request JSON, kembalikan response JSON
        if ($request->isJson()) {
            return new CollectResource(true, 'Data berhasil diubah!', $query);
        }

        // Response default jika bukan request JSON
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah!',
            'data' => $query
        ]);
    }

    /**
     * Confirm laporan.
     */
    public function confirmCollect($id)
    {
        $query = Collector::find($id);
        $query->update([
            'status' => 1,
        ]);

        return new CollectResource(true, 'Data berhasil dikonfirmasi', null);
    }

    /**
     * Tolak laporan dengan notes.
     */
    public function denyCollect(Request $request, $id)
    {
        $query = Collector::find($id);
        $query->update([
            'status' => 2,
            'notes' => $request->notes,
        ]);

        return new CollectResource(true, 'Data berhasil ditolak', null);
    }

    /**
     * Delete the resource.
     */
    public function destroy($id)
    {
        $query = Collector::find($id);
        $query->delete();

        return new CollectResource(true, 'Data berhasil dihapus', null);
    }
}
