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

    public function mount($id)
    {
        $this->id = $id;
    }

    public function generateViaColor($via)
    {
        return match ($via) {
            'laut' => [
                'color' => 'text-blue-700 bg-blue-400',
                'label' => 'Laut',
            ],
            'darat' => [
                'color' => 'text-green-700 bg-green-400',
                'label' => 'Darat',
            ],
            'supir' => [
                'color' => 'text-gray-700 bg-gray-400',
                'label' => 'Supir Internal',
            ],
            'bycust' => [
                'color' => 'text-yellow-700 bg-yellow-400',
                'label' => 'Dijemput Customer',
            ],
            default => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Tidak diketahui',
            ],
        };
    }

    public function generateStatusColor($status_kirim)
    {
        return match ($status_kirim) {
            0 => [
                'color' => 'text-blue-700 bg-blue-400',
                'label' => 'Dalam Pengiriman',
            ],
            1 => [
                'color' => 'text-green-700 bg-green-400',
                'label' => 'Pengiriman Selesai',
            ],
            2 => [
                'color' => 'text-yellow-700 bg-yellow-400',
                'label' => 'Pengiriman Mengalami Delay',
            ],
            3 => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Pengiriman Dibatalkan',
            ],
            4 => [
                'color' => 'text-gray-700 bg-gray-400',
                'label' => 'Pengiriman Direschedule',
            ],
            default => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Tidak diketahui',
            ],
        };
    }

    public function detailModal($id)
    {
        $this->showDetailModal = true;

        $this->modalData = SpkDelivery::with('spk.production')
            ->where('id', $id)
            ->first();
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

    public function render()
    {
        $deliveries = SpkDelivery::with('spk.production')
            ->where('id_spk', $this->id)
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: 4, pageName: 'deliveries');

        return view('livewire.handler.spk.delivery-barang-list', [
            'deliveries' => $deliveries,
        ]);
    }
}
