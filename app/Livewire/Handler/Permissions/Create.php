<?php

namespace App\Livewire\Handler\Permissions;

use App\Livewire\Forms\Permissions\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public Post $form;

    public function addField()
    {
        $this->form->name[] = '';
    }

    public function removeField($index)
    {
        if (count($this->form->name) > 1) {
            unset($this->form->name[$index]);
            $this->form->name = array_values($this->form->name);
        }
    }

    public function save()
    {
        try {
            // validasi form
            $this->form->validate();

            // define $data = array name
            $data = $this->form->name;

            // cek jika value tiap array itu berbeda
            if (count(array_unique($data)) !== count($data)) {
                return $this->dispatch('swal', title: 'Gagal', text: 'Tidak boleh ada nama yang sama', icon: 'error');
            }

            // panggil method store di form Post
            $this->form->store();

            // panggil event swal, tampilkan pesan
            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil menambah data perizinan', icon: 'success');

            // redirect
            $this->redirect(route('permissions.index'), navigate: true);
        } catch (\Exception $e) {
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.permissions.create');
    }
}
