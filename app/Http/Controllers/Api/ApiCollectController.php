<?php

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Models\CollectTask;
use App\Models\PhotoCollect;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifyCollectorHasUpdatedReportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        // Update data
        $query = Collector::find($id);

        if (!$query) { // Jika data tidak ditemukan
            return new ApiResource(false, 'Laporan tidak ditemukan', null);
        }

        try {
            DB::beginTransaction();

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

            $folderPath = 'collectors';

            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = Storage::disk('public')->putFileAs($folderPath, $image, $imageName);

                    $imageUrl = '/storage/' . $folderPath . '/' . $imageName;

                    PhotoCollect::create([
                        'id_collect' => $id,
                        'photourl' => $imageUrl,
                    ]);
                }
            }

            NotifyCollectorHasUpdatedReportJob::dispatch($query->no_sr, $query->id, now())
                ->delay(now()->addSeconds(5));

            DB::commit();
            return new ApiResource(true, 'Laporan berhasil diubah!', $query);
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat memproses request', $e->getMessage());
        }
    }

    /**
     * Confirm laporan.
     */
    public function confirmCollect($id, Request $request): ApiResource
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        // Cari data berdasarkan ID
        $query = Collector::find($id);

        if (!$query) {
            return new ApiResource(false, 'Laporan tidak ditemukan', null);
        }

        // Decrypt user_id
        $validate_by = Crypt::decryptString($request->input('user_id'));

        // Cari data task
        $task = CollectTask::where('no_sr', $query->no_sr)->first();

        if (!$task) {
            return new ApiResource(false, 'Nomor tagihan tidak ditemukan', null);
        }

        // Validasi jumlah pembayaran
        if ($task->remaining_bill < $query->payment_amount) {
            return new ApiResource(false, 'Jumlah pembayaran melebihi sisa tagihan', null);
        }

        try {
            DB::beginTransaction();

            // Update collector
            $query->update([
                'status' => 1,
                'validate_by' => $validate_by,
            ]);

            // Update task
            $task->update([
                'bill_status' => 1,
                'remaining_bill' => $task->remaining_bill - $query->payment_amount,
            ]);

            DB::commit();
            return new ApiResource(true, 'Laporan berhasil dikonfirmasi', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat memproses request', $e->getMessage());
        }
    }

    /**
     * Tolak laporan dengan notes.
     */
    public function denyCollect(Request $request, $id)
    {
        $query = Collector::find($id); // Cari data berdasarkan ID

        if (!$query) {
            return new ApiResource(false, 'Laporan tidak ditemukan', null);
        }

        $validate_by = Crypt::decryptString($request->input('user_id')); // Decrypt user_id

        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
            'validate_by' => 'required',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $query->update([ // Update data
                'status' => 3,
                'notes' => $request->notes,
                'validate_by' => $validate_by,
            ]);

            DB::commit();
            return new ApiResource(true, 'Laporan berhasil ditolak', null); // Kembalikan response JSON
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat memproses request', $e->getMessage());
        }
    }

    /**
     * Delete the resource.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $query = Collector::findOrFail($id);
            $query->delete();

            DB::commit();
            return new ApiResource(true, 'Laporan berhasil dihapus', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return new ApiResource(false, 'Terjadi kesalahan saat menghapus laporan', null);
        }
    }
}
