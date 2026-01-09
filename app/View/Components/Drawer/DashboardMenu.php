<?php

namespace App\View\Components\Drawer;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardMenu extends Component
{
    public ?array $icons = [];

    public ?array $links = [];

    public function __construct()
    {
        $this->icons = config('navigation.icons');
        $this->links = config('navigation.links');
    }

    public function render(): View|Closure|string
    {
        return view('components.drawer.dashboard-menu');
    }
}
