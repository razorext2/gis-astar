<?php

namespace App\Livewire\Handler\Spk;

use App\Models\Spk\SpkDelivery;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryBarangList extends Component
{
    use WithPagination;

    public ?string $id;

    public function mount($id)
    {
        $this->id = $id;
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
