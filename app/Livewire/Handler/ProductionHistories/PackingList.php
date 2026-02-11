<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Attachment;
use App\Livewire\Forms\Spk\PackingListItem;
use App\Livewire\Forms\Spk\PackingListPart;
use App\Models\Spk\Production;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PackingList extends Component
{
    use HandlesErrors, WithFileUploads;

    public PackingListPart $partForm;

    public PackingListItem $itemForm;

    public Attachment $docForm;

    public Production $production;

    public ?string $id = null;

    public bool $showDetailModal = false;

    public bool $accordionOpen = false;

    public function mount($id)
    {
        $this->id = $id;
        $this->production = Production::findOrFail($this->id);
    }

    public function addPart()
    {
        $this->partForm->validate();

        $this->itemForm->parts[] = [
            'nama_part' => $this->partForm->nama_part,
            'qty' => $this->partForm->qty,
            'satuan' => $this->partForm->satuan,
            'pack' => $this->partForm->pack == 'Pack' ? $this->partForm->nama_box : $this->partForm->pack,
        ];

        $this->partForm->reset();
    }

    public function removePart($id)
    {
        // check ada index nya gak
        if (isset($this->itemForm->parts[$id])) {
            // kalo ada, hapus dari array
            unset($this->itemForm->parts[$id]);
        }

        // refresh value dalam array
        $this->itemForm->parts = array_values($this->itemForm->parts);
    }

    public function storeLampiran()
    {
        $this->docForm->validate();

        $this->docForm->addAttachment();
    }

    public function removeAttachment($index)
    {
        $this->docForm->removeAttachment($index);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('updatePackingList', Production::class);

        // validasi
        $this->itemForm->validate();

        // proses tambah data ke model produksi dan packinglist
        $this->runSafely(function () {
            // generate values
            $lampiran = $this->docForm->storeAttachment();
            $barang_baru = $this->itemForm->generateBarangBaru($lampiran);

            // assign data barang baru
            DB::transaction(function () use ($barang_baru) {
                // update packinglist dengan data baru
                $this->production->update([
                    'packing_list' => [
                        ...($this->production->packing_list ?? []), $barang_baru, // gabungkan array lama dengan array baru menggunakan fitur array unpacking (spread operator)
                    ],
                ]);

                if ($this->itemForm->cara_input === 'manual') {
                    // tambah data part ke model packing list
                    foreach ($this->itemForm->parts as $part) {
                        \App\Models\Spk\PackingList::create([
                            'id_barang' => $barang_baru['id_barang'],
                            'nama_part' => $part['nama_part'],
                            'jumlah' => $part['qty'],
                            'satuan' => $part['satuan'],
                            'pack' => $part['pack'],
                        ]);
                    }
                }

                // ubah status spk
                $this->production->spk->update([
                    'status' => 3., // sedang diproses purchasing untuk pengiriman
                ]);
            });

            // tampilkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: 'Packing list berhasil ditambahkan.',
            );

            // reset form
            $this->clear();

            // refresh table
            $this->dispatch('pg:eventRefresh-PackingListTable');
        }, 'Gagal menambah packing list.', [
            'data' => $this->itemForm->parts,
            'user_id' => auth()->id(),
        ]);
    }

    protected function clear()
    {
        $this->partForm->reset();
        $this->itemForm->clearForm();
        $this->docForm->reset();
    }

    #[On('printPackingList')]
    public function detail($id, $nama_ekspedisi, $nama_barang, $jumlah_barang, $satuan_barang, $note)
    {
        $produksi = Production::with('spk')
            ->where('id', $this->id)
            ->first();

        $item = collect($produksi->packing_list)
            ->firstWhere('id_barang', $id);

        $data = [];

        $data['id'] = $id;
        $data['nama_ekspedisi'] = $nama_ekspedisi;
        $data['nama_customer'] = $produksi->spk->customer['nama_perusahaan'];
        $data['contact_person'] = $produksi->spk->customer['contact_person'];
        $data['nama_barang'] = $nama_barang;
        $data['jumlah_barang'] = $jumlah_barang.' ['.ucfirst($satuan_barang).']';
        $data['note'] = $note;
        $data['daftar_part'] = \App\Models\Spk\PackingList::where('id_barang', $id)->get()->toArray();
        $data['daftar_box'] = \App\Models\Spk\PackingListKit::where('id_barang_produksi', $id)->get()->toArray();
        $data['created_at'] = Carbon::parse($item['created_at'])->locale('id')->isoFormat('D MMMM Y');

        session(['packing_list_data' => $data]);

        // munculkan modal summary
        $this->showDetailModal = true;

        // munculkan modal pdf
        $this->dispatch('show-detail-modal', url: route('packing-list.pdf'));
    }

    #[On('deletePackingList')]
    public function deletePackingList($id)
    {
        // ambil data terlebih dahulu
        $data = collect($this->production->packing_list)->firstWhere('id_barang', $id);

        $this->runSafely(function () use ($id, $data) {
            // cek apakah ada file
            if ($data['packing_list_type'] === 'upload') {
                $files = $data['files'];

                if (isset($files)) {
                    foreach ($files as $file) {
                        Storage::delete($file['url']);
                    }
                }
            }

            // unset/hapus data dari array
            $new_data = collect($this->production->packing_list)
                ->reject(fn ($item) => $item['id_barang'] === $id)
                ->values()
                ->toArray();

            // update di database
            $this->production->update([
                'packing_list' => $new_data,
            ]);

            // swal message
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Packing list berhasil dihapus.');

            // refresh data table
            $this->dispatch('pg:eventRefresh-PackingListTable');
        }, 'Gagal menghapus packing list.', [
            'user_id' => auth()->id(),
            'id_spk' => $this->production->spk->id,
            'id_barang' => $id,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.production-histories.packing-list');
    }
}
