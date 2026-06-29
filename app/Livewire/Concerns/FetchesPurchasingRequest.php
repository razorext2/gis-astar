<?php

/** Goal: Shared fetch PR logic for both create & edit PR components, Caller: FetchPurchasingRequest, EditPurchasingRequest, Deps: SpkMain, PurchasingRequest, Http */

namespace App\Livewire\Concerns;

use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;

trait FetchesPurchasingRequest
{
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

    public array $data = [];

    public array $data_pr = [];

    public ?string $spk_id;

    /** Nomor order untuk fetch PR by KeteranganDetail */
    public ?string $nomor_order = null;

    /** Nomor PO untuk fetch PR by NomorPesananBeli */
    public ?string $nomor_po = null;

    /** Preview data hasil fetch by nomor order/PO */
    public array $orderPreviewData = [];

    public bool $showOrderPreview = false;

    /** Selected items for PR list */
    public array $selectedPrItems = [];

    /** Selected items for Order/PO preview list */
    public array $selectedOrderItems = [];

    /**
     * Fetch item PR dari BSI API berdasarkan nomor PR.
     *
     * @param  string|null  $excludeSpkId  SPK ID yang di-exclude dari pengecekan duplikat (untuk mode edit)
     */
    public function fetchPR(?string $excludeSpkId = null): mixed
    {
        $this->validateOnly('nomor_pr');

        $query = SpkMain::where(function ($q) {
            $q->where('nomor_purchasing_request', $this->nomor_pr)
              ->orWhereJsonContains('nomor_purchasing_request_json', $this->nomor_pr);
        });

        if ($excludeSpkId) {
            $query->where('id', '!=', $excludeSpkId);
        }

        if ($query->exists()) {
            return $this->dispatch('swal', icon: 'error', text: 'Nomor PR sudah digunakan pada SPK lain, coba cek kembali.', title: 'Gagal');
        }

        $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&NomorPermintaanBeli=' . urlencode($this->nomor_pr);
        $response = Http::timeout(10)->get($url);

        if (! $response->successful() || ($response->json()['status'] ?? '') !== 'success') {
            $this->data = [];
            $this->selectedPrItems = [];

            $errorText = ! $response->successful()
                ? 'Gagal memuat item Purchasing Request'
                : 'Nomor PR tidak ditemukan di BSI.';

            return $this->dispatch('swal', icon: 'error', text: $errorText, title: 'Gagal');
        }

        $this->data = data_get($response->json(), 'data', []);
        $this->selectedPrItems = array_keys($this->data);

        return $this->data;
    }

    public function toggleSelectAllPr(): void
    {
        $this->selectedPrItems = count($this->selectedPrItems) === count($this->data)
            ? []
            : array_keys($this->data);
    }

    public function addPr(): void
    {
        if (empty($this->data)) {
            $this->dispatch('swal', icon: 'error', text: 'Data PR belum di fetch.', title: 'Gagal');

            return;
        }

        if (empty($this->selectedPrItems)) {
            $this->dispatch('swal', icon: 'error', text: 'Pilih minimal 1 item PR.', title: 'Gagal');

            return;
        }

        if ($this->checkExistingPr($this->nomor_pr)) {
            $this->dispatch('swal', icon: 'error', text: 'Nomor PR sudah ada di dalam daftar.', title: 'Gagal');

            return;
        }

        $existingKodes = PurchasingRequest::where('id_spk', $this->spk_id)
            ->where('nomor_purchasing_request', $this->nomor_pr)
            ->pluck('kode_item')
            ->toArray();

        $newItems = collect($this->data)
            ->filter(fn ($item, $key) => in_array($key, $this->selectedPrItems))
            ->filter(fn ($item) => ! in_array($item['KodeItem'] ?? '', $existingKodes))
            ->values()
            ->toArray();

        if (empty($newItems)) {
            $this->dispatch('swal', icon: 'info', text: 'Semua item PR terpilih sudah ada di database.', title: 'Info');
            $this->clearPr();

            return;
        }

        $this->data_pr[] = [
            'nomor_pr' => $this->nomor_pr,
            'data' => $newItems,
        ];

        $this->clearPr();
    }

    public function clearPr(): void
    {
        $this->nomor_pr = null;
        $this->data = [];
        $this->selectedPrItems = [];
    }

    public function checkExistingPr(string $nomor_pr): bool
    {
        return collect($this->data_pr)
            ->where('nomor_pr', $nomor_pr)
            ->isNotEmpty();
    }

    public function fetchByNomorOrder(): void
    {
        $this->validate(['nomor_order' => 'required|min:3'], [
            'nomor_order.required' => 'Nomor order wajib diisi.',
            'nomor_order.min' => 'Nomor order minimal 3 karakter.',
        ]);

        $this->runSafely(function () {
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&KeteranganDetail=' . urlencode($this->nomor_order);

            $this->fetchOrderPreviewFromApi($url, 'nomor order');
        }, 'Gagal fetch data PR dari API.');
    }

    public function toggleSelectAllOrder(): void
    {
        $this->selectedOrderItems = count($this->selectedOrderItems) === count($this->orderPreviewData)
            ? []
            : array_keys($this->orderPreviewData);
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

        if (empty($this->selectedOrderItems)) {
            $this->dispatch('swal', icon: 'error', text: 'Pilih minimal 1 item untuk ditambahkan.', title: 'Gagal');

            return;
        }

        $existingDbKeys = PurchasingRequest::where('id_spk', $this->spk_id)
            ->select(['nomor_purchasing_request', 'kode_item'])
            ->get()
            ->map(fn ($row) => $row->nomor_purchasing_request . '|' . $row->kode_item)
            ->toArray();

        $selectedData = collect($this->orderPreviewData)
            ->filter(fn ($item, $key) => in_array($key, $this->selectedOrderItems));

        $grouped = $selectedData->groupBy('NomorPermintaanBeli');
        $addedCount = 0;

        foreach ($grouped as $nomorPr => $items) {
            $newFromDb = $items->filter(
                fn ($item) => ! in_array($nomorPr . '|' . ($item['KodeItem'] ?? ''), $existingDbKeys)
            )->values();

            if ($newFromDb->isEmpty()) {
                continue;
            }

            $existingIndex = collect($this->data_pr)
                ->search(fn ($row) => $row['nomor_pr'] === $nomorPr);

            if ($existingIndex !== false) {
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
            $this->dispatch('swal', icon: 'info', text: 'Semua item PR terpilih dari nomor order/PO ini sudah ada di database.', title: 'Info');

            return;
        }

        $this->dispatch('swal', icon: 'success', text: "{$addedCount} item berhasil ditambahkan ke daftar PR.", title: 'Berhasil');
    }

    public function cancelOrderPreview(): void
    {
        $this->orderPreviewData = [];
        $this->selectedOrderItems = [];
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
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPembelian&NomorPembelian=' . urlencode($this->nomor_po);

            $this->fetchOrderPreviewFromApi($url, 'nomor PO');
        }, 'Gagal fetch data PR dari API.');
    }

    /**
     * Shared helper: call BSI API, parse response, and populate orderPreviewData.
     */
    private function fetchOrderPreviewFromApi(string $url, string $label): void
    {
        $response = Http::timeout(10)->get($url);

        if (! $response->successful()) {
            $this->cancelOrderPreview();
            $this->dispatch('swal', icon: 'error', text: 'Gagal memuat data dari API.', title: 'Gagal');

            return;
        }

        $json = $response->json();

        if (($json['status'] ?? '') !== 'success' || empty($json['data'])) {
            $this->cancelOrderPreview();
            $this->dispatch('swal', icon: 'error', text: "Data PR tidak ditemukan di BSI untuk {$label} ini.", title: 'Gagal');

            return;
        }

        $this->orderPreviewData = collect($json['data'])
            ->map(fn ($item, $key) => array_merge($item, ['original_index' => $key]))
            ->all();

        $this->selectedOrderItems = array_keys($this->orderPreviewData);
        $this->showOrderPreview = true;
    }
}
