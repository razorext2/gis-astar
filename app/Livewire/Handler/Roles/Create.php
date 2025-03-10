<?php

namespace App\Livewire\Handler\Roles;

use App\Livewire\Forms\Roles\Post;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    public Post $form;
    public array $permissions = [];
    public bool $selectAll = false;

    public function mount()
    {
        // Ambil permission sebagai array asosiatif (id => name)
        $this->permissions = Permission::pluck('name', 'id')->toArray();
    }

    public function toggleSelectAll()
    {
        // Gabungkan dua fungsi menjadi satu
        $this->form->selectedPermissions = $this->selectAll ? array_keys($this->permissions) : [];
    }

    public function updatedSelectedPermissions()
    {
        // Jika semua dipilih, update "Select All"
        $this->selectAll = count($this->selectedPermissions) === count($this->permissions);
    }

    public function save()
    {
        try {
            // Validasi form
            $this->form->validate();

            // Panggil method store di form Post
            $this->form->store();

            // Panggil event swal, tampilkan pesan
            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil menambah data role', icon: 'success');

            // Redirect
            $this->redirect(route('roles.index'), navigate: true);
        } catch (\Exception $e) {
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.roles.create');
    }
}
