<?php

namespace App\Livewire\Handler\Invoice;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Invoice\Add;
use App\Livewire\Forms\Invoice\Fetch;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

    public Fetch $fetchDataForm;

    public Add $addForm;

    public ?string $status = null;

    public ?string $id = null;

    public ?string $currentRoute = null;

    public function mount($id, $tipe_tagihan)
    {
        $this->currentRoute = request()->route()->getName();

        $route = $this->currentRoute;

        if ($route == 'invoice.cust.create' || $route == 'invoice.pku.create' || $route == 'invoice.jkt.create') {
            $this->addForm->invoice_type = 'lukot';
        } elseif ($route == 'invoice.medan.create') {
            $this->addForm->invoice_type = 'dalkot';
        } else {
            $this->addForm->invoice_type = '';
        }

        if ($id) {
            $this->id = $id;
        }

        if ($tipe_tagihan) {
            $this->fetchDataForm->tipe_tagihan = $tipe_tagihan;
        }

        $invoice = Invoice::with('details')->where('id', $this->id)->first();

        if (! empty($invoice)) {
            $this->fetchDataForm->nofakturpajak = $invoice->no_faktur_pajak;
            $this->fetchDataForm->tipe_tagihan = $invoice->tipe_tagihan;
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

            $latestDetail = $invoice->details()->latest('created_at')->first();

            $this->addForm->invoice_destination = '';
            $this->addForm->resi_number = '';

            if ($latestDetail && is_array($latestDetail->informasi_pengiriman)) {
                $this->addForm->invoice_destination = $latestDetail->informasi_pengiriman['tujuan'] ?? '';
                $this->addForm->resi_number = $latestDetail->informasi_pengiriman['resi'] ?? '';
            }
        }
    }

    public function fetchFakturPajak()
    {
        // validasi
        $this->fetchDataForm->validate();

        // tampilkan loading modal
        $api = null;

        if ($this->fetchDataForm->tipe_tagihan == 'idcppn') {
            $api = $this->fetchDataForm->fetchIdc();
        } elseif ($this->fetchDataForm->tipe_tagihan == 'idyppn') {
            $api = $this->fetchDataForm->fetchIdy();
        } else {
            $api = null;
        }

        if ($api['status'] == 'error') {
            return $this->dispatch('swal', icon: 'error', text: $api['message'], title: 'Error');
        }

        // check dari database
        $invoice = Invoice::with('details')->where('no_faktur_pajak', $api['data'][0]['NomorFakturPajak'])->first();

        if ($invoice) {
            $this->status = $invoice->status_terbaru;
            $this->addForm->invoice_type = $invoice->tipe_invoice;
            $this->addForm->delivery_status = $invoice->status_pengiriman;
            $latestDetail = $invoice->details()->latest('created_at')->first();

            $this->addForm->invoice_destination = '';
            $this->addForm->resi_number = '';

            if ($latestDetail && is_array($latestDetail->informasi_pengiriman)) {
                $this->addForm->invoice_destination = $latestDetail->informasi_pengiriman['tujuan'] ?? '';
                $this->addForm->resi_number = $latestDetail->informasi_pengiriman['resi'] ?? '';
            }

            $this->dispatch('swal', icon: 'success', text: 'Riwayat invoice sudah ada didatabase, saat ini anda sedang menambah riwayat data.', title: 'Berhasil');
        }

        // ambil data dari json api
        $data = $api['data'][0];

        // set data
        $this->addForm->btt_number = $data['Nomor'];
        $this->addForm->btt_created_at = Carbon::parse($data['TanggalCreate']['date'])->format('Y-m-d H:i:s');
        $this->addForm->company_name = $data['NamaCustomer'];
        $this->addForm->invoice_date = Carbon::parse($data['Tanggal']['date'])->format('Y-m-d H:i:s');
        $this->addForm->receivable_number = $data['NomorPiutang'];
        $this->addForm->sale_number = $data['NomorPenjualan'];
        $this->addForm->tax_number = $data['NomorFakturPajak'];

    }

    public function store()
    {
        $this->addForm->validate();
        $userId = Auth::id();

        // cek sudah ada apa belum invoice nya
        $invoice = Invoice::where('no_faktur_pajak', $this->addForm->tax_number)->first();

        if (! $invoice) {
            $this->addAll($userId);
        } else {
            $this->updateHistory($userId);
        }
    }

    public function addAll($userId)
    {
        $this->runSafely(function () use ($userId) {
            DB::transaction(function () use ($userId) {
                $invoice = Invoice::create([
                    'nomor_btt' => $this->addForm->btt_number,
                    'tgl_invoice' => $this->addForm->invoice_date,
                    'tgl_btt' => $this->addForm->btt_created_at,
                    'no_piutang' => $this->addForm->receivable_number,
                    'no_penjualan' => $this->addForm->sale_number,
                    'no_faktur_pajak' => $this->addForm->tax_number,
                    'nama_customer' => $this->addForm->company_name,
                    'tipe_invoice' => $this->addForm->invoice_type,
                    'tipe_tagihan' => $this->fetchDataForm->tipe_tagihan,
                    'status_pengiriman' => $this->addForm->delivery_status,
                    'status_awal' => 'Sudah ready untuk diteruskan ke Piutang.',
                    'status_terbaru' => $this->addForm->newest_status,
                    'added_by' => $userId,
                    'latest_update_by' => $userId,
                ]);

                $this->id = $invoice->id;

                $this->addHistory($userId);
            });

            $this->dispatch('swal', icon: 'success', text: 'Data berhasil disimpan', title: 'Berhasil');
        }, 'Gagal menyimpan data invoice', [
            'action' => 'create invoice',
            'user_id' => $userId,
        ]);
    }

    public function updateHistory($userId)
    {
        $this->runSafely(function () use ($userId) {
            DB::transaction(function () use ($userId) {
                $invoice = Invoice::where('no_faktur_pajak', $this->addForm->tax_number)->first();
                $invoice->update([
                    'status_pengiriman' => $this->addForm->delivery_status,
                    'status_terbaru' => $this->addForm->newest_status,
                    'tipe_tagihan' => $this->fetchDataForm->tipe_tagihan,
                    'latest_update_by' => $userId,
                ]);

                $this->id = $invoice->id;

                $this->addHistory($userId);
            });

            $this->dispatch('swal', icon: 'success', text: 'Data berhasil disimpan', title: 'Berhasil');
        }, 'Gagal menyimpan data history invoice', [
            'action' => 'update invoice history',
            'user_id' => $userId,
        ]);
    }

    public function addHistory($userId)
    {
        $shippingInfo = [];

        if ($this->addForm->delivery_status == 1) {
            $shippingInfo = array_filter([
                'tujuan' => $this->addForm->invoice_destination ?: null,
                'resi' => $this->addForm->resi_number ?: null,
            ], static fn ($value) => filled($value));
        }

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

        $this->redirect(route($this->getRoute($this->currentRoute), ['id' => $this->id]).'?tipe_tagihan='.$this->fetchDataForm->tipe_tagihan, navigate: true);
    }

    public function removeDocumentation($index)
    {
        if (isset($this->addForm->documentations[$index])) {
            unset($this->addForm->documentations[$index]);
            $this->addForm->documentations = array_values($this->addForm->documentations);
        }
    }

    public function getRoute($currentRoute)
    {
        return match ($currentRoute) {
            'invoice.all.create' => 'invoice.all.create',
            'invoice.medan.create' => 'invoice.medan.create',
            'invoice.jkt.create' => 'invoice.jkt.create',
            'invoice.pku.create' => 'invoice.pku.create',
            'invoice.cust.create' => 'invoice.cust.create',
            'invoice.all.addDetails' => 'invoice.all.index',
            'invoice.medan.addDetails' => 'invoice.medan.index',
            'invoice.jkt.addDetails' => 'invoice.jkt.index',
            'invoice.pku.addDetails' => 'invoice.pku.index',
            'invoice.cust.addDetails' => 'invoice.cust.index',
            default => $currentRoute,
        };
    }

    public function render()
    {
        return view('livewire.handler.invoice.create');
    }
}
