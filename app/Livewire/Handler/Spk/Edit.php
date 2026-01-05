<?php

namespace App\Livewire\Handler\Spk;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Create as SpkCreate;
use App\Models\Spk\SpkHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use HandlesErrors;

    public SpkCreate $createForm;

    public $id;

    public $data;

    public ?string $nama_barang;

    public ?int $jumlah_unit;

    public ?int $assign_to;

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
        foreach ($data->products as $row) {
            $this->createForm->barang[] = $row;
        }

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
    }

    public function tambahBarang()
    {
        // validasi field nama_barang
        $this->validate([
            'nama_barang' => 'required|min:5|string',
            'jumlah_unit' => 'required|numeric|min:1',
        ], [
            'nama_barang.required' => 'Kolom nama barang wajib diisi.',
            'nama_barang.min' => 'Kolom nama barang minimal berisi 5 karakter.',
            'nama_barang.string' => 'Kolom nama barang harus berupa string.',
            'jumlah_unit.required' => 'Kolom jumlah unit wajib diisi.',
            'jumlah_unit.numeric' => 'Kolom jumlah unit harus berupa angka.',
            'jumlah_unit.min' => 'Kolom jumlah unit minimal berjumlah 1 buah.',
        ]);

        // assign barang ke array
        $this->createForm->barang[] = [
            'nama_barang' => $this->nama_barang,
            'jumlah_unit' => $this->jumlah_unit,
        ];

        // kosongkan nama_barang
        $this->nama_barang = null;
        $this->jumlah_unit = null;
    }

    public function hapusBarang($index)
    {
        // hapus barang dari array
        unset($this->createForm->barang[$index]);

        // refresh value didalam array
        $this->createForm->barang = array_values($this->createForm->barang);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('update', \App\Models\Spk\SpkMain::class);

        // inisialisasi variabel
        $customer = [];
        $barangs = [];

        // inisialisasi field yang akan divalidasi
        $fieldsToValidate = [
            'nama_customer',
            'alamat_customer',
            'contact_person',
            'no_telp',
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
                $this->data->update([
                    'nomor_order' => $this->createForm->nomor_order,
                    'tipe_tagihan' => $this->createForm->tipe_tagihan,
                    'status_nomor_tagihan' => $this->createForm->status_nomor_tagihan,
                    'nomor_tagihan' => $this->createForm->nomor_tagihan,
                    'tipe_bayar' => $this->createForm->tipe_bayar,
                    'tgl_cetak' => $this->createForm->tgl_cetak,
                    'tgl_kirim' => $this->createForm->tgl_kirim,
                    'keterangan' => $this->createForm->keterangan,
                    'customer' => $customer,
                    'products' => $barangs,
                    'assign_to' => $this->createForm->assign_to,
                    'updated_by' => Auth::id(),
                ]);

                // tambah history spk
                SpkHistory::create([
                    'spk_id' => $this->data->id,
                    'title' => 'SPK mengalami perubahan.',
                    'keterangan' => Auth::user()->name.' telah mengubah data SPK.',
                    'added_by' => Auth::id(),
                ]);

                // refresh data
                return $this->data->refresh();
            });

            // jalankan job untuk download PDF
            ExportPdfJob::dispatch(
                ['spk-create'],
                'App\Models\Spk\SpkMain',
                $spk->id,
                'f4',
                'portrait',
                'dashboard.pdf.spksummary',
                "SPK $spk->nomor_order anda telah siap untuk didownload. Silahkan klik tombol download dibawah ini:",
                'spk.download');

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
