<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Exports\TechPointTransactionExport;
use App\Models\PointTransactions;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportPointTransactions extends Component
{
    public $transactionID;
    public $data;
    public $showModal = false;

    public function export()
    {
        $this->data = PointTransactions::with('point')
            ->where('transaction_id', $this->transactionID)
            ->get();

        $this->showModal = true;
    }

    public function process()
    {
        $this->showModal = false;
        $this->dispatch('swal', title: 'Berhasil', text: 'Data sedang diekspor', icon: 'success');

        return Excel::download(new TechPointTransactionExport($this->transactionID), 'tech_point_transaction.xlsx');
    }

    public function render()
    {
        return view('livewire.handler.point.technician.export-point-transactions', [
            'data' => $this->data,
        ]);
    }
}
