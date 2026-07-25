<?php

namespace App\Livewire\Handler\Roles;

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Delete extends Component
{
    use HandlesErrors;

    public int $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function delete()
    {
        $this->dispatch('confirmDelete', id: $this->id);
    }

    #[On('confirmDeleteAction')]
    public function confirmDeleteAction()
    {
        $query = Role::find($this->id);

        if (! $query) {
            return abort(404);
        }

        return $this->runSafely(function () use ($query) {
            $query->delete();

            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil menghapus data role', icon: 'success');

            return $this->redirect(route('roles.index'), navigate: true);
        }, 'Gagal menghapus data role.', [
            'action' => 'delete role',
            'role_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.roles.delete');
    }
}
