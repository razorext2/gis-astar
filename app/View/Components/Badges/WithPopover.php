<?php

namespace App\View\Components\Badges;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WithPopover extends Component
{
    /**
     * Create a new component instance.
     */
    public $count;

    public function __construct(string $model, array $clause)
    {
        if (class_exists($model)) {
            $query = $model::query();

            // Terapkan kondisi `where` yang dikirim
            foreach ($clause as $column => $value) {
                $query->where($column, $value);
            }

            $this->count = $query->count();
        } else {
            $this->count = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badges.with-popover');
    }
}
