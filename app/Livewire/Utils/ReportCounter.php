<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class ReportCounter extends Component
{
    public string $model;
    public string $params;

    public function render()
    {
        return view(
            'livewire.utils.report-counter',
            [
                'count' => $this->model::where('status', $this->params)->count()
            ]
        );
    }
}
