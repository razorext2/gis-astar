<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class Breadcrumb extends Component
{
    public function render()
    {
        $segments = request()->segments();
        $crumbs = [];
        $path = '';

        foreach ($segments as $segment) {
            $path .= '/' . $segment;
            array_push($crumbs, [
                'title' => ucfirst(str_replace('-', ' ', $segment)),
                'url' => url($path)
            ]);
        }

        return view('livewire.utils.breadcrumb', ['crumbs' => $crumbs]);
    }
}
