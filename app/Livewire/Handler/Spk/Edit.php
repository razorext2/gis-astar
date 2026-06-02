<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Attachment;
use App\Livewire\Forms\Spk\Barang;
use App\Livewire\Forms\Spk\Create as SpkCreate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use HandlesErrors, WithFileUploads;

    public SpkCreate $createForm;

    public Barang $barangForm;

    public Attachment $docForm;

    public $id;

    public $data;

    public ?string $delay_note;

    public ?string $cancel_note;

    public bool $is_delayed = false;

    public bool $is_cancelled = false;

    public bool $is_changed = false;

    public bool $is_edit = false;

    public function mount($id)
    {
        // assign id
        $this->id = $id;

        // ambil data spk berdasarkan id
        $this->data = \App\Models\Spk\SpkMain::with('production')
            ->findOrFail($id);

        // assign data spk ke form
        $this->createForm->nama_customer = $this->data->customer['nama_perusahaan'];
        $this->createForm->no_telp = $this->data->customer['no_hp'];
        $this->createForm->contact_person = $this->data->customer['contact_person'] ?? $this->data->company_name;
        $this->createForm->alamat_customer = $this->data->customer['alamat'];

        // assign _key ke setiap item barang
        $this->createForm->barang = collect($this->data->products)
            ->map(fn ($item) => array_merge($item, [
                '_key' => (string) Str::uuid(),
            ]))->toArray();

        // assign data spk tagihan ke form
        $this->createForm->status_nomor_tagihan = $this->data->status_nomor_tagihan;
        $this->createForm->nomor_tagihan = $this->data->nomor_tagihan;
        $this->createForm->tipe_tagihan = $this->data->tipe_tagihan;
        $this->createForm->nomor_order = $this->data->nomor_order;
        $this->createForm->tipe_bayar = $this->data->tipe_bayar;
        $this->createForm->tgl_cetak = $this->data->tgl_cetak;
        $this->createForm->tgl_kirim = $this->data->tgl_kirim === 'SEGERA' ? 1 : $this->data->tgl_kirim;
        $this->createForm->assign_to = $this->data->assign_to;
        $this->createForm->keterangan = $this->data->keterangan;
        $this->createForm->tipe_timbangan = $this->data->tipe_timbangan;
        $this->createForm->nomor_dokumen_penawaran = $this->data->nomor_dokumen_penawaran;
        $this->createForm->is_booked = $this->data->is_booked;
        $this->docForm->new_attachments = $this->data->documentations ?? [];

        // untuk keperluan validasi
        $this->createForm->spk_id = $this->data->id;
        $this->createForm->status_approval = $this->data->status_approval;

        // keperluan delay
        $this->is_delayed = $this->data->on_delay;
        $this->delay_note = $this->data->on_delay_notes;

        // keperluan pembatalan
        $this->is_cancelled = $this->data->is_cancelled;
        $this->cancel_note = $this->data->cancel_request_reason;

        // keperluan pengiriman
        $this->createForm->is_using_company_driver = $this->data->is_using_company_driver;
        $this->createForm->is_picked_up_by_customer = $this->data->is_picked_up_by_customer;
    }

    public function storeBarang()
    {
        // validasi nama barang
        $this->barangForm->validate();

        // data barang dengan _key
        $payload = [
            '_key' => (string) Str::uuid(),
            'nama_barang' => $this->barangForm->nama_barang,
            'jumlah_unit' => $this->barangForm->jumlah_unit,
            'satuan_barang' => $this->barangForm->satuan_barang,
            'spesifikasi' => $this->barangForm->spesifikasi,
        ];

        if ($this->is_edit && $this->barangForm->index_barang !== null) {
            // pertahankan _key lama saat edit
            $payload['_key'] = $this->createForm->barang[$this->barangForm->index_barang]['_key'];

            $this->createForm->barang[$this->barangForm->index_barang] = $payload;

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
        $this->barangForm->index_barang = $index;

        // set form fields sesuai index
        $this->barangForm->nama_barang = $this->createForm->barang[$index]['nama_barang'];
        $this->barangForm->jumlah_unit = $this->createForm->barang[$index]['jumlah_unit'];
        $this->barangForm->satuan_barang = $this->createForm->barang[$index]['satuan_barang'];
        $this->barangForm->spesifikasi = $this->createForm->barang[$index]['spesifikasi'];
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
        if ($this->is_edit && $this->barangForm->index_barang !== null) {
            // reset edit state
            $this->is_edit = false;
            $this->barangForm->index_barang = null;
        }

        $this->barangForm->nama_barang = null;
        $this->barangForm->jumlah_unit = null;
        $this->barangForm->satuan_barang = null;
        $this->barangForm->spesifikasi = null;
    }

    public function upBarang(int $index)
    {
        $this->createForm->moveItem($index, $index - 1);
    }

    public function downBarang(int $index)
    {
        $this->createForm->moveItem($index, $index + 1);
    }

    public function storeLampiran()
    {
        $this->docForm->validate();

        $this->docForm->addAttachment();
    }

    public function removeAttachment($index)
    {
        if (isset($this->docForm->new_attachments[$index]['url'])) {
            $this->runSafely(function () use ($index) {
                // hapus file dari storage
                Storage::delete($this->docForm->new_attachments[$index]['url']);

                // hapus object dari array
                unset($this->docForm->new_attachments[$index]);

                // refresh value didalam array
                $this->docForm->new_attachments = array_values($this->docForm->new_attachments);

                // update array di database
                $this->data->update([
                    'documentations' => $this->docForm->new_attachments,
                ]);

                // munculkan pesan swal
                $this->dispatch(
                    event: 'swal',
                    icon: 'success',
                    title: 'Berhasil.',
                    text: 'File lampiran telah dihapus.');
            }, 'Gagal menghapus lampiran dari storage dan database.', [
                'form_input' => $this->docForm->new_attachments[$index],
                'user_id' => Auth::id(),
            ]);
        }

        $this->docForm->removeAttachment($index);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('update', $this->data);

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

        // assign data barang ke array
        $barangs = array_values($this->createForm->barang);

        // run safely
        return $this->runSafely(function () use ($barangs) {
            // panggil method simpan lampiran ke folder
            $lampiran = $this->docForm->storeAttachment();

            $spk = DB::transaction(function () use ($barangs, $lampiran) {
                // update data spk
                $data = [
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
                    'assign_to' => $this->createForm->assign_to,
                    'updated_by' => Auth::id(),
                    'on_delay' => $this->is_delayed,
                    'is_booked' => $this->createForm->is_booked,
                    'booked_at' => $this->createForm->is_booked ? now() : null,
                    'booked_by' => $this->createForm->is_booked ? Auth::id() : null,
                    'documentations' => $lampiran ?? [],
                    'is_cancelled' => $this->is_cancelled,
                    'is_using_company_driver' => $this->createForm->is_using_company_driver,
                    'is_picked_up_by_customer' => $this->createForm->is_picked_up_by_customer,
                ];

                $title = 'SPK mengalami perubahan.';
                $history_message = Auth::user()->name.' telah mengubah data SPK.';

                // jika bukan user dengan permission spk-validate dan checkbox revisi diaktifkan, reset approval
                if (auth()->user()->cannot('spk-approve') && $this->is_changed && $this->data->status_approval == 1) {
                    $data['status_approval'] = 0;
                    $data['approved_by'] = null;
                    $data['approved_at'] = null;
                    $data['catatan_approval'] = null;

                    // masukkan data permintaan revisi ke database
                    // $data['revision_count'] = $this->data->revision_count + 1; // jangan tambah kalo blm divalidasi
                    $data['is_revision'] = 1; // true
                    $data['latest_revision_request_by'] = Auth::id();
                    $data['latest_revision_request_detail'] = $this->createForm->revision_request_detail;

                    $title = 'SPK telah direvisi.';
                    $history_message = Auth::user()->name.' telah meminta approval kembali dikarenakan telah mengubah: '.$this->createForm->revision_request_detail;
                }

                // jika status delay diaktifkan
                if ($this->is_delayed) {
                    $data['on_delay_at'] = now();
                    $data['on_delay_notes'] = $this->delay_note;
                    $data['on_delay_by'] = Auth::id();

                    $title = 'SPK mengalami delay.';
                    $history_message = Auth::user()->name.' mengubah status SPK menjadi Delay karena: '.$this->delay_note;
                }

                // jika status dibatalkan
                if ($this->is_cancelled) {
                    $data['cancel_request_by'] = Auth::id();
                    $data['cancel_request_reason'] = $this->cancel_note;
                    $data['cancel_request_at'] = now();

                    $title = 'SPK dibatalkan.';
                    $history_message = Auth::user()->name.' membatalkan SPK karena: '.$this->cancel_note;
                }

                // cek jika nilai dari field assign_to berubah
                if ($this->createForm->assign_to !== $this->data->assign_to) {
                    $this->data->production->update([
                        'assign_to' => $this->createForm->assign_to,
                    ]);
                }

                // cek assign_to spk dan produksi, kalo diubah / nilainya gak sama
                if ($this->data->assign_to != $this->createForm->assign_to) {
                    // ubah assign to yg diproduksi
                    $this->data->production->update([
                        'assign_to' => $this->createForm->assign_to,
                    ]);

                    // tambah history spk
                    $this->createForm->generateHistory(
                        $this->data->id,
                        'Staf Produksi telah diubah.',
                        'Staf yang mengerjakan Produksi telah diubah dari '.$this->data->assign_to.' menjadi '.$this->createForm->assign_to,
                        Auth::id(),
                    );
                }

                // update data spk
                $this->data->update($data);

                // tambah history spk
                $this->createForm->generateHistory(
                    $this->data->id,
                    $title,
                    $history_message,
                    Auth::id(),
                );

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

    public function updatedIsChanged()
    {
        $this->createForm->is_changed = $this->is_changed;
    }

    public function render()
    {
        // ambil user dengan role Produksi
        $teamProduksi = \App\Models\User::whereHas('roles', fn ($role) => $role->where('name', 'Produksi'))
            ->get();

        return view('livewire.handler.spk.edit', ['users' => $teamProduksi]);
    }
}
