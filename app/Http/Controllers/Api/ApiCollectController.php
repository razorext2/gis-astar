<?php

namespace App\Http\Controllers\Api;

use App\Jobs\NotifyCollectorHasUpdatedReportJob;
use App\Models\Collector;
use App\Models\PhotoCollect;
use App\Models\CollectTask;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

// class ApiCollectorController extends Controller
class ApiCollectController extends Controller
{
    /**
     * Update resource from database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
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

        // Jika validasi gagal, kembalikan response JSON
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update data
        $query = Collector::find($id); // Cari data berdasarkan ID

        if ($query) { // Jika data ditemukan
            $query->update([ // Update data
                'keterangan' => $request->keterangan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'have_paid' => $request->have_paid,
                'payment_type' => $request->payment_type,
                'payment_amount' => $request->payment_amount,
                'status' => 2,
                'assign_at' => now(),
                'location' => $request->location
            ]);
        }

        // Mengurangi sisa tagihan pada tabel tb_collect_task
        $task = CollectTask::where('no_sr', '=', $query->no_sr)->first(); // Cari data berdasarkan no_sr

        $task->update([ // Update data
            'remaining_bill' => $task->remaining_bill - $request->payment_amount, // Kurangi sisa tagihan
        ]);

        // Membuat folder 'public/collectors' jika belum ada
        $folderPath = "public/collectors";

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
                $imageUrl = Storage::url('collectors/' . $imageName); // URL gambar

                // Menyimpan informasi gambar ke tabel tb_photo_collect
                PhotoCollect::create([ // Simpan data
                    'id_collect' => $id,
                    'photourl' => $imageUrl,
                ]);
            }
        }

        // Kirim notifikasi ke user yang memiliki permission 'collect-approve'
        if ($query) { // Jika data ditemukan
            try { // Coba kirim notifikasi
                // Kirim notifikasi ke user yang memiliki permission 'collect-approve'
                NotifyCollectorHasUpdatedReportJob::dispatch($query->no_sr, $query->id, now())
                    ->delay(now()->addSeconds(5));
            } catch (\Exception $e) { // Jika gagal kirim notifikasi
                Log::error('Notify collector has updated report failed for user: ' . $query->kode_pegawai . ' - Error: ' . $e->getMessage()); // Log error
            }
        }

        // Kembalikan response JSON
        return new CollectResource(true, 'Data berhasil diubah!', $query);
    }

    /**
     * Confirm laporan.
     */
    public function confirmCollect($id, Request $request)
    {
        // Cari data berdasarkan ID
        $query = Collector::find($id);

        // Decrypt user_id
        $validate_by = Crypt::decryptString($request->input('user_id'));

        // Update data
        $query->update([
            'status' => 1,
            'validate_by' => $validate_by,
        ]);

        $noSr = $query->no_sr; // Ambil no_sr

        $task = CollectTask::where('no_sr', $noSr)->first(); // Cari data berdasarkan no_sr

        $task->update([ // Update data
            'bill_status' => 1,
        ]);

        return new CollectResource(true, 'Data berhasil dikonfirmasi', null); // Kembalikan response JSON
    }

    /**
     * Tolak laporan dengan notes.
     */
    public function denyCollect(Request $request, $id)
    {
        $query = Collector::find($id); // Cari data berdasarkan ID

        $validate_by = Crypt::decryptString($request->input('user_id')); // Decrypt user_id

        $query->update([ // Update data
            'status' => 2,
            'notes' => $request->notes,
            'validate_by' => $validate_by,
        ]);

        return new CollectResource(true, 'Data berhasil ditolak', null); // Kembalikan response JSON
    }

    /**
     * Delete the resource.
     */
    public function destroy($id)
    {
        $query = Collector::find($id); // Cari data berdasarkan ID

        if (!$query) { // Jika data tidak ditemukan
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404); // Kembalikan response JSON
        }

        $query->delete(); // Hapus data

        return new CollectResource(true, 'Data berhasil dihapus', null); // Kembalikan response JSON
    }
}
