<?php

/** Goal: Manage SPK index tabs with server-side conditional rendering to prevent URL parameter conflicts, Caller: dashboard/spk/index.blade.php, Deps: Livewire\Component, Livewire\Attributes\Url */

namespace App\Livewire\Handler\Spk;

use Livewire\Attributes\Url;
use Livewire\Component;

class IndexTabs extends Component
{
    #[Url(as: 'tab')]
    public string $activeTab = 'all';

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.handler.spk.index-tabs');
    }
}
