<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class DigitalSignature extends Component
{
    public $myModel;

    public bool $showModalShowSignature = false;

    public function mount()
    {
        $this->myModel = auth()->user();
    }

    public function removeSignature()
    {
        $this->myModel->deleteSignature();

        $this->showModalShowSignature = false;

        $this->dispatch(
            event: 'swal',
            icon: 'success',
            title: 'Berhasil',
            text: 'Tanda tangan berhasil dihapus.',
            redirect: [
                'url' => route('profile.edit'),
                'delay' => 2000,
            ]
        );
    }

    public function render()
    {
        return view('livewire.utils.digital-signature');
    }
}
