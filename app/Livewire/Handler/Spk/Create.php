<?php

/** Goal: Handles SPK creation flow, Caller: routes/web.php, Deps: SpkCreate, Barang, Attachment, SpkMain, Production */

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Attachment;
use App\Livewire\Forms\Spk\Barang;
use App\Livewire\Forms\Spk\Create as SpkCreate;
use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

    public SpkCreate $createForm;

    public Barang $barangForm;

    public Attachment $docForm;

    public bool $showSummary = false;

    public bool $is_edit = false;

    public function tambahBarang()
    {
        // validasi nama barang
        $this->barangForm->validate();

        // data barang dengan _key
        $barangs = [
            '_key' => (string) Str::uuid(),
            'nama_barang' => $this->barangForm->nama_barang,
            'jumlah_unit' => $this->barangForm->jumlah_unit,
            'satuan_barang' => $this->barangForm->satuan_barang,
            'spesifikasi' => $this->barangForm->spesifikasi,
        ];

        if ($this->is_edit && $this->barangForm->index_barang !== null) {
            // pertahankan _key lama saat edit
            $barangs['_key'] = $this->createForm->barang[$this->barangForm->index_barang]['_key'];

            $this->createForm->barang[$this->barangForm->index_barang] = $barangs;

            // reset form barang dan edit state
            $this->resetBarang();

            return;
        }

        // tambahkan barang ke array
        $this->createForm->barang[] = $barangs;

        // reset form barang dan edit state
        $this->resetBarang();
    }

    public function editBarang($index)
    {
        // set is_edit true
        $this->is_edit = true;

        // set index_barang
        $this->barangForm->index_barang = $index;

        // set form fields sesuai index
        $this->barangForm->nama_barang = $this->createForm->barang[$index]['nama_barang'];
        $this->barangForm->jumlah_unit = $this->createForm->barang[$index]['jumlah_unit'];
        $this->barangForm->satuan_barang = $this->createForm->barang[$index]['satuan_barang'];
        $this->barangForm->spesifikasi = $this->createForm->barang[$index]['spesifikasi'];
    }

    public function hapusBarang($index)
    {
        // hapus barang sesuai index
        unset($this->createForm->barang[$index]);

        // refresh value didalam array
        $this->createForm->barang = array_values($this->createForm->barang);
    }

    public function resetBarang()
    {
        // reset form barang dan edit state
        $this->is_edit = $this->barangForm->resetBarang($this->is_edit);
    }

    public function summary()
    {
        // panggil stream dari form create
        $this->createForm->stream();

        // munculkan modal summary
        $this->showSummary = true;

        // munculkan modal pdf
        $this->dispatch('show-pdf-modal', url: route('spk.pdf').'?t='.now()->timestamp);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('create', SpkMain::class);

        // cek yg dichecklist
        if ($this->createForm->is_using_company_driver === true && $this->createForm->is_picked_up_by_customer === true) {
            return $this->dispatch(
                event: 'swal',
                icon: 'error',
                title: 'Gagal.',
                text: 'Anda tidak boleh mencentang kedua tipe pengiriman sekaligus. Anda hanya dapat memilih salah satu, atau tidak pilih sama sekali.'
            );
        }

        // validasi form
        $this->createForm->validate();

        if ($this->createForm->is_booked) {
            $this->createForm->barang[] = [
                '_key' => (string) Str::uuid(),
                'nama_barang' => 'Dummy',
                'jumlah_unit' => 0,
                'satuan_barang' => 'lot',
                'spesifikasi' => null,
            ];
            $this->createForm->tgl_cetak = now()->toDateString();
            $this->createForm->tgl_kirim = 1;
            $this->createForm->tipe_bayar = 'Bon';
            $this->createForm->keterangan = 'Nomor SPK ini sudah dibooking untuk penawaran.';
        }

        // assign daftar barang ke array
        $barangs = array_values($this->createForm->barang);

        return $this->runSafely(function () use ($barangs) {
            // panggil method simpan lampiran ke folder
            $lampiran = $this->docForm->storeAttachment();

            // tambah data SPK
            DB::transaction(function () use ($barangs, $lampiran) {
                $spk = SpkMain::create([
                    'nomor_order' => $this->createForm->nomor_order,
                    'nomor_dokumen_penawaran' => $this->createForm->nomor_dokumen_penawaran,
                    'tipe_tagihan' => $this->createForm->tipe_tagihan,
                    'status_nomor_tagihan' => $this->createForm->status_nomor_tagihan,
                    'nomor_tagihan' => $this->createForm->nomor_tagihan,
                    'tipe_bayar' => $this->createForm->tipe_bayar,
                    'tgl_cetak' => $this->createForm->tgl_cetak,
                    'tgl_kirim' => $this->createForm->tgl_kirim <= 1
                        ? 'SEGERA'
                        : $this->createForm->tgl_kirim,
                    'keterangan' => $this->createForm->keterangan,
                    'customer' => $this->createForm->generateCustomerData(),
                    'company_name' => $this->createForm->nama_customer,
                    'tipe_timbangan' => $this->createForm->tipe_timbangan,
                    'products' => $barangs,
                    'status' => 0,
                    'assign_to' => $this->createForm->assign_to,
                    'added_by' => Auth::id(),
                    'update_by' => Auth::id(),
                    'status_approval' => 0,
                    'is_booked' => (bool) $this->createForm->is_booked,
                    'booked_at' => $this->createForm->is_booked ? now() : null,
                    'booked_by' => $this->createForm->is_booked ? Auth::id() : null,
                    'documentations' => $lampiran ?? [],
                    'is_using_company_driver' => $this->createForm->is_using_company_driver,
                    'is_picked_up_by_customer' => $this->createForm->is_picked_up_by_customer,
                ]);

                // tambah data history SPK
                $spk->addHistory(
                    'SPK Dibuat.',
                    Auth::user()->name.' telah membuat SPK baru. Sedang menunggu approval dari tim Management.',
                    Auth::id()
                );

                // tambah data produksi
                Production::create([
                    'id_spk' => $spk->id,
                    'assign_to' => $this->createForm->assign_to,
                    'status_produksi' => 0,
                ]);

                // kembalikan nilai spk
                return $spk;
            });

            // reset dan refresh komponen
            $this->createForm->reset();

            // munculkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil membuat SPK baru.',
                redirect: [
                    'url' => route('spk.index'),
                    'delay' => 2000,
                ]);
        }, 'Gagal menyimpan data SPK', [
            'form_input' => $this->createForm->all(),
            'user_id' => Auth::id(),
        ]);
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

    public function updatedCreateFormTipeTagihan()
    {
        if (! in_array($this->createForm->tipe_tagihan, ['idcppn', 'idcnon'], true)) {
            $this->createForm->nomor_order = null;
        } else {
            $this->createForm->nomor_order = $this->createForm->makeNomorOrder($this->createForm->tipe_tagihan)['baru'];
        }
    }

    public function render()
    {
        // ambil user dengan role Produksi
        $teamProduksi = User::whereHas('roles', fn ($role) => $role->where('name', 'Produksi'))
            ->where('is_active', true)
            ->get();

        return view('livewire.handler.spk.create', [
            'users' => $teamProduksi,
            'nomor_order_lama' => $this->createForm->makeNomorOrder($this->createForm->tipe_tagihan)['lama'],
        ]);
    }
}
