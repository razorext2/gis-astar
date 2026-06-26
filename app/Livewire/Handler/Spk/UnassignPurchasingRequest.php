<?php

/** Goal: Handle unassign PR and show edit link, Caller: show.blade.php, Deps: SpkMain, PurchasingRequest, ProductionHistory */

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use App\Models\Spk\PurchasingRequest;
use App\Models\Spk\SpkMain;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UnassignPurchasingRequest extends Component
{
    use HandlesErrors;

    public ?string $id;

    public ?string $nomor_order = null;

    public function mount(string $id, ?string $nomorOrder = null): void
    {
        $this->id = $id;
        $this->nomor_order = $nomorOrder;
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

    public function render()
    {
        return view('livewire.handler.spk.unassign-purchasing-request');
    }
}
