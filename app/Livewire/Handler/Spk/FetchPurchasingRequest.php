<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\PurchasingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FetchPurchasingRequest extends Component
{
    use HandlesErrors;

    #[Validate(
        rule: ['required', 'min:5', 'max:20'],
        message: [
            'required' => 'Kolom :attribute wajib diisi.',
            'min' => 'Kolom :attribute harus memiliki minimal 5 karakter.',
            'max' => 'Kolom :attribute maksimal 20 karakter.',
        ],
        attribute: ['nomor_pr' => 'Nomor Purchasing Request']
    )]
    public ?string $nomor_pr;

    public ?array $data = [];

    public ?string $spk_id;

    public function mount($id)
    {
        // assign id
        $this->spk_id = $id;
    }

    public function fetchPR()
    {
        // validasi nomor_pr
        $this->validateOnly('nomor_pr');

        // cek apakah nomor pr sudah digunakan
        $spk = \App\Models\Spk\SpkMain::select('nomor_purchasing_request')
            ->where('nomor_purchasing_request', $this->nomor_pr)
            ->first();

        // kalo sudah, return error
        if (! empty($spk)) {
            return $this->dispatch('swal', icon: 'error', text: 'Nomor PR sudah digunakan pada SPK lain, coba cek kembali.', title: 'Gagal');
        }

        // kalo belum, akses api
        $url = "https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&NomorPermintaanBeli=$this->nomor_pr";

        // ambil response
        $response = Http::timeout(10)->get($url);

        // jika response gagal
        if (! $response->successful()) {
            // kosongkan data
            $this->data = [];

            // return error
            return $this->dispatch('swal', icon: 'error', text: 'Gagal memuat item Purchasing Request', title: 'Gagal');
        }

        // jika response status tidak sama dengan success
        if ($response->json()['status'] != 'success') {
            // kosongkan data
            $this->data = [];

            // return error
            return $this->dispatch('swal', icon: 'error', text: 'Nomor PR tidak ditemukan di BSI.', title: 'Gagal');
        }

        // return data
        return $this->data = data_get($response->json(), 'data', []);
    }

    public function assign()
    {
        // cek authorization
        $this->authorize('create', PurchasingRequest::class);

        // validasi form
        $this->validate();

        // cek data
        $count = count($this->data);

        // ambil data spk
        $spk = \App\Models\Spk\SpkMain::with('production')
            ->find($this->spk_id);

        // jika belum ada item
        if ($count == 0) {
            // return error
            return $this->dispatch('swal', icon: 'error', text: 'Pilih minimal 1 item untuk di assign.', title: 'Gagal');
        }

        // jika spk tidak ditemukan
        if (! $spk) {
            // return error
            return $this->dispatch('swal', icon: 'error', text: 'Tidak ada spk dengan ID yang dimaksud.', title: 'Gagal');
        }

        // run safely
        $this->runSafely(function () use ($spk) {
            DB::transaction(function () use ($spk) {
                // update spk
                $spk->update([
                    'nomor_purchasing_request' => $this->nomor_pr,
                    'status' => 2,
                    'purchasing_list_updated_by' => Auth::id(),
                ]);

                // tambah ke PurchasignRequest
                foreach ($this->data as $row) {
                    PurchasingRequest::create([
                        'id_spk' => $this->spk_id,
                        'kode_item' => $row['KodeItem'],
                        'nama_item' => $row['NamaItem'],
                        'qty' => $row['DummySisaStock'] ?? 0,
                        'satuan' => $row['Satuan'] ?? '-',
                        'lokasi_gudang_terima' => $row['RencanaGudangPenerimaan'] ?? '-',
                        'jumlah_item_dipesan' => $row['JumlahBarang'] ?? 0,
                        'keterangan' => $row['KeteranganDetail'] ?? '-',
                    ]);
                }

                // update history gudang
                ProductionHistory::create([
                    'id_produksi' => $spk->production->id,
                    'judul' => 'Nomor PR sudah diupdate.',
                    'keterangan' => 'Menunggu team produksi untuk update progress pengerjaan...',
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);
            });

            // return success
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                text: 'Data berhasil disimpan',
                title: 'Berhasil',
                redirect: [
                    'url' => route('purchasing-request.index'),
                    'delay' => 2000,
                ]);
        }, 'Gagal update nomor PR', [
            'form_input' => $this->all(),
            'user_id' => Auth::id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.spk.fetch-purchasing-request');
    }
}
