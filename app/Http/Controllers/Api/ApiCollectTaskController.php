<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifyCollectorNewAssignedJob;
use App\Models\CollectTask;
use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            Log::error('Validation failed: ' . $validator->errors()->first());
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $data = $validator->validated();

        try {
            DB::beginTransaction();

            $task = CollectTask::withTrashed()->where('no_sr', '=', $data['no_sr'])->first();

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
                    'assign_date' => $data['assign_date']
                ]);

                $query = $task;
            } else {
                $query = CollectTask::create($data);
            }

            DB::commit();
            return new ApiResource(true, 'Tagihan berhasil diproses!', $query);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing bill: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat memproses tagihan', $e->getMessage());
        }
    }

    public function getSR($no_sr)
    {
        $query = CollectTask::select('*')
            ->where('no_sr', $no_sr)
            ->first();

        if (!$query) {
            Log::warning('Tagihan tidak ditemukan untuk no_sr: ' . $no_sr);
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
            Log::error('Validation failed: ' . $validator->errors()->first());
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $query = CollectTask::find($id);

            if (!$query) {
                Log::error('Bill not found for id: ' . $id);
                return new ApiResource(false, 'Tagihan tidak ditemukan', null);
            }

            $query->update([
                'bill_status' => 2,
                'validate_by' => $request->validate_by,
            ]);

            DB::commit();
            return new ApiResource(true, 'Tagihan berhasil ditutup', null);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error validating bill: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat memvalidasi tagihan', $e->getMessage());
        }
    }

    public function assignProcess(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'assign_to' => 'required|integer',
            'assign_by' => 'required|integer'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . $validator->errors()->first());
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $query = CollectTask::find($id);

            if (!$query) {
                Log::error('Bill not found for id: ' . $id);
                return new ApiResource(false, 'Tagihan tidak ditemukan', null);
            }

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
            Log::error('Error assigning bill: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat assign tagihan', $e->getMessage());
        }
    }

    public function massAssignProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_pegawai' => 'required|integer',
            'sr_data' => 'required|array',
            'sr_data.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        try {
            DB::beginTransaction();

            CollectTask::whereIn('no_sr', $request->sr_data)->update([
                'bill_status' => 3,
                'assign_to' => $request->kode_pegawai,
                'assign_by' => $request->assign_by,
            ]);

            $query = CollectTask::whereIn('no_sr', $request->sr_data)->get();

            foreach ($query as $data) {
                $collector = Collector::create([
                    'no_sr' => $data->no_sr,
                    'kode_pegawai' => $request->kode_pegawai,
                    'title' => $data->customer_name,
                    'location' => $data->customer_address,
                    'assign_date' => $data->assign_date,
                ]);

                if (!$collector) {
                    Log::error('Error creating collector for no_sr: ' . $data->no_sr);
                    return new ApiResource(false, 'Terjadi kesalahan saat assign tagihan', null);
                }

                $data = Collector::where('kode_pegawai', $request->kode_pegawai)->latest()->first();

                NotifyCollectorNewAssignedJob::dispatch($request->kode_pegawai, $data->id, $data->no_sr)
                    ->delay(now()->addSeconds(5));
            }

            DB::commit();
            return new ApiResource(true, 'Berhasil menambah assigment', null);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error mass assigning bills: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat assign tagihan', $e->getMessage());
        }
    }

    public function reschedule(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()));
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            $query = CollectTask::find($id);

            if (!$query) {
                Log::error('Bill not found for id: ' . $id);
                return new ApiResource(false, 'Tagihan tidak ditemukan', 'Tagihan yang ingin direschedule tidak ditemukan');
            }

            $query->update([
                'assign_date' => $data['date']
            ]);

            DB::commit();
            return new ApiResource(true, 'Berhasil melakukan reschedule', null);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rescheduling bill: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat melakukan reschedule', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $query = CollectTask::find($id);
        if (!$query) {
            Log::error('Bill not found for id: ' . $id);
            return new ApiResource(false, 'Tagihan tidak ditemukan', null);
        }
        try {
            DB::beginTransaction();

            $query->delete();

            DB::commit();
            return new ApiResource(true, 'Tagihan berhasil dihapus', null);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting bill: ' . $e->getMessage());
            return new ApiResource(false, 'Terjadi kesalahan saat menghapus tagihan', $e->getMessage());
        }
    }
}
