<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UnassignPurchasingRequest extends Component
{
    use HandlesErrors;

    public ?string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function unassign()
    {
        $this->authorize('update', \App\Models\Spk\PurchasingRequest::class);

        $spk = \App\Models\Spk\SpkMain::with('production', 'purchasingRequests')
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
                \App\Models\Spk\PurchasingRequest::where('id_spk', $this->id)->delete();

                // update production history
                \App\Models\Spk\ProductionHistory::create([
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
