<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Forms\Spk\Delivery;
use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class DeliveryUpdate extends Component
{
    use WithPagination;

    public ?string $id;

    public $spk_data = null;

    public Delivery $form;

    public function mount($id)
    {
        $this->id = $id;
        $this->spk_data = SpkMain::where('id', $this->id)->first();
    }

    public function store()
    {
        $old_data = $this->spk_data->informasi_pengiriman;

        $data = [
            'products' => $this->form->barangs,
            'via' => $this->form->via,
            'partay' => $this->form->partay,
            'no_container' => $this->form->no_container,
            'nama_kapal' => $this->form->nama_kapal,
            'no_plat' => $this->form->no_plat,
            'nama_supir' => $this->form->nama_supir,
            'no_telp_supir' => $this->form->no_telp_supir,
            'berat' => $this->form->berat,
            'etd' => $this->form->etd,
            'eta' => $this->form->eta,
            'note' => $this->form->note,
        ];

        $new_data = array_merge($old_data, $data);

        $this->spk_data->update([
            'informasi_pengiriman' => $new_data,
        ]);
    }

    public function getInformasiPengirimanPaginatedProperty()
    {
        $items = collect($this->spk_data->informasi_pengiriman);

        $perPage = 6;
        $page = Paginator::resolveCurrentPage();

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
            ]
        );
    }

    public function render()
    {
        $data = Production::where('id_spk', $this->id)->first();

        $id_produksi = $data->id;

        return view('livewire.handler.spk.delivery-update',
            [
                'data' => $data,
                'id_produksi' => $id_produksi,
                'deliveries' => $this->informasiPengirimanPaginated,
            ]);
    }
}
