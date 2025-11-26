<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifyCollectorNewAssignedJob;
use App\Models\Collector;
use App\Models\CollectTask;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCollectTaskController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_sr' => 'required|string|min:3|max:20',
            'sr_type' => 'required|string',
            'sr_date' => 'required|date',
            'customer_name' => 'required|string|min:5',
            'customer_recipient' => 'required|string|max:128',
            'customer_address' => 'required|string|max:128',
            'customer_telp' => 'required|string|min:1|max:128',
            'customer_fax' => 'required|string|min:1|max:128',
            'shipping_address' => 'min:0',
            'total_bill' => 'required|numeric|min:0',
            'remaining_bill' => 'required|numeric|min:0',
            'assign_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $validator->validated();

        $task = CollectTask::withTrashed()->where('no_sr', '=', $data['no_sr'])->first();

        try {
            DB::beginTransaction();

            if ($task) {
                if ($task->trashed()) {
                    $task->restore();
                }

                $task->update([
                    'sr_type' => $data['sr_type'],
                    'remaining_bill' => $data['remaining_bill'],
                    'bill_status' => 0,
                    'assign_to' => null,
                    'assign_by' => null,
                    'assign_date' => $data['assign_date'],
                ]);

                $query = $task;
            } else {
                $query = CollectTask::create($data);
            }

            DB::commit();

            return new ApiResource(true, 'Tagihan berhasil diproses!', null);
        } catch (\Exception $e) {
            DB::rollBack();

            return new ApiResource(false, 'Terjadi kesalahan saat memproses tagihan', $e->getMessage());
        }
    }

    public function getSR($no_sr)
    {
        $query = CollectTask::select('*')
            ->where('no_sr', $no_sr)
            ->first();

        if (! $query) {
            return new ApiResource(false, 'Tagihan tidak ditemukan', null);
        }

        return new ApiResource(true, 'Tagihan ditemukan', $query);
    }

    public function validateTask(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'validate_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $query = CollectTask::find($id);

        if (! $query) {
            return new ApiResource(false, 'Tagihan tidak ditemukan', null);
        }

        try {
            $query->update([
                'bill_status' => 2,
                'validate_by' => $request->validate_by,
            ]);

            return new ApiResource(true, 'Tagihan berhasil ditutup', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat memvalidasi tagihan', $e->getMessage());
        }
    }

    public function assignProcess(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'assign_to' => 'required|integer',
            'assign_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $collector = Pegawai::where('kode_pegawai', $request->assign_to)->first();

        if (! $collector) {
            return new ApiResource(false, "Kolektor dengan kode jari $request->assign_to, tidak ditemukan.", null);
        }

        $query = CollectTask::find($id);

        if (! $query) {
            return new ApiResource(false, "Tagihan dengan kode $id tidak ditemukan", null);
        }

        try {
            DB::beginTransaction();

            $query->update([
                'bill_status' => 3,
                'assign_to' => $request->assign_to,
                'assign_by' => $request->assign_by,
            ]);

            $type = $query->sr_type;

            $sr_type = match ($type) {
                'TTT' => 'Tanda Terima Tagihan',
                'TTST' => 'Tanda Terima Sertifikat Tera',
                'AT' => 'Ambil Tagihan',
                'ABL' => 'Antar Bon Lunas',
                default => null,
            };

            Collector::create([
                'bill_type' => 'idcnonppn',
                'no_sr' => $query->no_sr,
                'kode_pegawai' => $request->assign_to,
                'title' => $sr_type,
                'location' => $query->customer_address,
                'assign_date' => $query->assign_date,
            ]);

            $data = Collector::where('kode_pegawai', $request->assign_to)->latest()->first();

            NotifyCollectorNewAssignedJob::dispatch($request->assign_to, $data->id, $query->no_sr)
                ->delay(now()->addSeconds(5));

            DB::commit();

            return new ApiResource(true, 'Tagihan berhasil di assign', null);
        } catch (\Exception $e) {
            DB::rollBack();

            return new ApiResource(false, 'Terjadi kesalahan saat assign tagihan', $e->getMessage());
        }
    }

    public function reschedule(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $request->all();
        $query = CollectTask::find($id);

        if (! $query) {
            return new ApiResource(false, 'Tagihan tidak ditemukan', 'Tagihan yang ingin direschedule tidak ditemukan');
        }

        try {
            $query->update([
                'assign_date' => $data['date'],
            ]);

            return new ApiResource(true, 'Berhasil melakukan reschedule', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat melakukan reschedule', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $query = CollectTask::find($id);

        if (! $query) {
            return new ApiResource(false, 'Tagihan tidak ditemukan', null);
        }

        try {
            $query->delete();

            return new ApiResource(true, 'Tagihan berhasil dihapus', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat menghapus tagihan', $e->getMessage());
        }
    }
}
