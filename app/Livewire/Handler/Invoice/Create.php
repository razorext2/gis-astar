<?php

namespace App\Livewire\Handler\Invoice;

use App\Livewire\Forms\Invoice\Add;
use App\Livewire\Forms\Invoice\Fetch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Create extends Component
{
    public Fetch $fetchDataForm;
    public Add $addForm;

    public function fetchBTT()
    {
        $data = $this->fetchDataForm->fetch();

        if ($data['status'] == 'success') {
            $data = $data['data'][0];

            $this->addForm->btt_number = $data['Nomor'];
            $this->addForm->btt_created_at = Carbon::parse($data['TanggalCreate']['date'])->format('Y-m-d H:i:s');
            $this->addForm->company_name = $data['NamaCustomer'];
            $this->addForm->invoice_date = Carbon::parse($data['Tanggal']['date'])->format('Y-m-d H:i:s');
            $this->addForm->receivable_number = $data['NomorPiutang'];
            $this->addForm->sale_number = $data['NomorPenjualan'];
            $this->addForm->tax_number = $data['NomorFakturPajak'];
        }
    }

    public function store()
    {
        dd($this->addForm->btt_number);
    }

    public function render()
    {
        return view('livewire.handler.invoice.create');
    }
}
