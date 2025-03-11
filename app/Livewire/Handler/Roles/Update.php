<?php

namespace App\Livewire\Handler\Roles;

use App\Livewire\Forms\Roles\Post;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Update extends Component
{
    public Post $form;
    public array $permissions = [];
    public ?Role $role = null; // Ubah menjadi nullable untuk keamanan
    public array $rolePermissions = [];
    public bool $selectAll = false;

    public function mount($id)
    {
        $this->role = Role::find($id);

        // Jika role tidak ditemukan, redirect atau tampilkan error
        if (!$this->role) {
            abort(404);
        }

        $this->form->name = $this->role->name;

        $this->rolePermissions = $this->role->permissions()->pluck('id')->all();
        $this->form->selectedPermissions = $this->rolePermissions;

        // Ambil permission sebagai array asosiatif (id => name)
        $this->permissions = Permission::pluck('name', 'id')->toArray();
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // Jika Select All dicentang, pilih semua permissions
            $this->form->selectedPermissions = array_keys($this->permissions);
        } else {
            // Jika Select All di-uncheck, kembalikan ke data awal
            $this->form->selectedPermissions = $this->rolePermissions;
        }
    }

    public function updatedFormSelectedPermissions()
    {
        // Cek apakah semua permissions dipilih
        $this->selectAll = count($this->form->selectedPermissions) === count($this->permissions);
    }

    public function save()
    {
        try {
            // validasi form
            $this->form->validate();

            // panggil method update
            $this->form->update($this->role);

            // panggil event swal untuk menampilkan pesan
            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil mengubah data role', icon: 'success');

            // redirect
            $this->redirect(route('roles.index'), navigate: true);
        } catch (\Exception $e) {
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.roles.update');
    }
}
