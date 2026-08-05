<?php

/** Goal: Pasien Index Page, embed PowerGrid table, Caller: routes/web.php */

namespace App\Livewire\Handler\Pasien;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.handler.pasien.index');
    }
}
