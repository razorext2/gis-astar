<?php

/** Goal: Display grouped technician points with optional checkbox selection, Caller: redeem.blade.php, Deps: TechnicianPoints */

namespace App\Livewire\Handler\Point\Technician;

use Livewire\Component;

class StepTwo extends Component
{
    public $results;

    public string $redeemMode = 'all';

    /** @var array<string> kode_pegawai yang dipilih */
    public array $selectedPegawai = [];

    public $no_vt = [];

    public $filteredKunjungan = [];

    public function mount(): void
    {
        // Mode 'all': auto-select semua pegawai
        if ($this->redeemMode === 'all' && $this->results) {
            $this->selectedPegawai = array_keys(
                $this->results instanceof \Illuminate\Support\Collection
                    ? $this->results->toArray()
                    : (array) $this->results
            );
        }
    }

    public function togglePegawai(string $kodePegawai): void
    {
        if (in_array($kodePegawai, $this->selectedPegawai)) {
            $this->selectedPegawai = array_values(array_diff($this->selectedPegawai, [$kodePegawai]));
        } else {
            $this->selectedPegawai[] = $kodePegawai;
        }

        $this->dispatch('pegawaiSelectionUpdated', selectedPegawai: $this->selectedPegawai);
    }

    public function selectAll(): void
    {
        $this->selectedPegawai = array_keys(
            $this->results instanceof \Illuminate\Support\Collection
                ? $this->results->toArray()
                : (array) $this->results
        );

        $this->dispatch('pegawaiSelectionUpdated', selectedPegawai: $this->selectedPegawai);
    }

    public function deselectAll(): void
    {
        $this->selectedPegawai = [];
        $this->dispatch('pegawaiSelectionUpdated', selectedPegawai: $this->selectedPegawai);
    }

    public function searchKunjungan(string $kode_pegawai): void
    {
        $input = $this->no_vt[$kode_pegawai] ?? '';

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
