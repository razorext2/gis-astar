<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Delivery;
use App\Models\Spk\SpkDelivery;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryBarangList extends Component
{
    use HandlesErrors, WithPagination;

    public Delivery $form;

    public $modalData = null;

    public ?string $id;

    public ?bool $showDetailModal = false;

    public ?bool $showDelayedModal = false;

    public ?string $delayed_reason = '';

    public ?string $delayed_eta = '';

    public function mount($id)
    {
        $this->id = $id;
    }

    public function detailModal($id)
    {
        $this->showDetailModal = true;

        $this->modalData = SpkDelivery::with('spk.production')
            ->where('id', $id)
            ->first();
    }

    public function delayModal($id)
    {
        $this->showDelayedModal = true;

        $this->modalData = SpkDelivery::with('spk.production')
            ->where('id', $id)
            ->first();

        $this->delayed_eta = $this->modalData->eta;
    }

    public function delayDelivery($id)
    {
        $this->validate([
            'delayed_reason' => 'required|string|min:5|max:255',
            'delayed_eta' => 'required|date',
        ]);

        // cek authorization
        $this->authorize('validatePengiriman', \App\Models\Spk\SpkMain::class);

        $this->runSafely(function () {
            // tambahkan informasi delay
            $history = $this->modalData->history;
            $delayed_history = $this->modalData->is_delay;

            // tambah array history
            $hist = $this->form->generateHistory('Pengiriman Mengalami Penundaan', 'Pengiriman telah ditunda oleh: '.auth()->user()->name.', karena: '.$this->delayed_reason.', tiba sekitar tanggal'.$this->delayed_eta);

            $history[] = $hist;
            $delayed_history[] = $hist;

            // update data
            $this->modalData->update([
                'status_kirim' => 2,
                'eta' => $this->delayed_eta,
                'history' => $history,
                'is_delay' => $delayed_history,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengiriman telah dijadwalkan tertunda.');

            $this->redirect(route('delivery.edit', $this->modalData->spk->id), navigate: true);
        }, 'Gagal menambah informasi delay pengiriman.', [
            'user_id' => auth()->id(),
            'id_delivery' => $id,
            'kode_kirim' => $this->modalData->kode_kirim,
        ]);
    }

    public function deliveryArrivedConfirmation()
    {
        // cek authorization
        $this->authorize('validatePengiriman', \App\Models\Spk\SpkMain::class);

        $this->runSafely(function () {
            $history = $this->modalData->history;

            $history[] = $this->form->generateHistory('Pengiriman Selesai', 'Pengiriman telah dikonfirmasi selesai oleh: '.auth()->user()->name);

            $this->modalData->update([
                'status_kirim' => 1,
                'history' => $history,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengiriman selesai dikonfirmasi.');

            $this->redirect(route('delivery.edit', $this->modalData->spk->id), navigate: true);
        }, 'Gagal mengkonfirmasi pengiriman.', [
            'user_id' => auth()->user()->id,
            'id_delivery' => $this->modalData->id,
        ]);
    }

    public function continueAfterDelayConfirmation()
    {
        // cek authorization
        $this->authorize('validatePengiriman', \App\Models\Spk\SpkMain::class);

        $this->runSafely(function () {
            $history = $this->modalData->history;

            $history[] = $this->form->generateHistory('Pengiriman Dilanjutkan', 'Pengiriman telah dilanjutkan');

            $this->modalData->update([
                'status_kirim' => 0,
                'history' => $history,
            ]);

            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Pengiriman telah dilanjutkan.');

            $this->redirect(route('delivery.edit', $this->modalData->spk->id), navigate: true);
        }, 'Gagal melanjutkan pengiriman.', [
            'user_id' => auth()->user()->id,
            'id_delivery' => $this->modalData->id,
        ]);
    }

    public function render()
    {
        $deliveries = SpkDelivery::with('spk.production')
            ->where('id_spk', $this->id)
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: 10, pageName: 'deliveries');

        return view('livewire.handler.spk.delivery-barang-list', [
            'deliveries' => $deliveries,
        ]);
    }
}
