<?php

/** Goal: RumahSakit Index Page, Caller: routes/web.php rs.index */

namespace App\Livewire\Handler\RumahSakit;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.handler.rumah-sakit.index');
    }
}
