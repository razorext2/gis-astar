<?php

/** Goal: Halaman detail rujukan + peta rute Leaflet, Caller: rujukan.show */

namespace App\Livewire\Handler\Rujukan;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Rujukan;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    use HandlesErrors;

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

    public function delete(): void
    {
        $this->runSafely(function () {
            $noRujukan = $this->rujukan->no_rujukan;
            $this->rujukan->delete();

            $this->dispatch('swal', title: 'Berhasil', text: "Data rujukan {$noRujukan} berhasil dihapus.", icon: 'success');
            $this->redirect(route('riwayat.index'), navigate: true);
        }, 'Gagal menghapus data rujukan', ['rujukan_id' => $this->rujukan->id_rujukan]);
    }

    public function render(): View
    {
        return view('livewire.handler.rujukan.show');
    }
}
