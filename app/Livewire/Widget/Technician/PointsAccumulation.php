<?php

namespace App\Livewire\Widget\Technician;

use App\Models\TechnicianPoints;
use Livewire\Component;

class PointsAccumulation extends Component
{
    public $points;

    public function getPoints()
    {
        $this->points = TechnicianPoints::query()
            ->where('kode_pegawai', auth()->user()->kode_pegawai)
            ->where('is_redeemed', false)
            ->sum('point');

        return $this->points;
    }

    public function render()
    {
        return view('livewire.widget.technician.points-accumulation', [
            'points' => $this->getPoints()
        ]);
    }
}
