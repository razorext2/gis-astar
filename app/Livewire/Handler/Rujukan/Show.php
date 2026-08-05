<?php

/** Goal: Halaman detail rujukan + peta rute Leaflet, Caller: rujukan.show */

namespace App\Livewire\Handler\Rujukan;

use App\Models\Rujukan;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Rujukan $rujukan;

    public function mount(Rujukan $rujukan): void
    {
        $this->rujukan = $rujukan->load([
            'pasien',
            'rumahSakit',
            'user',
            'detailRujukan.rute.titikRute',
            'riwayat.diubahOleh',
        ]);
    }

    public function render(): View
    {
        return view('livewire.handler.rujukan.show');
    }
}
