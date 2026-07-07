<?php

/** Goal: Parent component for SPK billing update under subfolder structure, Caller: Web routes / edit.blade.php, Deps: SpkMain, ReceivableHistory, DB, Auth */

namespace App\Livewire\Handler\Spk\Billing;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Update extends Component
{
    use HandlesErrors;

    public SpkMain $spk_data;

    public bool $showUnassignConfirm = false;

    public ?bool $status_nomor_tagihan = false;

    public function mount(string $id): void
    {
        $this->spk_data = SpkMain::with('invoice', 'receivableHistories')
            ->findOrFail($id);

        $this->status_nomor_tagihan = (bool) $this->spk_data->status_nomor_tagihan;
    }

    public function unassign(): void
    {
        $this->authorize('unassignNoTagihan', SpkMain::class);

        $this->showUnassignConfirm = false;
        $nomorTagihanLama = $this->spk_data->nomor_tagihan;

        $this->runSafely(function () use ($nomorTagihanLama) {
            DB::transaction(function () use ($nomorTagihanLama) {
                $updated = $this->spk_data->update([
                    'nomor_tagihan' => null,
                    'status_nomor_tagihan' => 0,
                    'status' => 3,
                    'updated_by' => Auth::id(),
                    'no_tagihan_updated_by' => Auth::id(),
                ]);

                if (! $updated) {
                    throw new \Exception('Gagal update status nomor tagihan.');
                }

                // Soft-delete semua history piutang — detail ikut terhapus via cascade di booted()
                $this->spk_data->receivableHistories()->delete();

                $this->spk_data->addHistory(
                    'Nomor SR penagihan di-unassign.',
                    Auth::user()->name.' telah meng-unassign nomor SR penagihan ('.$nomorTagihanLama.').',
                    Auth::id()
                );
            });

            $this->spk_data->refresh();
            $this->status_nomor_tagihan = false;

            $this->dispatch(event: 'swal', icon: 'success', title: 'Berhasil', text: 'Nomor tagihan berhasil di-unassign.');

            return $this->redirect(route('billing.edit', $this->spk_data->id), navigate: true);
        }, 'Gagal unassign nomor tagihan', [
            'id_spk' => $this->spk_data->id,
            'nomor_tagihan' => $nomorTagihanLama,
            'user_id' => Auth::id(),
        ]);
    }

    #[Computed]
    public function histories(): Collection
    {
        if (is_null($this->spk_data->nomor_tagihan)) {
            return collect();
        }

        return $this->spk_data->receivableHistories()
            ->with(['details', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing.update');
    }
}
