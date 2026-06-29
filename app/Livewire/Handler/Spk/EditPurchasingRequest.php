<?php

/** Goal: Handle edit PR — fetch new PR + edit/delete existing PR items, Caller: edit-purchasing-request.blade.php, Deps: SpkMain, PurchasingRequest, ProductionHistory */

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\FetchesPurchasingRequest;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditPurchasingRequest extends Component
{
    use FetchesPurchasingRequest { fetchPR as protected baseFetchPR; }
    use HandlesErrors;

    // ── Existing PR (dari database) ──

    /** @var array<int, array{id: string, nomor_purchasing_request: string, kode_item: string, nama_item: string, qty: int, satuan: string, lokasi_gudang_terima: string, jumlah_item_dipesan: int, keterangan: string}> */
    public array $existingPrItems = [];

    public function mount(string $id, ?string $nomorOrder = null): void
    {
        $this->spk_id = $id;

        if ($nomorOrder) {
            $this->nomor_order = $nomorOrder;
        }

        $this->loadExistingPr();
    }

    /**
     * Override fetchPR untuk exclude SPK ini dari pengecekan duplikat.
     */
    public function fetchPR(?string $excludeSpkId = null): mixed
    {
        return $this->baseFetchPR($this->spk_id);
    }

    /**
     * Load data PR yang sudah di-assign dari database.
     */
    public function loadExistingPr(): void
    {
        $this->existingPrItems = PurchasingRequest::where('id_spk', $this->spk_id)
            ->select(['id', 'nomor_purchasing_request', 'kode_item', 'nama_item', 'qty', 'satuan', 'lokasi_gudang_terima', 'jumlah_item_dipesan', 'keterangan'])
            ->get()
            ->toArray();
    }

    /**
     * Hapus satu item PR existing dari database (soft delete).
     */
    public function deleteExistingItem(string $id): void
    {
        $this->authorize('update', PurchasingRequest::class);

        $item = PurchasingRequest::where('id_spk', $this->spk_id)->findOrFail($id);

        $this->runSafely(function () use ($item) {
            $item->delete();
            $this->loadExistingPr();

            $this->dispatch('swal', icon: 'success', text: "Item {$item->kode_item} berhasil dihapus.", title: 'Berhasil');
        }, 'Gagal menghapus item PR.');
    }

    /**
     * Simpan semua perubahan: update existing + insert new PRs.
     */
    public function saveChanges(): void
    {
        $this->authorize('update', PurchasingRequest::class);

        $spk = SpkMain::with('production')
            ->findOrFail($this->spk_id);

        $hasNewPr = ! empty($this->data_pr);
        $hasExistingChanges = ! empty($this->existingPrItems);

        if (! $hasNewPr && ! $hasExistingChanges) {
            $this->dispatch('swal', icon: 'error', text: 'Tidak ada perubahan untuk disimpan.', title: 'Gagal');

            return;
        }

        $this->runSafely(function () use ($spk, $hasNewPr) {
            DB::transaction(function () use ($spk, $hasNewPr) {
                // 1. Update existing PR items
                foreach ($this->existingPrItems as $item) {
                    PurchasingRequest::where('id', $item['id'])
                        ->where('id_spk', $this->spk_id)
                        ->update([
                            'nama_item' => $item['nama_item'],
                            'qty' => $item['qty'] ?? 0,
                            'satuan' => $item['satuan'] ?? '-',
                            'lokasi_gudang_terima' => $item['lokasi_gudang_terima'] ?? '-',
                            'jumlah_item_dipesan' => $item['jumlah_item_dipesan'] ?? 0,
                            'keterangan' => $item['keterangan'] ?? '-',
                        ]);
                }

                // 2. Insert new PRs
                if ($hasNewPr) {
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

                    // Update nomor PR di SpkMain jika ada PR baru
                    $allNomorPr = collect($this->existingPrItems)
                        ->pluck('nomor_purchasing_request')
                        ->merge(collect($this->data_pr)->pluck('nomor_pr'))
                        ->unique()
                        ->values();

                    $field = $allNomorPr->count() === 1
                        ? 'nomor_purchasing_request'
                        : 'nomor_purchasing_request_json';

                    $otherField = $field === 'nomor_purchasing_request'
                        ? 'nomor_purchasing_request_json'
                        : 'nomor_purchasing_request';

                    $spk->update([
                        $field => $allNomorPr->count() === 1
                            ? $allNomorPr->first()
                            : $allNomorPr->toArray(),
                        $otherField => null,
                        'purchasing_list_updated_by' => Auth::id(),
                    ]);
                }

                // 3. Log production history
                ProductionHistory::create([
                    'id_produksi' => $spk->production->id,
                    'judul' => 'Data PR diperbarui.',
                    'keterangan' => 'Data Purchasing Request diperbarui oleh ' . Auth::user()->name . '.',
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);
            });

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                text: 'Data berhasil disimpan.',
                title: 'Berhasil',
                redirect: [
                    'url' => route('purchasing-request.show', $this->spk_id),
                    'delay' => 2000,
                ]);
        }, 'Gagal menyimpan perubahan PR.', [
            'form_input' => $this->all(),
            'user_id' => Auth::id(),
        ]);
    }

    public function render(): View
    {
        return view('livewire.handler.spk.edit-purchasing-request');
    }
}
