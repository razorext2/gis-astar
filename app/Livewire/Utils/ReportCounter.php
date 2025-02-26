<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class ReportCounter extends Component
{
    public string $model;

    public function render()
    {
        return view(
            'livewire.utils.report-counter',
            [
                'count' => $this->model::count()
            ]
        );
    }
}
