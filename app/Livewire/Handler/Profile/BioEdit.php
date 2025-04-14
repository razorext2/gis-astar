<?php

namespace App\Livewire\Handler\Profile;

use App\Models\Pegawai;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BioEdit extends Component
{
    public Pegawai $pegawai;

    #[Validate('nullable|string|max:20')]
    public $bio;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai->where('kode_pegawai', auth()->user()->kode_pegawai)
            ->first();
    }

    public function updated()
    {
        $this->pegawai->update([
            'bio' => $this->bio,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.profile.bio-edit');
    }
}
