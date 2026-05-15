<?php

/** Goal: Menangani preview & export data poin teknisi via background job, Caller: detail-transaction.blade.php, Deps: PointTransactions, CreatePointTechnicianTransactionExcelJob */

namespace App\Livewire\Handler\Point\Technician;

use App\Jobs\CreatePointTechnicianTransactionExcelJob;
use App\Models\PointTransactions;
use Illuminate\View\View;
use Livewire\Component;

class ExportPointTransactions extends Component
{
    public string $transactionID;

    public $data = [];

    public bool $showModal = false;

    public function export(): void
    {
        $this->data = PointTransactions::with(['pegawai', 'redeemedby'])
            ->where('transaction_id', $this->transactionID)
            ->get();

        $this->showModal = true;
    }

    public function process(): void
    {
        $this->showModal = false;

        // dispatch job ke queue — user akan mendapat notifikasi + push ketika selesai
        CreatePointTechnicianTransactionExcelJob::dispatch($this->transactionID, auth()->id());

        $this->dispatch('swal', title: 'Diproses', text: 'Export sedang berjalan di background. Anda akan menerima notifikasi ketika selesai.', icon: 'info');
    }

    public function render(): View
    {
        return view('livewire.handler.point.technician.export-point-transactions', [
            'data' => $this->data,
        ]);
    }
}
