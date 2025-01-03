<?php

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Models\PhotoCollect;
use App\Models\CollectTask;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// class ApiCollectorController extends Controller
class ApiCollectController extends Controller
{
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
            'latitude' => 'required|string|min:1',
            'longitude' => 'required|string|min:1',
            'have_paid' => 'required|integer|min_digits:1',
            'payment_type' => 'required|string|min:1|max:12',
            'payment_amount' => 'required|integer|min_digits:1',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = Collector::find($id);

        // dd($query->no_sr);

        $query->update([
            'title' => $request->title,
            'keterangan' => $request->keterangan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'have_paid' => $request->have_paid,
            'payment_type' => $request->payment_type,
            'payment_amount' => $request->payment_amount,
            'status' => 2,
            'location' => $request->location
        ]);

        $task = CollectTask::where('no_sr', '=', $query->no_sr)->first();

        $task->update([
            'remaining_bill' => $task->remaining_bill - $request->payment_amount,
        ]);

        // image upload process
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
                    'id_collect' => $id,
                    'photourl' => $imageUrl,
                ]);
            }
        }

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

        $noSr = $query->no_sr;

        $task = CollectTask::where('no_sr', $noSr)->first();

        $task->update([
            'bill_status' => 1,
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

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $query->delete();

        return new CollectResource(true, 'Data berhasil dihapus', null);
    }
}
