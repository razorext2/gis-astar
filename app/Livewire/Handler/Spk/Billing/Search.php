<?php

/** Goal: Form component for searching BSI billing data under subfolder, Caller: update.blade.php, Deps: SpkMain, Billing (Form) */

namespace App\Livewire\Handler\Spk\Billing;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Billing;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    use HandlesErrors;

    public Billing $form;

    public SpkMain $spk_data;

    public function mount(SpkMain $spkData): void
    {
        $this->spk_data = $spkData;
        $this->form->tipe_tagihan = $spkData->tipe_tagihan;
    }

    public function search(): void
    {
        $this->form->validate();

        $tipeTagihan = config('spk-config.spk_tipe_tagihan')[$this->form->tipe_tagihan];

        try {
            $mainData = $this->form->fetchApi($tipeTagihan['api'], $this->form->nomor_tagihan);
            $sisaItems = $this->form->fetchSisa($tipeTagihan['api_sisa'], $this->form->nomor_tagihan);

            $this->dispatch('bsi-data-fetched',
                mainData: $mainData,
                sisaItems: $sisaItems,
                tipeTagihan: $this->form->tipe_tagihan,
                nomorTagihan: $this->form->nomor_tagihan
            );
        } catch (\Throwable $e) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: $e->getMessage());
        }
    }

    public function clearSearch(): void
    {
        $this->form->nomor_tagihan = null;
        $this->dispatch('bsi-data-cleared');
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing.search');
    }
}
