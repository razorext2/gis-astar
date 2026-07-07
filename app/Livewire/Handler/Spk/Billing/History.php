<?php

/** Goal: Component for displaying assigned billing histories under subfolder, Caller: update.blade.php, Deps: SpkMain, ReceivableHistory, Collection */

namespace App\Livewire\Handler\Spk\Billing;

use App\Livewire\Concerns\HasReceivableHistories;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class History extends Component
{
    use HasReceivableHistories;

    public SpkMain $spk_data;

    public function mount(SpkMain $spkData): void
    {
        $this->spk_data = $spkData;
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing.history');
    }
}
