<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\PackingList\Box;
use App\Livewire\Forms\Spk\PackingList\Kit;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PackingListKit extends Component
{
    use HandlesErrors;

    public ?string $id_barang;

    public ?string $id_spk;

    public Kit $formKit;

    public Box $formBox;

    public function mount($idbarang, $idspk)
    {
        $this->id_barang = $idbarang;
        $this->id_spk = $idspk;

        $spk = SpkMain::select('customer')->find($this->id_spk);

        $this->formBox->customer_name = $spk->customer['nama_perusahaan'];
    }

    public function addRow(): void
    {
        $kits = $this->formKit->add();

        $this->formBox->kitRow = count($kits);
    }

    public function removeRow(int $index): void
    {
        $kits = $this->formKit->remove($index);

        $this->formBox->kitRow = count($kits);
    }

    public function storeBox()
    {
        // $this->formKit->validate();
        $this->formBox->validateBox();
        $this->formKit->validateKit();

        $this->formBox->boxs[] = [
            'box_name' => $this->formBox->box_name,
            'kits' => $this->formKit->kits,
        ];

        // reset input setelah simpan
        $this->formBox->box_name = null;
        $this->formKit->kits = [];
        $this->formBox->kitRow = 1;
    }

    public function removeBox(int $id): void
    {
        if (isset($this->formBox->boxs[$id])) {
            unset($this->formBox->boxs[$id]);
            $this->formKit->kits = array_values($this->formBox->boxs);
            $this->formBox->kitRow = count($this->formKit->kits) < 1 ? 1 : count($this->formKit->kits);
        }
    }

    public function store()
    {
        $this->formBox->validatePacking();

        $this->runSafely(function () {

            \App\Models\Spk\PackingListKit::create([
                'id_spk' => $this->id_spk,
                'id_barang_produksi' => $this->id_barang,
                'nama_customer' => $this->formBox->customer_name,
                'nama_kit' => $this->formBox->title,
                'jumlah_kit' => $this->formBox->qty_barang,
                'satuan_kit' => $this->formBox->satuan_barang,
                'peti' => $this->formBox->boxs,
            ]);

            $this->resetForm();
            $this->dispatch(event: 'swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menambahkan packing list');
            $this->dispatch('pg:eventRefresh-PackingListKitTable');
        }, 'Gagal menyimpan detail packinglist.', [
            'user_id' => Auth::id(),
            'method' => 'store',
            'model' => '\App\Models\Spk\PackingListKit',
        ]);
    }

    public function resetForm()
    {
        $this->formBox->reset();
        $this->formKit->reset();
    }

    #[On('deletePackingListKit')]
    public function deletePackingListKit($id)
    {
        $this->runSafely(function () use ($id) {
            \App\Models\Spk\PackingListKit::findOrFail($id)->delete();

            $this->dispatch(event: 'swal', icon: 'success', title: 'Berhasil', text: 'Berhasil menghapus packing list kit');
            $this->dispatch('pg:eventRefresh-PackingListKitTable');

        }, 'Gagal menghapus packing list kit.', [
            'user_id' => Auth::id(),
            'method' => 'deletePackingListKit',
            'model' => '\App\Models\Spk\PackingListKit',
            'record_id' => $id,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.production-histories.packing-list-kit');
    }
}
