<?php

namespace App\Livewire\Handler\Point\Technician;

use Livewire\Component;

class StepTwo extends Component
{
    public $results;

    public $no_vt = [];

    public $filteredKunjungan = [];

    public function searchKunjungan($kode_pegawai)
    {
        $input = $this->no_vt[$kode_pegawai];

        $filtered = $this->results->get($kode_pegawai, collect())
            ->filter(fn ($item) => stripos($item->from_vt, $input) !== false)
            ->values();

        $this->filteredKunjungan[$kode_pegawai] = $filtered;
    }

    public function render()
    {
        return view('livewire.handler.point.technician.step-two');
    }
}
