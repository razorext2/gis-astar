<?php

namespace App\Livewire\Handler\Profile;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pegawai;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BioEdit extends Component
{
    use HandlesErrors;

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
        // Validasi berjalan otomatis untuk #[Validate] property di Livewire 3 sebelum fungsi ini dijalankan
        $this->runSafely(function () {
            $this->pegawai->update([
                'bio' => $this->bio,
            ]);
        }, 'Gagal memperbarui bio.', [
            'action' => 'update profile bio',
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.profile.bio-edit');
    }
}
