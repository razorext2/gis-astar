<?php

/** Goal: Rujukan Index Page, embed PowerGrid, Caller: rujukan.index */

namespace App\Livewire\Handler\Rujukan;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.handler.rujukan.index');
    }
}
