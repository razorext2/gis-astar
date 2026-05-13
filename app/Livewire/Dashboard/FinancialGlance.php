<?php

namespace App\Livewire\Dashboard;

use App\Models\Invoice;
use Livewire\Component;

class FinancialGlance extends Component
{
    public function render()
    {
        $totalInvoiceThisMonth = 0;

        if (auth()->user()->can('invoice-list')) {
            $totalInvoiceThisMonth = Invoice::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
        }

        return view('livewire.dashboard.financial-glance', compact('totalInvoiceThisMonth'));
    }
}
