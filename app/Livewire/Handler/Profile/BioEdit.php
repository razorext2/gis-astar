<?php

namespace App\Livewire\Handler\Profile;

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BioEdit extends Component
{
    use HandlesErrors;

    public $pegawai = null;

    #[Validate('nullable|string|max:20')]
    public $bio;

    public function mount()
    {
        $this->bio = auth()->user()->bio ?? '';
    }

    public function updated()
    {
        $this->runSafely(function () {
            auth()->user()->update([
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
