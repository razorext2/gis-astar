<?php

/** Goal: Modal bulk approve laporan produksi dengan checklist selection, Caller: production-tabs.blade.php, Deps: ProductionHistory, HandlesErrors */

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class BulkApproveHistories extends Component
{
    use HandlesErrors;

    public bool $showModal = false;

    public ?string $productionId = null;

    /** @var array<string> */
    public array $selectedIds = [];

    #[On('open-bulk-approve-modal')]
    public function openModal(string $productionId): void
    {
        $this->authorize('validate', ProductionHistory::class);

        $this->productionId = $productionId;
        $this->selectedIds = [];
        $this->showModal = true;
    }

    #[Computed]
    public function histories(): Collection
    {
        if (! $this->productionId) {
            return new Collection();
        }

        return ProductionHistory::where('id_produksi', $this->productionId)
            ->where('status_validasi', 0)
            ->with(['addedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function toggleSelectAll(): void
    {
        $allIds = $this->histories->pluck('id')->map(fn ($id) => (string) $id)->all();

        if (count($this->selectedIds) === count($allIds)) {
            $this->selectedIds = [];
        } else {
            $this->selectedIds = $allIds;
        }
    }

    public function approveSelected(): void
    {
        $this->authorize('validate', ProductionHistory::class);

        if (empty($this->selectedIds)) {
            return;
        }

        $selectedIds = $this->selectedIds;

        $this->runSafely(function () use ($selectedIds) {
            DB::transaction(function () use ($selectedIds) {
                $histories = ProductionHistory::with('produksi.spk')
                    ->whereIn('id', $selectedIds)
                    ->where('status_validasi', 0)
                    ->get();

                foreach ($histories as $history) {
                    if ($history->status_produksi == 10 && $history->produksi?->spk?->is_using_company_driver) {
                        $history->produksi->spk->update(['status' => 3]);
                    }

                    $history->update([
                        'status_validasi' => 1,
                        'validated_by'    => Auth::id(),
                        'validated_at'    => now(),
                    ]);
                }
            });

            $count = count($selectedIds);
            $this->selectedIds = [];
            $this->showModal = false;

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: "{$count} laporan produksi telah disetujui."
            );
        }, 'Gagal menyetujui laporan produksi.', [
            'selected_ids' => $selectedIds,
            'user_id'      => Auth::id(),
        ]);
    }

    public function render(): View
    {
        return view('livewire.handler.production-histories.bulk-approve-histories');
    }
}
