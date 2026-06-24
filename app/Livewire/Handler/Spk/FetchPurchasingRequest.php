<?php

/** Goal: Handle fetch & assign PR by nomor PR, nomor order or nomor PO, Caller: fetch-purchasing-request.blade.php, Deps: SpkMain, PurchasingRequest, ProductionHistory */

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

class FetchPurchasingRequest extends Component
{
    use FetchesPurchasingRequest;
    use HandlesErrors;

    public function mount(string $id, ?string $nomorOrder = null): void
    {
        $this->spk_id = $id;

        if ($nomorOrder) {
            $this->nomor_order = $nomorOrder;
        }
    }

    public function assign(): void
    {
        $this->authorize('update', PurchasingRequest::class);

        $data = collect($this->data_pr);

        if ($data->isEmpty()) {
            $this->dispatch('swal', icon: 'error', text: 'Tambah minimal 1 PR untuk di assign.', title: 'Gagal');

            return;
        }

        $spk = SpkMain::with('production')
            ->findOrFail($this->spk_id);

        if ($spk->status_approval !== 1) {
            $this->dispatch('swal', icon: 'error', text: 'SPK belum di approve.', title: 'Gagal');

            return;
        }

        $field = $data->count() === 1
            ? 'nomor_purchasing_request'
            : 'nomor_purchasing_request_json';

        $this->runSafely(function () use ($spk, $field, $data) {
            $nomorPrCollection = $data->pluck('nomor_pr');

            $nomor_pr = $nomorPrCollection->count() === 1
                ? $nomorPrCollection->first()
                : $nomorPrCollection->values()->toArray();

            DB::transaction(function () use ($spk, $field, $nomor_pr) {
                $spk->update([
                    $field => $nomor_pr,
                    'status' => max($spk->status, 2),
                    'purchasing_list_updated_by' => Auth::id(),
                ]);

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

                ProductionHistory::create([
                    'id_produksi' => $spk->production->id,
                    'judul' => 'Nomor PR sudah diupdate.',
                    'keterangan' => 'Menunggu team produksi untuk update progress pengerjaan...',
                    'documentations' => [],
                    'status_produksi' => 1,
                    'status_validasi' => 1,
                ]);
            });

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

    public function render(): View
    {
        return view('livewire.handler.spk.fetch-purchasing-request');
    }
}
