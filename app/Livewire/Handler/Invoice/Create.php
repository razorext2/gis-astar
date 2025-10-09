<?php

namespace App\Livewire\Handler\Invoice;

use App\Livewire\Forms\Invoice\Add;
use App\Livewire\Forms\Invoice\Fetch;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public Fetch $fetchDataForm;
    public Add $addForm;
    public ?string $status = null;
    public ?string $id = null;

    public function mount($id)
    {
        if ($id) {
            $this->id = $id;
        }

        $invoice = Invoice::where('id', $this->id)->first();

        if (!empty($invoice)) {
            $this->fetchDataForm->nofakturpajak = $invoice->no_faktur_pajak;
            $this->addForm->btt_number = $invoice->nomor_btt;
            $this->addForm->btt_created_at = $invoice->tgl_btt;
            $this->addForm->company_name = $invoice->nama_customer;
            $this->addForm->invoice_date = $invoice->tgl_invoice;
            $this->addForm->receivable_number = $invoice->no_piutang;
            $this->addForm->sale_number = $invoice->no_penjualan;
            $this->addForm->tax_number = $invoice->no_faktur_pajak;
            $this->addForm->invoice_type = $invoice->tipe_invoice;
            $this->addForm->delivery_status = $invoice->status_pengiriman;

            $this->status = $invoice->status_terbaru;
        }
    }

    public function fetchFakturPajak()
    {
        // tampilkan loading modal
        $data = $this->fetchDataForm->fetch();

        // check dari database
        $invoice = Invoice::where('no_faktur_pajak', $data['data'][0]['NomorFakturPajak'])->first();

        if ($invoice) {
            $this->status = $invoice->status_terbaru;
            $this->addForm->invoice_type = $invoice->tipe_invoice;
            $this->addForm->delivery_status = $invoice->status_pengiriman;

            $this->dispatch('swal', icon: 'success', text: 'Riwayat invoice sudah ada didatabase, saat ini anda sedang menambah riwayat data.', title: 'Berhasil');
        }

        // cek sudah ada apa belum invoice nya
        if ($data['status'] == 'success') {
            // ambil data dari json api
            $data = $data['data'][0];

            // set data
            $this->addForm->btt_number = $data['Nomor'];
            $this->addForm->btt_created_at = Carbon::parse($data['TanggalCreate']['date'])->format('Y-m-d H:i:s');
            $this->addForm->company_name = $data['NamaCustomer'];
            $this->addForm->invoice_date = Carbon::parse($data['Tanggal']['date'])->format('Y-m-d H:i:s');
            $this->addForm->receivable_number = $data['NomorPiutang'];
            $this->addForm->sale_number = $data['NomorPenjualan'];
            $this->addForm->tax_number = $data['NomorFakturPajak'];
        } else {
            $this->fetchDataForm->reset();
            return $this->dispatch('swal', icon: 'error', text: 'Gagal mengambil data. Invoice tidak ditemukan.', title: 'Gagal');
        }
    }

    public function store()
    {
        $this->addForm->validate();
        $userId = Auth::id();

        // cek sudah ada apa belum invoice nya
        $invoice = Invoice::where('no_faktur_pajak', $this->addForm->tax_number)->first();

        if (!$invoice) {
            $this->addAll($userId);
        } else {
            $this->updateHistory($userId);
        }
    }

    public function addAll($userId)
    {
        try {
            DB::beginTransaction();

            Invoice::create([
                'nomor_btt' => $this->addForm->btt_number,
                'tgl_invoice' => $this->addForm->invoice_date,
                'tgl_btt' => $this->addForm->btt_created_at,
                'no_piutang' => $this->addForm->receivable_number,
                'no_penjualan' => $this->addForm->sale_number,
                'no_faktur_pajak' => $this->addForm->tax_number,
                'nama_customer' => $this->addForm->company_name,
                'tipe_invoice' => $this->addForm->invoice_type,
                'status_pengiriman' => $this->addForm->delivery_status,
                'status_awal' => 'Sudah ready untuk diteruskan ke Piutang.',
                'status_terbaru' => $this->addForm->newest_status,
                'added_by' => $userId,
                'latest_update_by' => $userId,
            ]);

            $this->addHistory($userId);

            DB::commit();

            return $this->dispatch('swal', icon: 'success', text: 'Data berhasil disimpan', title: 'Berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Gagal menyimpan data invoice', [
                'exception' => $th,
                'payload' => [
                    'invoice' => $this->addForm->only([
                        'btt_number',
                        'invoice_date',
                        'btt_created_at',
                        'receivable_number',
                        'sale_number',
                        'tax_number',
                        'company_name',
                        'invoice_type',
                        'newest_status',
                        'invoice_destination',
                        'resi_number',
                    ]),
                ],
            ]);

            return $this->dispatch('swal', icon: 'error', text: 'Gagal menyimpan data: ' . $th, title: 'Gagal');
        }
    }

    public function updateHistory($userId)
    {
        try {
            DB::beginTransaction();

            Invoice::where('no_faktur_pajak', $this->addForm->tax_number)->update([
                'status_pengiriman' => $this->addForm->delivery_status,
                'status_terbaru' => $this->addForm->newest_status,
                'latest_update_by' => $userId,
            ]);

            $this->addHistory($userId);

            DB::commit();

            return $this->dispatch('swal', icon: 'success', text: 'Data berhasil disimpan', title: 'Berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Gagal menyimpan data invoice', [
                'exception' => $th,
                'payload' => [
                    'invoice' => $this->addForm->only([
                        'btt_number',
                        'invoice_date',
                        'btt_created_at',
                        'receivable_number',
                        'sale_number',
                        'tax_number',
                        'company_name',
                        'invoice_type',
                        'newest_status',
                        'invoice_destination',
                        'resi_number',
                    ]),
                ],
            ]);

            return $this->dispatch('swal', icon: 'error', text: 'Gagal menyimpan data: ' . $th, title: 'Gagal');
        }
    }

    public function addHistory($userId)
    {
        $shippingInfo = array_filter([
            'tujuan' => $this->addForm->invoice_destination ?: null,
            'resi' => $this->addForm->resi_number ?: null,
        ], static fn($value) => filled($value));

        $invoiceDetail = InvoiceDetail::create([
            'no_faktur_pajak' => $this->addForm->tax_number,
            'status_btt' => 'ada',
            'status' => $this->addForm->newest_status,
            'informasi_pengiriman' => $shippingInfo,
            'added_by' => $userId,
        ]);

        // upload
        if ($this->addForm->documentations) {
            $documents = [];

            foreach ($this->addForm->documentations as $documentation) {
                $path = $documentation->store('invoice', 'public');

                $documents[] = [
                    'nama_file' => $documentation->getClientOriginalName(),
                    'path_file' => $path,
                ];
            }

            $invoiceDetail->update([
                'documentations' => $documents,
            ]);
        }

        $this->addForm->reset();
        $this->fetchDataForm->reset();
    }

    public function render()
    {
        return view('livewire.handler.invoice.create');
    }
}
