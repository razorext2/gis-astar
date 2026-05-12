<?php

/** Goal: Handle unassign and update PR from API, Caller: show.blade.php, Deps: SpkMain, PurchasingRequest, ProductionHistory */

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class UnassignPurchasingRequest extends Component
{
    use HandlesErrors;

    public ?string $id;

    public ?string $nomor_order = null;

    public array $previewData = [];

    public bool $showPreview = false;

    public function mount(string $id, ?string $nomorOrder = null): void
    {
        $this->id = $id;
        $this->nomor_order = $nomorOrder;
    }

    /**
     * Fetch data PR dari API berdasarkan nomor_order lalu tampilkan preview.
     */
    public function update(): void
    {
        $this->authorize('update', PurchasingRequest::class);

        if (empty($this->nomor_order)) {
            $this->dispatch('swal', icon: 'error', text: 'Nomor Order tidak ditemukan.', title: 'Gagal');

            return;
        }

        $this->runSafely(function () {
            $url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchPermintaanBeli&KeteranganDetail='.urlencode($this->nomor_order);

            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                $this->previewData = [];
                $this->showPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Gagal memuat data dari API.', title: 'Gagal');

                return;
            }

            $json = $response->json();

            if (($json['status'] ?? '') !== 'success' || empty($json['data'])) {
                $this->previewData = [];
                $this->showPreview = false;
                $this->dispatch('swal', icon: 'error', text: 'Data PR tidak ditemukan di BSI untuk nomor order ini.', title: 'Gagal');

                return;
            }

            $this->previewData = $json['data'];
            $this->showPreview = true;
        }, 'Gagal fetch data PR dari API.', [
            'user_id' => Auth::id(),
            'nomor_order' => $this->nomor_order,
        ]);
    }

    /**
     * Proses data preview: create record baru di tb_purchasing_request
     * dan merge nomor PR ke tb_spk tanpa menghapus data lama.
     */
    public function processUpdate(): void
    {
        $this->authorize('update', PurchasingRequest::class);

        if (empty($this->previewData)) {
            $this->dispatch('swal', icon: 'error', text: 'Tidak ada data untuk diproses.', title: 'Gagal');

            return;
        }

        $spk = SpkMain::with('production')
            ->findOrFail($this->id);

        $this->runSafely(function () use ($spk) {
            $grouped = collect($this->previewData)->groupBy('NomorPermintaanBeli');
            $newPrNumbers = $grouped->keys()->values()->toArray();

            // --- Cek duplikat: ambil data existing dari tb_purchasing_request ---
            $existingItems = PurchasingRequest::where('id_spk', $this->id)
                ->select(['nomor_purchasing_request', 'kode_item'])
                ->get();

            $existingKeys = $existingItems->map(fn ($row) => $row->nomor_purchasing_request.'|'.$row->kode_item)->toArray();

            // Filter hanya item baru yang belum ada di database
            $newItems = collect($this->previewData)->filter(function (array $item) use ($existingKeys) {
                $key = ($item['NomorPermintaanBeli'] ?? '').'|'.($item['KodeItem'] ?? '');

                return ! in_array($key, $existingKeys);
            })->values()->toArray();

            // Jika semua data sudah ada, return error
            if (empty($newItems)) {
                $this->dispatch('swal', icon: 'info', text: 'Semua data PR dari API sudah ada di database.', title: 'Info');

                return;
            }

            DB::transaction(function () use ($spk, $newPrNumbers, $newItems) {
                // --- Merge nomor PR ---
                $existingNumbers = $this->collectExistingPrNumbers($spk);
                $mergedNumbers = array_values(array_unique(array_merge($existingNumbers, $newPrNumbers)));

                if (count($mergedNumbers) === 1) {
                    $spk->update([
                        'nomor_purchasing_request' => $mergedNumbers[0],
                        'nomor_purchasing_request_json' => null,
                        'status' => $spk->status <= 2 ? 2 : $spk->status,
                        'purchasing_list_updated_by' => Auth::id(),
                    ]);
                } else {
                    $spk->update([
                        'nomor_purchasing_request' => null,
                        'nomor_purchasing_request_json' => $mergedNumbers,
                        'status' => $spk->status <= 2 ? 2 : $spk->status,
                        'purchasing_list_updated_by' => Auth::id(),
                    ]);
                }

                // --- Create hanya item baru di tb_purchasing_request ---
                foreach ($newItems as $item) {
                    PurchasingRequest::create([
                        'id_spk' => $this->id,
                        'nomor_purchasing_request' => $item['NomorPermintaanBeli'],
                        'kode_item' => $item['KodeItem'],
                        'nama_item' => $item['NamaItem'],
                        'qty' => $item['DummySisaStock'] ?? 0,
                        'satuan' => $item['Satuan'] ?? '-',
                        'lokasi_gudang_terima' => $item['RencanaGudangPenerimaan'] ?? '-',
                        'jumlah_item_dipesan' => $item['JumlahBarang'] ?? 0,
                        'keterangan' => $item['KeteranganDetail'] ?? '-',
                        'added_by' => Auth::id(),
                    ]);
                }

                // --- Update production history ---
                if ($spk->production) {
                    ProductionHistory::create([
                        'id_produksi' => $spk->production->id,
                        'judul' => 'Nomor PR diupdate via API.',
                        'keterangan' => 'Nomor PR diupdate oleh '.auth()->user()->name.' berdasarkan nomor order '.$this->nomor_order.'. ('.count($newItems).' item baru ditambahkan)',
                        'documentations' => [],
                        'status_produksi' => 1,
                        'status_validasi' => 1,
                    ]);
                }
            });

            $this->previewData = [];
            $this->showPreview = false;

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                text: 'Berhasil menambahkan '.count($newItems).' item PR baru.',
                title: 'Berhasil',
            );

            $this->redirect(route('purchasing-request.edit', $this->id), navigate: true);
        }, 'Gagal memproses update PR.', [
            'user_id' => Auth::id(),
            'spk_id' => $this->id,
            'nomor_order' => $this->nomor_order,
        ]);
    }

    /**
     * Batalkan preview dan reset state.
     */
    public function cancelPreview(): void
    {
        $this->previewData = [];
        $this->showPreview = false;
    }

    public function unassign(): void
    {
        $this->authorize('update', PurchasingRequest::class);

        $spk = SpkMain::with('production', 'purchasingRequests')
            ->findOrFail($this->id);

        $this->runSafely(function () use ($spk) {
            DB::transaction(function () use ($spk) {
                // update spk
                $spk->update([
                    'nomor_purchasing_request' => null,
                    'nomor_purchasing_request_json' => null,
                    'status' => 1,
                ]);

                // hapus purchasing request
                PurchasingRequest::where('id_spk', $this->id)->delete();

                // update production history
                ProductionHistory::create([
                    'id_produksi' => $spk->production->id,
                    'judul' => 'Nomor PR dibatalkan.',
                    'keterangan' => 'Nomor PR dibatalkan oleh '.auth()->user()->name.'. Menunggu Purchasing assign PR Baru.',
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);
            });

            // return success
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                text: 'Berhasil Unassign Purchasing Request.',
                title: 'Berhasil',
            );

            $this->redirect(route('purchasing-request.edit', $this->id), navigate: true);
        }, 'Gagal Unassign Purchasing Request.', [
            'user_id' => auth()->user()->id,
            'spk_id' => $this->id,
        ]);
    }

    /**
     * Kumpulkan semua nomor PR yang sudah ada di SPK.
     *
     * @return array<string>
     */
    private function collectExistingPrNumbers(SpkMain $spk): array
    {
        $existing = [];

        if (! empty($spk->nomor_purchasing_request)) {
            $existing[] = $spk->nomor_purchasing_request;
        }

        if (! empty($spk->nomor_purchasing_request_json) && is_array($spk->nomor_purchasing_request_json)) {
            $existing = array_merge($existing, $spk->nomor_purchasing_request_json);
        }

        return $existing;
    }

    public function render()
    {
        return view('livewire.handler.spk.unassign-purchasing-request');
    }
}
