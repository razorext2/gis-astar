<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Attachment;
use App\Models\Spk\Production;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PackingListFiles extends Component
{
    use HandlesErrors, WithFileUploads;

    public Production $production;

    public Attachment $docForm;

    public ?string $idbarang = null;

    public ?string $idspk = null;

    public function mount($idbarang, $idspk)
    {
        $this->idbarang = $idbarang;

        $this->production = Production::whereHas('spk', function ($spk) use ($idspk) {
            return $spk->where('id', $idspk);
        })->first();

        $this->docForm->new_attachments = $this->getBarangById()['files'] ?? [];
    }

    public function store()
    {
        $this->runSafely(function () {
            // tambah array nya dulu
            $this->docForm->addAttachment();

            // simpan file ke local storage, update array
            $this->docForm->storeAttachment();

            // update files diarray packing_list
            $updatedPackingList = collect($this->production->packing_list)->map(function ($item) {
                if ($item['id_barang'] === $this->idbarang) {
                    $item['files'] = $this->docForm->new_attachments;
                }

                return $item;
            })->toArray();

            // update packinglist di database
            $this->production->update([
                'packing_list' => $updatedPackingList,
            ]);

            // munculkan swal sukses
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'File berhasil dihapus');
        }, 'Gagal menyimpan file baru', [
            'user_id' => auth()->id(),
            'action' => 'add file',
        ]);
    }

    public function removeFile(int $index, string $key)
    {
        if (isset($this->docForm->new_attachments[$index]['url'])) {
            $this->runSafely(function () use ($index) {
                // hapus file dari storage
                Storage::delete($this->docForm->new_attachments[$index]['url']);

                // hapus object dari array
                unset($this->docForm->new_attachments[$index]);

                // refresh value dalam array
                $this->docForm->new_attachments = array_values($this->docForm->new_attachments);

                // update files diarray packing_list
                $updatedPackingList = collect($this->production->packing_list)->map(function ($item) {
                    if ($item['id_barang'] === $this->idbarang) {
                        $item['files'] = $this->docForm->new_attachments;
                    }

                    return $item;
                })->toArray();

                // update packinglist di database
                $this->production->update([
                    'packing_list' => $updatedPackingList,
                ]);

                // munculkan swal sukses
                $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'File berhasil dihapus');
            }, 'Gagal menghapus file dari storage dan database', [
                'user_id' => auth()->id(),
                'form_input' => $this->docForm->new_attachments[$index],
            ]);
        }
    }

    private function getBarangById()
    {
        $packing_list = $this->production->packing_list;

        return collect($packing_list)
            ->where('id_barang', $this->idbarang)
            ->values()
            ->toArray()[0];
    }

    public function render()
    {
        return view('livewire.handler.production-histories.packing-list-files', [
            'data' => $this->getBarangById(),
        ]);
    }
}
