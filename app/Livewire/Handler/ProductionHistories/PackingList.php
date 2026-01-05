<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\PackingList as SpkPackingList;
use App\Models\Spk\Production;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class PackingList extends Component
{
    use HandlesErrors;

    public SpkPackingList $form;

    public Production $production;

    public ?string $id = null;

    public ?string $nama_ekspedisi = null;

    public ?string $nama_barang = null;

    public ?int $qty_barang = null;

    public ?string $satuan_barang = null;

    public ?string $note = null;

    public array $parts = [];

    public array $packs = [];

    public array $kits = [];

    public bool $showDetailModal = false;

    public bool $showAddKitModal = false;

    public bool $accordionOpen = false;

    public $packing_list;

    public function mount($id)
    {
        $this->production = Production::findOrFail($id);
        $this->id = $id;
    }

    public function addPart()
    {
        $this->form->validate();

        $this->parts[] = [
            'nama_part' => $this->form->nama_part,
            'qty' => $this->form->qty,
            'satuan' => $this->form->satuan,
            'pack' => $this->form->pack == 'Pack' ? $this->form->nama_box : $this->form->pack,
        ];

        $this->form->reset();
    }

    public function removePart($id)
    {
        // check ada index nya gak
        if (isset($this->parts[$id])) {
            // kalo ada, hapus dari array
            unset($this->parts[$id]);
        }

        // refresh value dalam array
        $this->parts = array_values($this->parts);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('updatePackingList', Production::class);

        // validasi
        $this->validate(rules: [
            'nama_ekspedisi' => 'required|string|min:3',
            'nama_barang' => 'required|min:5|string',
            'qty_barang' => 'required|numeric|min:1',
            'satuan_barang' => 'required|string',
            'note' => 'required|string|min:10',
            'parts' => 'required|array|min:1',
        ], messages: [
            'nama_ekspedisi.required' => 'Nama ekspedisi wajib diisi.',
            'nama_ekspedisi.string' => 'Nama ekspedisi harus berupa string.',
            'nama_ekspedisi.min' => 'Nama ekspedisi minimal berisi 3 karakter.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.min' => 'Nama barang minimal berisi 5 karakter.',
            'nama_barang.string' => 'Nama barang harus berupa string.',
            'qty_barang.required' => 'Jumlah barang wajib diisi.',
            'qty_barang.numeric' => 'Jumlah barang harus berupa angka.',
            'qty_barang.min' => 'Jumlah barang minimal 1 buah.',
            'satuan_barang.required' => 'Satuan wajib diisi.',
            'satuan_barang.string' => 'Satuan harus berupa string.',
            'note.required' => 'Note wajib diisi.',
            'note.min' => 'Note minimal berisi 10 karakter.',
            'note.string' => 'Note harus berupa string.',
            'parts.required' => 'Daftar part wajib diisi.',
            'parts.array' => 'Daftar part harus berupa array.',
            'parts.min' => 'Daftar part minimal berjumlah 1 buah.',
        ]);

        // proses tambah data ke model produksi dan packinglist
        $this->runSafely(function () {
            // assign data barang baru
            $barang_baru = [
                'id_barang' => Str::uuid(),
                'nama_ekspedisi' => $this->nama_ekspedisi,
                'nama_barang' => $this->nama_barang,
                'qty_barang' => $this->qty_barang,
                'satuan_barang' => $this->satuan_barang,
                'note' => $this->note,
            ];

            DB::transaction(function () use ($barang_baru) {
                // update packinglist dengan data baru
                $this->production->update([
                    'packing_list' => [
                        ...($this->production->packing_list ?? []), $barang_baru, // gabungkan array lama dengan array baru menggunakan fitur array unpacking (spread operator)
                    ],
                ]);

                // tambah data part ke model packing list
                foreach ($this->parts as $part) {
                    \App\Models\Spk\PackingList::create([
                        'id_barang' => $barang_baru['id_barang'],
                        'nama_part' => $part['nama_part'],
                        'jumlah' => $part['qty'],
                        'satuan' => $part['satuan'],
                        'pack' => $part['pack'],
                    ]);
                }
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
            'data' => $this->parts,
            'user_id' => auth()->id(),
        ]);
    }

    public function storeKit()
    {
        dd('oke');
    }

    protected function clear()
    {
        $this->form->reset();
        $this->nama_ekspedisi = null;
        $this->nama_barang = null;
        $this->satuan_barang = null;
        $this->qty_barang = null;
        $this->note = null;
        $this->parts = [];
    }

    #[On('printPackingList')]
    public function detail($id, $nama_ekspedisi, $nama_barang, $jumlah_barang, $satuan_barang, $note)
    {
        $customer = Production::with('spk')
            ->where('id', $this->id)
            ->first()
            ->spk
            ->customer;

        $data = [];

        $data['id'] = $id;
        $data['nama_ekspedisi'] = $nama_ekspedisi;
        $data['nama_customer'] = $customer['nama_perusahaan'];
        $data['contact_person'] = $customer['contact_person'];
        $data['nama_barang'] = $nama_barang;
        $data['jumlah_barang'] = $jumlah_barang.' ['.ucfirst($satuan_barang).']';
        $data['note'] = $note;
        $data['daftar_part'] = \App\Models\Spk\PackingList::where('id_barang', $id)->get()->toArray();

        session(['packing_list_data' => $data]);

        // munculkan modal summary
        $this->showDetailModal = true;

        // munculkan modal pdf
        $this->dispatch('show-detail-modal', url: route('packing-list.pdf'));
    }

    #[On('addKit')]
    public function addKit($id)
    {
        $this->showAddKitModal = true;
    }

    public function render()
    {
        return view('livewire.handler.production-histories.packing-list');
    }
}
