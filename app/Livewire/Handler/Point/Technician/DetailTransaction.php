<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailTransaction extends Component
{
    public $results;
    public $transactionID;
    public $showModal;
    public $from_date;
    public $to_date;

    protected function getTransaction()
    {
        return PointTransactions::where('transaction_id', $this->transactionID);
    }

    public function mount()
    {
        $this->results = $this->getTransaction()->get();

        $data = $this->results->first();

        if (!$data) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $this->from_date = $data->from_date;
        $this->to_date = $data->to_date;
    }

    public function confirm()
    {
        $point = TechnicianPoints::where('created_at', '>=', $this->from_date)
            ->where('created_at', '<=', $this->to_date);

        try {
            DB::beginTransaction();

            $point->update([
                'is_redeemed' => 1,
                'redeemed_status' => 3
            ]);

            $this->getTransaction()->update([
                'status' => 3
            ]);

            DB::commit();
            $this->dispatch('swal', title: 'Berhasil', text: 'Transaksi berhasil dikonfirmasi', icon: 'success');
            $this->closeModal();
            $this->results = $this->getTransaction()->get();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kegagalan, <b>' . $e->getMessage() . '</b>', icon: 'error');
        }
    }

    public function reject()
    {
        $point = TechnicianPoints::where('created_at', '>=', $this->from_date)
            ->where('created_at', '<=', $this->to_date);

        try {
            DB::beginTransaction();

            $point->update([
                'is_redeemed' => 0,
                'redeemed_status' => 0
            ]);

            $this->getTransaction()->update([
                'status' => 4
            ]);

            DB::commit();
            $this->dispatch('swal', title: 'Berhasil', text: 'Transaksi berhasil di batalkan', icon: 'success');
            $this->closeModal();
            $this->results = $this->getTransaction()->get();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', title: 'Gagal', text: 'Terjadi kegagalan, <b>' . $e->getMessage() . '</b>', icon: 'error');
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function export()
    {
        dd('exported');
    }

    public function render()
    {
        return view('livewire.handler.point.technician.detail-transaction');
    }
}
