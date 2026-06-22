<?php

/** Goal: Handle fetch & assign PR by nomor PR, nomor order or nomor PO, Caller: fetch-purchasing-request.blade.php, Deps: SpkMain, PurchasingRequest, ProductionHistory */

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

    /** Nomor order untuk fetch PR by KeteranganDetail */
    public ?string $nomor_order = null;

    /** Nomor PO untuk fetch PR by NomorPesananBeli */
    public ?string $nomor_po = null;

    /** Preview data hasil fetch by nomor order */
    public array $orderPreviewData = [];

    public bool $showOrderPreview = false;

    public function mount(string $id, ?string $nomorOrder = null): void
    {
        $this->spk_id = $id;

        if ($nomorOrder) {
            $this->nomor_order = $nomorOrder;
        }
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

    public function addPr(): void
    {
        if (empty($this->data)) {
            $this->dispatch('swal', icon: 'error', text: 'Data PR belum di fetch.', title: 'Gagal');

            return;
        }

        if ($this->checkExistingPr($this->nomor_pr)) {
            $this->dispatch('swal', icon: 'error', text: 'Nomor PR sudah ada di dalam daftar.', title: 'Gagal');

            return;
        }

        // Ambil kode_item yang sudah ada di DB untuk nomor PR ini
        $existingKodes = PurchasingRequest::where('id_spk', $this->spk_id)
            ->where('nomor_purchasing_request', $this->nomor_pr)
            ->pluck('kode_item')
            ->toArray();

        $newItems = collect($this->data)
            ->filter(fn ($item) => ! in_array($item['KodeItem'] ?? '', $existingKodes))
            ->values()
            ->toArray();

        if (empty($newItems)) {
            $this->dispatch('swal', icon: 'info', text: 'Semua item PR ini sudah ada di database.', title: 'Info');
            $this->clearPr();

            return;
        }

        $this->data_pr[] = [
            'nomor_pr' => $this->nomor_pr,
            'data' => $newItems,
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

    /**
     * Fetch data PR dari API berdasarkan KeteranganDetail = nomor_order lalu tampilkan preview.
     */
    public function fetchByNomorOrder(): void
    {
        $this->validate(['nomor_order' => 'required|min:3'], [
            'nomor_order.required' => 'Nomor order wajib diisi.',
            'nomor_order.min' => 'Nomor order minimal 3 karakter.',
        ]);

        $this->runSafely(function () {
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&KeteranganDetail='.urlencode($this->nomor_order);

            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                $this->orderPreviewData = [];
                $this->showOrderPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Gagal memuat data dari API.', title: 'Gagal');

                return;
            }

            $json = $response->json();

            if (($json['status'] ?? '') !== 'success' || empty($json['data'])) {
                $this->orderPreviewData = [];
                $this->showOrderPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Data PR tidak ditemukan di BSI untuk nomor order ini.', title: 'Gagal');

                return;
            }

            $this->orderPreviewData = $json['data'];
            $this->showOrderPreview = true;
        }, 'Gagal fetch data PR dari API.');
    }

    /**
     * Tambahkan item-item baru dari orderPreviewData ke data_pr,
     * dikelompokkan per NomorPermintaanBeli, dengan deduplication.
     */
    public function processAddByNomorOrder(): void
    {
        if (empty($this->orderPreviewData)) {
            $this->dispatch('swal', icon: 'error', text: 'Tidak ada data untuk diproses.', title: 'Gagal');

            return;
        }

        // Ambil semua kode_item yang sudah ada di DB untuk SPK ini (composite key)
        $existingDbKeys = PurchasingRequest::where('id_spk', $this->spk_id)
            ->select(['nomor_purchasing_request', 'kode_item'])
            ->get()
            ->map(fn ($row) => $row->nomor_purchasing_request.'|'.$row->kode_item)
            ->toArray();

        $grouped = collect($this->orderPreviewData)->groupBy('NomorPermintaanBeli');
        $addedCount = 0;

        foreach ($grouped as $nomorPr => $items) {
            // Filter item yang belum ada di DB
            $newFromDb = $items->filter(
                fn ($item) => ! in_array($nomorPr.'|'.($item['KodeItem'] ?? ''), $existingDbKeys)
            )->values();

            if ($newFromDb->isEmpty()) {
                continue;
            }

            // Cek apakah nomor PR sudah ada di data_pr (in-memory)
            $existingIndex = collect($this->data_pr)
                ->search(fn ($row) => $row['nomor_pr'] === $nomorPr);

            if ($existingIndex !== false) {
                // Merge: dedup by KodeItem terhadap data_pr yang sudah ada
                $existingKodes = collect($this->data_pr[$existingIndex]['data'])
                    ->pluck('KodeItem')
                    ->toArray();

                $newItems = $newFromDb
                    ->filter(fn ($item) => ! in_array($item['KodeItem'] ?? '', $existingKodes))
                    ->values()
                    ->toArray();

                if (! empty($newItems)) {
                    $this->data_pr[$existingIndex]['data'] = array_merge(
                        $this->data_pr[$existingIndex]['data'],
                        $newItems
                    );
                    $addedCount += count($newItems);
                }
            } else {
                $this->data_pr[] = [
                    'nomor_pr' => $nomorPr,
                    'data' => $newFromDb->toArray(),
                ];
                $addedCount += $newFromDb->count();
            }
        }

        $this->cancelOrderPreview();

        if ($addedCount === 0) {
            $this->dispatch('swal', icon: 'info', text: 'Semua item PR dari nomor order ini sudah ada di database.', title: 'Info');

            return;
        }

        $this->dispatch('swal', icon: 'success', text: "{$addedCount} item berhasil ditambahkan ke daftar PR.", title: 'Berhasil');
    }

    /**
     * Batalkan preview fetch by nomor order.
     */
    public function cancelOrderPreview(): void
    {
        $this->orderPreviewData = [];
        $this->showOrderPreview = false;
    }

    /**
     * Fetch data PR dari API berdasarkan NomorPesananBeli = nomor_po lalu tampilkan preview.
     */
    public function fetchByNomorPO(): void
    {
        $this->validate(['nomor_po' => 'required|min:3'], [
            'nomor_po.required' => 'Nomor PO wajib diisi.',
            'nomor_po.min' => 'Nomor PO minimal 3 karakter.',
        ]);

        $this->runSafely(function () {
            // [KOMENTAR PENTING UNTUK DIGANTI NANTINYA]
            // API saat ini menggunakan tipe=fetchPermintaanBeli dan parameter query NomorPesananBeli
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&NomorPesananBeli='.urlencode($this->nomor_po);

            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                $this->orderPreviewData = [];
                $this->showOrderPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Gagal memuat data dari API.', title: 'Gagal');

                return;
            }

            $json = $response->json();

            if (($json['status'] ?? '') !== 'success' || empty($json['data'])) {
                $this->orderPreviewData = [];
                $this->showOrderPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Data PR tidak ditemukan di BSI untuk nomor PO ini.', title: 'Gagal');

                return;
            }

            $this->orderPreviewData = $json['data'];
            $this->showOrderPreview = true;
        }, 'Gagal fetch data PR dari API.');
    }

    public function render()
    {
        return view('livewire.handler.spk.fetch-purchasing-request');
    }
}
