<?php

/** Goal: Shared computed histories query untuk Billing Livewire components, Caller: Update, History, Deps: ReceivableHistory */

namespace App\Livewire\Concerns;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

trait HasReceivableHistories
{
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
}
