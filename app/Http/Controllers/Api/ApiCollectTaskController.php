<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifyCollectorNewAssignedJob;
use App\Models\CollectTask;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiCollectTaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ // Validasi data
            'no_sr' => 'required|string|min:3|max:16',
            'sr_type' => 'required|string',
            'sr_date' => 'required|date',
            'customer_name' => 'required|string|min:5',
            'customer_recipient' => 'nullable|string|max:128',
            'customer_address' => 'required|string|max:256',
            'customer_telp' => 'required|string|min:1|max:64',
            'customer_fax' => 'nullable|string|min:1|max:15',
            'shipping_address' => 'nullable|string',
            'total_bill' => 'required|numeric|min:0',
            'remaining_bill' => 'required|numeric|min:0',
            'assign_date' => 'required|date',
        ]);

        if ($validator->fails()) { // Jika validasi gagal
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $validator->validated(); // Ambil data yang sudah divalidasi

        $task = CollectTask::withTrashed()->where('no_sr', '=', $data['no_sr'])->first(); // Cek apakah data sudah ada

        if ($task) { // Jika data ditemukan
            if ($task->trashed()) { // Jika data sudah dihapus
                $task->restore(); // Restore data yang sudah dihapus
            }

            $task->update([ // Update data
                'sr_type' => $data['sr_type'],
                'remaining_bill' => $data['remaining_bill'],
                'bill_status' => 0,
                'assign_to' => null,
                'assign_by' => null,
                'assign_date' => $data['assign_date']
            ]); // Update data

            $query = $task; // Set data yang diupdate ke variabel $query

        } else {
            $query = CollectTask::create($data); // Buat data baru
        }

        // Kembalikan response
        return new ApiResource(true, 'Data berhasil diproses!', $query);
    }

    public function getSR($no_sr)
    {
        $query = CollectTask::select('*') // Query untuk mengambil data
            ->where('no_sr', $no_sr)
            ->first(); // Eksekusi query untuk mendapatkan data pertama

        if ($query) { // Jika data ditemukan
            return new ApiResource(true, 'Data ditemukan!', $query); // Kembalikan response
        } else {
            return new ApiResource(false, 'Data tidak ditemukan!', null); // Kembalikan response
        }
    }

    public function validateTask(Request $request, $id)
    {
        $query = CollectTask::find($id); // Cari data berdasarkan ID

        $query->update([ // Update data
            // set jadi status selesai
            'bill_status' => 2,
            // set siapa yg validasi
            'validate_by' => $request->validate_by,
        ]);
    }

    public function assignProcess(Request $request, $id)
    {
        $query = CollectTask::find($id); // Cari data berdasarkan ID

        if ($query) { // Jika data ditemukan
            $query->update([ // Update data
                'bill_status' => 3,
                'assign_to' => $request->assign_to,
                'assign_by' => $request->assign_by,
            ]);
        }

        $type = $query->sr_type; // Ambil tipe SR

        $sr_type = match ($type) { // Cek tipe SR
            'TTT' => 'Tanda Terima Tagihan',
            'TTST' => 'Tanda Terima Sertifikat Tera',
            'AT' => 'Ambil Tagihan',
            'ABL' => 'Antar Bon Lunas',
            default => null,
        };

        // Tambahkan data ke tb_collect
        $collector = Collector::create([
            'no_sr' => $query->no_sr,
            'kode_pegawai' => $request->assign_to,
            'title' => $sr_type,
            'location' => $query->customer_address,
            'assign_date' => $query->assign_date,
        ]);

        // Kirim notifikasi ke user yang di assign
        if ($collector) { // Jika data berhasil ditambahkan
            try { // Coba kirim notifikasi
                $data = Collector::where('kode_pegawai', $request->assign_to)->latest()->first(); // Ambil data terbaru

                NotifyCollectorNewAssignedJob::dispatch($request->assign_to, $data->id, $query->no_sr)
                    ->delay(now()->addSeconds(5)); // Kirim notifikasi ke user yang di assign
            } catch (\Exception $e) {
                Log::error('Notify new assigned job failed for user: ' . $request->assign_to . ' - Error: ' . $e->getMessage()); // Log error jika gagal
            }
        }

        // Kembalikan response
        return new ApiResource(true, 'Data berhasil di assign', null);
    }

    public function massAssignProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [ // Validasi data
            'kode_pegawai' => 'required|integer',
            'sr_data' => 'required|array',
            'sr_data.*' => 'required|string',
        ]);

        if ($validator->fails()) { // Jika validasi gagal
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        // Update banyak data sekaligus
        CollectTask::whereIn('no_sr', $request->sr_data)->update([ // Update data
            'bill_status' => 3,
            'assign_to' => $request->kode_pegawai,
            'assign_by' => $request->assign_by,
        ]); // Menggunakan whereIn untuk mengupdate banyak data sekaligus

        // Ambil data yang sudah di update
        $query = CollectTask::whereIn('no_sr', $request->sr_data)->get();

        // Looping data yang sudah di update
        foreach ($query as $data) { // Looping data
            $collector = Collector::create([
                'no_sr' => $data->no_sr,
                'kode_pegawai' => $request->kode_pegawai,
                'title' => $data->customer_name,
                'location' => $data->customer_address,
                'assign_date' => $data->assign_date,
            ]); // Tambahkan data ke tb_collect

            // Kirim notifikasi ke user yang di assign
            if ($collector) { // Jika data berhasil ditambahkan
                try { // Coba kirim notifikasi
                    $data = Collector::where('kode_pegawai', $request->kode_pegawai)->latest()->first(); // Ambil data terbaru

                    NotifyCollectorNewAssignedJob::dispatch($request->kode_pegawai, $data->id, $data->no_sr)
                        ->delay(now()->addSeconds(5)); // Kirim notifikasi ke user yang di assign
                } catch (\Exception $e) {
                    // Log error jika gagal
                    Log::error('Notify new assigned job failed for user: ' . $request->kode_pegawai . ' - Error: ' . $e->getMessage());
                }
            }
        }

        // Kembalikan response
        return new ApiResource(true, 'Berhasil menambah assigment', null);
    }

    public function reschedule(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $request->all();

        $query = CollectTask::find($id);

        $query->update([
            'assign_date' => $data['date']
        ]);

        return new ApiResource(true, 'Berhasil melakukan reschedule', null);
    }


    public function destroy(string $id)
    {
        $query = CollectTask::find($id); // Cari data berdasarkan ID

        if (!$query) { // Jika data tidak ditemukan
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        $query->delete(); // Menggunakan soft delete bawaan Laravel

        // Kembalikan response
        return new ApiResource(true, 'Data berhasil dihapus', null);
    }
}
