<?php

namespace App\Livewire\Handler\Spk;

use App\Models\Spk\SpkHistory;
use Livewire\Component;
use Livewire\WithPagination;

class SpkHistories extends Component
{
    use WithPagination;

    public ?string $id;

    public ?bool $showRiwayatSpk = false;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $data = SpkHistory::with('spk')
            ->where('spk_id', $this->id)
            ->latest()
            ->paginate(perPage: 5, pageName: 'spk-histories');

        return view('livewire.handler.spk.spk-histories', [
            'data' => $data,
        ]);
    }
}
