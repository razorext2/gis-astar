<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HistoriesList extends Component
{
    use HandlesErrors;

    public ?string $id;

    public ?int $status_validasi = null;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function confirmProductionHistory($id)
    {
        $this->authorize('validate', ProductionHistory::class);

        $this->runSafely(function () use ($id) {
            $history = ProductionHistory::with('produksi')
                ->where('id', $id)
                ->first();

            DB::transaction(function () use ($history) {
                if ($history->status_produksi == 10 && $history->produksi->spk->is_using_company_driver == true) {
                    $history->produksi->spk->update([
                        'status' => 3,
                    ]);
                }

                $history->update([
                    'status_validasi' => 1,
                    'validated_by' => Auth::id(),
                    'validated_at' => now(),
                ]);

                $this->dispatch(
                    event: 'swal',
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Laporan produksi telah disetujui.'
                );
            });
        }, 'Gagal menyetujui laporan produksi.', [
            'form_input' => [
                'id' => $id,
            ],
            'user_id' => Auth::id(),
        ]);
    }

    public function rejectProductionHistory($id)
    {
        $this->authorize('validate', ProductionHistory::class);

        $this->runSafely(function () use ($id) {
            ProductionHistory::where('id', $id)->update([
                'status_validasi' => 2,
                'validated_by' => Auth::id(),
                'validated_at' => now(),
            ]);

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: 'Laporan produksi telah ditolak.'
            );
        }, 'Gagal menolak laporan produksi.', [
            'form_input' => [
                'id' => $id,
            ],
            'user_id' => Auth::id(),
        ]);
    }

    public function deleteProductionHistory($id)
    {
        $this->authorize('delete', ProductionHistory::class);

        $this->runSafely(function () use ($id) {
            ProductionHistory::where('id', $id)->delete();

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: 'Laporan produksi berhasil dihapus.',
            );
        });
    }

    public function queryString()
    {
        return [
            'status_validasi' => ['as' => 'sv'],
        ];
    }

    public function render()
    {
        $data = ProductionHistory::where('id_produksi', $this->id)
            ->when($this->status_validasi === null, fn ($query) => $query->whereIn('status_validasi', [0, 1]))
            ->when($this->status_validasi !== null, function ($query) {
                if ($this->status_validasi === 3) {
                    return $query->whereIn('status_validasi', [0, 1, 2]);
                }

                return $query->where('status_validasi', $this->status_validasi);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, pageName: 'histories');

        return view('livewire.handler.production-histories.histories-list',
            ['data' => $data]);
    }
}
