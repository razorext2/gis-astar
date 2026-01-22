<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Create as SpkCreate;
use App\Models\Spk\SpkHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public SpkCreate $createForm;

    public $id;

    public $data;

    public ?string $nama_barang;

    public ?string $satuan_barang;

    public ?string $spesifikasi = null;

    public ?string $delay_note;

    public ?string $index_barang = null;

    public ?int $assign_to;

    public ?int $jumlah_unit;

    public bool $is_delayed;

    public bool $is_edit = false;

    public function mount($id)
    {
        // assign id
        $this->id = $id;

        // ambil data spk berdasarkan id
        $this->data = \App\Models\Spk\SpkMain::with('production')
            ->findOrFail($id);

        // assign data spk ke variabel
        $data = $this->data;

        // assign data spk ke form
        $this->createForm->nama_customer = $data->customer['nama_perusahaan'];
        $this->createForm->no_telp = $data->customer['no_hp'];
        $this->createForm->contact_person = $data->customer['contact_person'];
        $this->createForm->alamat_customer = $data->customer['alamat'];

        // assign data spk barang ke form
        // foreach ($data->products as $row) {
        //     $this->createForm->barang[] = $row;
        // }

        // assign _key ke setiap item barang
        $this->createForm->barang = collect($data->products)
            ->map(fn ($item) => array_merge($item, [
                '_key' => (string) Str::uuid(),
            ]))->toArray();

        // assign data spk tagihan ke form
        $this->createForm->status_nomor_tagihan = $data->status_nomor_tagihan;
        $this->createForm->nomor_tagihan = $data->nomor_tagihan;
        $this->createForm->tipe_tagihan = $data->tipe_tagihan;
        $this->createForm->nomor_order = $data->nomor_order;
        $this->createForm->tipe_bayar = $data->tipe_bayar;
        $this->createForm->tgl_cetak = $data->tgl_cetak;
        $this->createForm->tgl_kirim = $data->tgl_kirim;
        $this->createForm->assign_to = $data->assign_to;
        $this->assign_to = $data->assign_to;
        $this->createForm->keterangan = $data->keterangan;
        $this->createForm->tipe_timbangan = $data->tipe_timbangan;

        $this->is_delayed = $data->on_delay;
        $this->delay_note = $data->on_delay_notes;
    }

    public function storeBarang()
    {
        // validasi field nama_barang
        $this->validate([
            'nama_barang' => 'required|min:5|string',
            'jumlah_unit' => 'required|numeric|min:1',
            'satuan_barang' => 'required|string',
            'spesifikasi' => 'nullable|string',
        ], [
            'nama_barang.required' => 'Kolom nama barang wajib diisi.',
            'nama_barang.min' => 'Kolom nama barang minimal berisi 5 karakter.',
            'nama_barang.string' => 'Kolom nama barang harus berupa string.',
            'jumlah_unit.required' => 'Kolom jumlah unit wajib diisi.',
            'jumlah_unit.numeric' => 'Kolom jumlah unit harus berupa angka.',
            'jumlah_unit.min' => 'Kolom jumlah unit minimal berjumlah 1 buah.',
            'satuan_barang.required' => 'Kolom satuan wajib diisi.',
            'satuan_barang.string' => 'Kolom satuan harus berupa string',
            'spesifikasi.string' => 'Kolom spesifikasi harus berupa string.',
        ]);

        // data barang dengan _key
        $payload = [
            '_key' => (string) Str::uuid(),
            'nama_barang' => $this->nama_barang,
            'jumlah_unit' => $this->jumlah_unit,
            'satuan_barang' => $this->satuan_barang,
            'spesifikasi' => $this->spesifikasi,
        ];

        if ($this->is_edit && $this->index_barang !== null) {

            // pertahankan _key lama saat edit
            $payload['_key'] = $this->createForm->barang[$this->index_barang]['_key'];

            $this->createForm->barang[$this->index_barang] = $payload;

            $this->resetBarang();

            return;
        }

        $this->createForm->barang[] = $payload;

        $this->resetBarang();
    }

    public function editBarang($index)
    {
        // set is_edit true
        $this->is_edit = true;

        // set index_barang
        $this->index_barang = $index;

        // set form fields sesuai index
        $this->nama_barang = $this->createForm->barang[$index]['nama_barang'];
        $this->jumlah_unit = $this->createForm->barang[$index]['jumlah_unit'];
        $this->satuan_barang = $this->createForm->barang[$index]['satuan_barang'];
        $this->spesifikasi = $this->createForm->barang[$index]['spesifikasi'];
    }

    public function hapusBarang($index)
    {
        // hapus barang dari array
        unset($this->createForm->barang[$index]);

        // refresh value didalam array
        $this->createForm->barang = array_values($this->createForm->barang);
    }

    public function resetBarang()
    {
        if ($this->is_edit) {
            $this->is_edit = false;
            $this->index_barang = null;
        }

        $this->nama_barang = null;
        $this->jumlah_unit = null;
        $this->satuan_barang = null;
        $this->spesifikasi = null;
    }

    public function upBarang(int $index)
    {
        $this->moveItem($index, $index - 1);
    }

    public function downBarang(int $index)
    {
        $this->moveItem($index, $index + 1);
    }

    protected function moveItem(int $from, int $to)
    {
        if (! isset($this->createForm->barang[$from]) || $to < 0 || $to >= count($this->createForm->barang)) {
            return;
        }

        $item = $this->createForm->barang[$from];

        unset($this->createForm->barang[$from]);

        $this->createForm->barang = array_values($this->createForm->barang);

        array_splice($this->createForm->barang, $to, 0, [$item]);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('update', $this->data);

        // inisialisasi variabel
        $customer = [];
        $barangs = [];

        // inisialisasi field yang akan divalidasi
        $fieldsToValidate = [
            'nama_customer',
            'alamat_customer',
            'contact_person',
            'no_telp',
            'tipe_timbangan',
            'barang.*',
            'tipe_tagihan',
            'status_nomor_tagihan',
            'nomor_tagihan',
            'tipe_bayar',
            'tgl_cetak',
            'tgl_kirim',
            'keterangan',
            'assign_to',
        ];

        // validasi form
        foreach ($fieldsToValidate as $field) {
            $this->createForm->validateOnly($field);
        }

        // assign data customer ke array
        $customer = [
            'nama_perusahaan' => $this->createForm->nama_customer,
            'alamat' => $this->createForm->alamat_customer,
            'contact_person' => $this->createForm->contact_person,
            'no_hp' => $this->createForm->no_telp,
        ];

        // assign data barang ke array
        $barangs = array_values($this->createForm->barang);

        // run safely
        return $this->runSafely(function () use ($barangs, $customer) {
            $spk = DB::transaction(function () use ($barangs, $customer) {
                // update data spk
                $data = [
                    'nomor_order' => $this->createForm->nomor_order,
                    'tipe_tagihan' => $this->createForm->tipe_tagihan,
                    'status_nomor_tagihan' => $this->createForm->status_nomor_tagihan,
                    'nomor_tagihan' => $this->createForm->nomor_tagihan,
                    'tipe_bayar' => $this->createForm->tipe_bayar,
                    'tgl_cetak' => $this->createForm->tgl_cetak,
                    'tgl_kirim' => $this->createForm->tgl_kirim,
                    'keterangan' => $this->createForm->keterangan,
                    'customer' => $customer,
                    'tipe_timbangan' => $this->createForm->tipe_timbangan,
                    'products' => $barangs,
                    'assign_to' => $this->createForm->assign_to,
                    'updated_by' => Auth::id(),
                    'on_delay' => $this->is_delayed,
                ];

                if ($this->is_delayed) {
                    $data['on_delay_at'] = now();
                    $data['on_delay_notes'] = $this->delay_note;
                    $data['on_delay_by'] = Auth::id();
                } else {
                    $data['on_delay_at'] = null;
                    $data['on_delay_notes'] = null;
                    $data['on_delay_by'] = null;
                }

                $this->data->update($data);

                // tambah history spk
                SpkHistory::create([
                    'spk_id' => $this->data->id,
                    'title' => 'SPK mengalami perubahan.',
                    'keterangan' => Auth::user()->name.' telah mengubah data SPK.',
                    'added_by' => Auth::id(),
                ]);

                // tambah history spk untuk status delay
                if ($this->is_delayed) {
                    SpkHistory::create([
                        'spk_id' => $this->data->id,
                        'title' => 'SPK mengalami Delay.',
                        'keterangan' => Auth::user()->name." mengubah status SPK menjadi Delay karena: $this->delay_note",
                        'added_by' => Auth::id(),
                    ]);
                }

                // refresh data
                return $this->data->refresh();
            });

            // tampilkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                text: 'Data berhasil diupdate.',
                title: 'Berhasil',
                redirect: [
                    'url' => route('spk.edit', $spk->id),
                    'delay' => 2500,
                ]);
        }, 'Gagal mengubah data SPK', [
            'form_input' => $this->createForm->all(),
            'user_id' => Auth::id(),
        ]);

    }

    public function render()
    {
        // ambil user dengan role Produksi
        $teamProduksi = \App\Models\User::whereHas('roles', fn ($role) => $role->where('name', 'Produksi'))
            ->get();

        return view('livewire.handler.spk.edit', ['users' => $teamProduksi]);
    }
}
