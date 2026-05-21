<?php

/** Goal: Generate and render dynamic breadcrumbs with truncated segment titles, Caller: layouts/app, Deps: Livewire\Component */

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
            $path .= '/'.$segment;
            $title = ucfirst(str_replace('-', ' ', $segment));
            if (mb_strlen($title) > 10) {
                $title = mb_substr($title, 0, 10).'...';
            }
            array_push($crumbs, [
                'title' => $title,
                'url' => url($path),
            ]);
        }

        return view('livewire.utils.breadcrumb', ['crumbs' => $crumbs]);
    }
}
