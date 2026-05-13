<?php

/** Goal: Menangani preview & export data poin teknisi, Caller: detail-transaction.blade.php, Deps: PointTransactions, TechPointTransactionExport */

namespace App\Livewire\Handler\Point\Technician;

use App\Exports\TechPointTransactionExport;
use App\Models\PointTransactions;
use Illuminate\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportPointTransactions extends Component
{
    public string $transactionID;

    public $data = [];

    public bool $showModal = false;

    public function export(): void
    {
        // Menyelesaikan masalah N+1 Query dengan eager-loading relasi pegawai dan redeemedby
        $this->data = PointTransactions::with(['point', 'pegawai', 'redeemedby'])
            ->where('transaction_id', $this->transactionID)
            ->get();

        $this->showModal = true;
    }

    public function process(): BinaryFileResponse
    {
        $this->showModal = false;
        $this->dispatch('swal', title: 'Berhasil', text: 'Data sedang diekspor', icon: 'success');

        return Excel::download(new TechPointTransactionExport($this->transactionID), 'tech_point_transaction.xlsx');
    }

    public function render(): View
    {
        return view('livewire.handler.point.technician.export-point-transactions', [
            'data' => $this->data,
        ]);
    }
}
