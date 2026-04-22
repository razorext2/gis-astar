<?php

namespace App\Livewire\Handler\Permissions;

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

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

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDeleteAction()
    {
        $query = Permission::find($this->id);

        if (! $query) {
            return abort(404);
        }

        $this->runSafely(function () use ($query) {
            $query->delete();

            $this->dispatch('swal', title: 'Berhasil', text: 'Data berhasil dihapus', icon: 'success');

            $this->redirect(route('permissions.index'), navigate: true);
        }, 'Gagal menghapus data perizinan.', [
            'action' => 'delete permission',
            'permission_id' => $this->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.permissions.delete');
    }
}
