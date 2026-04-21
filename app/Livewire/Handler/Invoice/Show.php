<?php

namespace App\Livewire\Handler\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Livewire\Component;

class Show extends Component
{
    public ?string $no_faktur_pajak = null;
    public ?string $id;
    public ?string $sort = 'desc';
    public ?string $routePrefix = null;

    public function mount($id)
    {
        $this->id = $id;
        
        // Capture the initial route prefix (e.g., 'invoice.all')
        $currentRoute = request()->route()->getName();
        $this->routePrefix = str($currentRoute)->beforeLast('.');
    }

    public function render()
    {
        $invoice = Invoice::where('id', $this->id)
            ->with(['details' => fn($query) => $query->orderBy('created_at', $this->sort)])
            ->first();

        return view('livewire.handler.invoice.show', ['invoice' => $invoice]);
    }
}
