<?php

namespace App\Livewire\Handler\Point;

use App\Models\TechnicianPoints;
use Livewire\Component;

class Index extends Component
{
    public $points;

    public function mount()
    {
        $this->points = TechnicianPoints::all()
            ->where('kode_pegawai', auth()->user()->kode_pegawai)
            ->sortByDesc('created_at');
    }

    public function render()
    {
        return view('livewire.handler.point.index');
    }
}
