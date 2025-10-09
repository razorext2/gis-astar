<?php

namespace App\Livewire\Handler\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Livewire\Component;

class Show extends Component
{
    public ?string $no_faktur_pajak = null;
    public ?string $id;
    public ?bool $show_detail = false;

    public function render()
    {

        $invoice = Invoice::where('id', $this->id)
            ->with('details')
            ->first();

        return view('livewire.handler.invoice.show', ['invoice' => $invoice]);
    }
}
