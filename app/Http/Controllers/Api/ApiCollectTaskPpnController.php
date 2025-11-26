<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Jobs\NotifyCollectorNewAssignedJob;
use App\Models\Collector;
use App\Models\CollectTaskPpn;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCollectTaskPpnController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_sr' => 'required|string|min:3|max:20',
            'sales_invoice' => 'required|string|min:3',
            'tax_invoice' => 'required|string|min:3',
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

        $task = CollectTaskPpn::withTrashed()->where('no_sr', '=', $data['no_sr'])->first();

        $status_terbaru = 'Menunggu Piutang untuk Assign ke Kolektor [tipe: '.$data['sr_type'].'].';

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
            } else {
                CollectTaskPpn::create($data);
            }

            // update detail dan status invoice
            $this->updateInvoiceStatus(
                $data['tax_invoice'],
                $status_terbaru,
                0
            );

            DB::commit();

            return new ApiResource(true, 'Tagihan berhasil diproses!', null);
        } catch (\Exception $e) {
            DB::rollBack();

            return new ApiResource(false, 'Terjadi kesalahan saat memproses tagihan', $e->getMessage());
        }
    }

    public function getSR($no_sr)
    {
        $query = CollectTaskPpn::select('*')
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

        $query = CollectTaskPpn::find($id);

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
        // validasi input
        $validator = Validator::make($request->all(), [
            'assign_to' => 'required|integer',
            'assign_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        // cari data kolektor
        $collector = Pegawai::where('kode_pegawai', $request->assign_to)->first();

        if (! $collector) {
            // kalo ga ada return pesan ini
            return new ApiResource(false, "Kolektor dengan kode jari $request->assign_to, tidak ditemukan.", null);
        }

        // kalo ada, lanjut cari data tagihan
        $query = CollectTaskPpn::find($id);

        if (! $query) {
            // kalo ga ada return pesan ini
            return new ApiResource(false, "Tagihan dengan kode $id tidak ditemukan", null);
        }

        $sr_type = $this->getSrType($query->sr_type);

        $status_terbaru = 'Sedang dibawa Kolektor ['.$collector->full_name.'] ke alamat penagihan ['.$query->customer_address.'] dengan tipe '.$sr_type.'.';

        try {
            DB::beginTransaction();

            // update status tagihan
            $query->update([
                'bill_status' => 3, // status tagihan tertunda (3)
                'assign_to' => $request->assign_to,
                'assign_by' => $request->assign_by,
            ]);

            // buat data laporan kolektor untuk diupdate oleh kolektor
            $collector = Collector::create([
                'bill_type' => 'idcppn',
                'no_sr' => $query->tax_invoice,
                'kode_pegawai' => $request->assign_to,
                'title' => $sr_type,
                'location' => $query->customer_address,
                'assign_date' => $query->assign_date,
            ]);

            // update detail dan status invoice
            $this->updateInvoiceStatus(
                $query->tax_invoice,
                $status_terbaru,
                1
            );

            // berikan notifikasi
            NotifyCollectorNewAssignedJob::dispatch($request->assign_to, $collector->id, $query->no_sr)
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
        // validasi input
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        // return error jika validasi gagal
        if ($validator->fails()) {
            return new ApiResource(false, 'Validasi gagal', $validator->errors());
        }

        // cari data berdasarkan id
        $query = CollectTaskPpn::find($id);

        // kalo ga ada, return error
        if (! $query) {
            return new ApiResource(false, 'Tagihan tidak ditemukan', 'Tagihan yang ingin direschedule tidak ditemukan');
        }

        // kalo ada
        try {
            // update tanggal
            $query->update([
                'assign_date' => $request['date'],
            ]);

            // update invoice detail dan statusnya
            $this->updateInvoiceStatus(
                $query->tax_invoice,
                'Tagihan ['.$query->tax_invoice.'] telah direschedule ke tanggal '.$request['date'].'.',
                0
            );

            return new ApiResource(true, 'Berhasil melakukan reschedule', null);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Terjadi kesalahan saat melakukan reschedule', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $query = CollectTaskPpn::find($id);

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

    protected function updateInvoiceStatus($no_faktur_pajak, $status_terbaru, $status_pengiriman)
    {
        $invoice = Invoice::where('no_faktur_pajak', $no_faktur_pajak)->update([
            'status_pengiriman' => $status_pengiriman,
            'status_terbaru' => $status_terbaru,
        ]);

        if ($invoice === 0) {
            // jika tidak ada yg diupdate, return false
            return false;
        }

        InvoiceDetail::create([
            'no_faktur_pajak' => $no_faktur_pajak,
            'status_btt' => 'ada',
            'status' => $status_terbaru,
            'informasi_pengiriman' => [],
            'added_by' => Auth::id(),
        ]);

        return true;
    }

    protected function getSrType($sr_type)
    {
        return match ($sr_type) {
            'TTT' => 'Tanda Terima Tagihan',
            'TTST' => 'Tanda Terima Sertifikat Tera',
            'AT' => 'Ambil Tagihan',
            'ABL' => 'Antar Bon Lunas',
            default => null,
        };
    }
}
