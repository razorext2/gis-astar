<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
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
    public ?string $nomor_pr = null;

    public ?array $data = [];

    public ?array $data_pr = [];

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
        $spk = SpkMain::select('nomor_purchasing_request')
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

    public function addPr()
    {
        if (empty($this->data)) {
            return $this->dispatch('swal', icon: 'error', text: 'Data PR belum di fetch.', title: 'Gagal');
        }

        if ($this->checkExistingPr($this->nomor_pr)) {
            return $this->dispatch('swal', icon: 'error', text: 'Nomor PR sudah ada di dalam daftar.', title: 'Gagal');
        }

        $this->data_pr[] = [
            'nomor_pr' => $this->nomor_pr,
            'data' => $this->data,
        ];

        $this->clearPr();
    }

    public function clearPr()
    {
        $this->nomor_pr = null;
        $this->data = [];
    }

    public function assign()
    {
        // cek authorization
        $this->authorize('update', PurchasingRequest::class);

        // validasi data
        $data = collect($this->data_pr);

        // jika belum ada item
        if ($data->count() == 0) {
            // return error
            return $this->dispatch('swal', icon: 'error', text: 'Tambah minimal 1 PR untuk di assign.', title: 'Gagal');
        }

        // ambil data spk
        $spk = SpkMain::with('production')
            ->findOrFail($this->spk_id);

        // jika status approval blm approve
        if ($spk->status_approval != 1) {
            // return error
            return $this->dispatch('swal', icon: 'error', text: 'SPK belum di approve.', title: 'Gagal');
        }

        $field = match (true) {
            $data->count() === 1 => 'nomor_purchasing_request',
            $data->count() > 1 => 'nomor_purchasing_request_json',
            default => null,
        };

        if ($field === null) {
            return $this->dispatch(
                'swal',
                icon: 'error',
                text: 'Data PR belum di fetch.',
                title: 'Gagal'
            );
        }

        // run safely
        $this->runSafely(function () use ($spk, $field, $data) {
            $nomorPrCollection = $data->pluck('nomor_pr');

            $nomor_pr = $nomorPrCollection->count() === 1
                ? $nomorPrCollection->first()
                : $nomorPrCollection->values()->toArray();

            DB::transaction(function () use ($spk, $field, $nomor_pr) {
                // update spk
                $spk->update([
                    $field => $nomor_pr,
                    'status' => $spk->status <= 2 ? 2 : $spk->status,
                    'purchasing_list_updated_by' => Auth::id(),
                ]);

                // tambah ke PurchasignRequest
                foreach ($this->data_pr as $row) {
                    foreach ($row['data'] as $item) {
                        PurchasingRequest::create([
                            'id_spk' => $this->spk_id,
                            'nomor_purchasing_request' => $row['nomor_pr'],

                            'kode_item' => $item['KodeItem'],
                            'nama_item' => $item['NamaItem'],

                            'qty' => $item['DummySisaStock'] ?? 0,
                            'satuan' => $item['Satuan'] ?? '-',
                            'lokasi_gudang_terima' => $item['RencanaGudangPenerimaan'] ?? '-',
                            'jumlah_item_dipesan' => $item['JumlahBarang'] ?? 0,
                            'keterangan' => $item['KeteranganDetail'] ?? '-',
                        ]);
                    }
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

    public function checkExistingPr($nomor_pr)
    {
        return collect($this->data_pr)
            ->where('nomor_pr', $nomor_pr)
            ->values()
            ->isNotEmpty();
    }

    public function render()
    {
        return view('livewire.handler.spk.fetch-purchasing-request');
    }
}
