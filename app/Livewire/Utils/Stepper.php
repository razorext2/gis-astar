<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class Stepper extends Component
{
    public $step;

    public function render()
    {
        return view('livewire.utils.stepper');
    }
}
