<?php

namespace App\View\Components\Drawer;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MobileMenu extends Component
{
    public ?array $iconMap = [];

    public ?array $drawerLinks = [];

    public function __construct()
    {
        $this->drawerLinks = config('navigation.links');
        $this->iconMap = config('navigation.icons');
    }

    public function render(): View|Closure|string
    {
        return view('components.drawer.mobile-menu');
    }
}
