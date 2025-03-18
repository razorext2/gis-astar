<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class InspireComponent extends Component
{
    public $quote;
    public function render()
    {
        Artisan::call('inspire');
        $this->quote = Artisan::output();

        return view('livewire.inspire-component');
    }
}
