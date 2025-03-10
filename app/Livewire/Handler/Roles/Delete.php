<?php

namespace App\Livewire\Handler\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Delete extends Component
{
    public int $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        $this->dispatch('confirmDelete', id: $this->id);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDeleteAction()
    {
        $query = Role::find($this->id);

        if (!$query) {
            return $this->dispatch('swal', title: 'Gagal', text: 'Data tidak ditemukan', icon: 'error');
        }

        $query->delete();

        $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil menghapus data role', icon: 'success');

        return $this->redirect(route('roles.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.handler.roles.delete');
    }
}
