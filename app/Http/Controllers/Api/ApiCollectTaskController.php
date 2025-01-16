<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectTaskResource;
use App\Jobs\NotifyCollectorNewAssignedJob;
use App\Models\CollectTask;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Facades\Log;


class ApiCollectTaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        // Check jika data dengan no_sr sudah ada
        $task = CollectTask::where('no_sr', '=', $data['no_sr'])->first();

        if ($task) {
            // Jika ditemukan, update
            $task->update([
                'sr_type' => $request->sr_type,
                'remaining_bill' => $data['remaining_bill'],
                'bill_status' => 0,
                'assign_to' => null,
                'assign_by' => null,
                'assign_date' => $request->assign_date
            ]);
            $query = $task;
        } else {
            // Jika tidak ditemukan, tambahkan
            $query = CollectTask::create($data);
        }

        // Kembalikan response
        return new CollectTaskResource(true, 'Data berhasil diproses!', $query);
    }

    public function getSR($no_sr)
    {
        $query = CollectTask::select('*')
            ->where('no_sr', $no_sr)
            ->first(); // Eksekusi query untuk mendapatkan data pertama

        if ($query) {
            return new CollectTaskResource(true, 'Data ditemukan!', $query);
        } else {
            return new CollectTaskResource(false, 'Data tidak ditemukan!', null);
        }
    }

    public function validateTask(Request $request, $id)
    {
        $query = CollectTask::find($id);

        $query->update([
            // set jadi status selesai
            'bill_status' => 2,
            // set siapa yg validasi
            'validate_by' => $request->validate_by,
        ]);
    }

    public function assignProcess(Request $request, $id)
    {
        $query = CollectTask::find($id);

        if ($query) {
            $query->update([
                'bill_status' => 3,
                'assign_to' => $request->assign_to,
                'assign_by' => $request->assign_by,
            ]);
        }

        $type = $query->sr_type;

        $sr_type = match ($type) {
            'TTT' => 'Tanda Terima Tagihan',
            'TTST' => 'Tanda Terima Sertifikat Tera',
            'AT' => 'Ambil Tagihan',
            'ABL' => 'Antar Bon Lunas',
            default => null,
        };

        // tambahkan laporan tb_collect secara otomatis
        $collector = Collector::create([
            'no_sr' => $query->no_sr,
            'kode_pegawai' => $request->assign_to,
            'title' => $sr_type,
            'location' => $query->customer_address,
            'assign_date' => $query->assign_date,
        ]);

        if ($collector) {
            try {

                $data = Collector::where('kode_pegawai', $request->assign_to)->latest()->first();

                NotifyCollectorNewAssignedJob::dispatch($request->assign_to, $data->id, $query->no_sr)
                    ->delay(now()->addSeconds(5));
            } catch (\Exception $e) {
                Log::error('Notify new assigned job failed for user: ' . $request->assign_to . ' - Error: ' . $e->getMessage());
            }
        }

        return new CollectTaskResource(true, 'Data berhasil di assign', null);
    }

    public function massAssignProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer',
            'sr_data' => 'required|array',
            'sr_data.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Mass update
        CollectTask::whereIn('no_sr', $request->sr_data)->update([
            'bill_status' => 3,
            'assign_to' => $request->kode_pegawai,
            'assign_by' => $request->assign_by,
        ]);

        // Retrieve the updated records
        $query = CollectTask::whereIn('no_sr', $request->sr_data)->get();

        foreach ($query as $data) {
            // Create Collector record for each data
            Collector::create([
                'no_sr' => $data->no_sr,
                'kode_pegawai' => $request->kode_pegawai,
                'title' => $data->customer_name,
                'location' => $data->customer_address,
                'assign_date' => $data->assign_date,
            ]);
        }

        return new CollectTaskResource(true, 'Berhasil menambah assigment', null);
    }

    public function destroy(string $id)
    {
        $query = CollectTask::find($id);

        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $query->delete(); // Menggunakan soft delete bawaan Laravel

        return new CollectTaskResource(true, 'Data berhasil dihapus', null);
    }
}
