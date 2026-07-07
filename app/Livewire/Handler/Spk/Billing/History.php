<?php

/** Goal: Component for displaying assigned billing histories under subfolder, Caller: update.blade.php, Deps: SpkMain, ReceivableHistory, Collection */

namespace App\Livewire\Handler\Spk\Billing;

use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class History extends Component
{
    public SpkMain $spk_data;

    public function mount(SpkMain $spkData): void
    {
        $this->spk_data = $spkData;
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
        return view('livewire.handler.spk.billing.history');
    }
}
