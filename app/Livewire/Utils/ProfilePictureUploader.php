<?php

namespace App\Livewire\Utils;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePictureUploader extends Component
{
    use WithFileUploads;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public function save()
    {
        $this->validate();

        $this->photo->storeAs('public/profile-pictures', 'avatar-' . Auth::id() . '.' . $this->photo->extension());

        User::find(Auth::id())->update([
            'profile_pic' => 'avatar-' . Auth::id() . '.' . $this->photo->extension()
        ]);

        $this->dispatch('swal', title: 'Profile Picture Updated', text: 'Your profile picture has been updated.', icon: 'success');

        $this->redirect(route('profile.edit'));
    }

    public function render()
    {
        return view('livewire.utils.profile-picture-uploader');
    }
}
