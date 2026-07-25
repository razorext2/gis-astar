<?php

namespace App\Livewire\Handler\Permissions;

use App\Livewire\Concerns\HandlesErrors;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Delete extends Component
{
    use HandlesErrors;

    public int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    public function delete(): void
    {
        $this->dispatch('confirmDelete', id: $this->id);
    }

    #[On('confirmDeleteAction.{id}')]
    public function confirmDeleteAction(): void
    {
        $query = Permission::find($this->id);

        if (! $query) {
            abort(404);
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

    public function render(): View
    {
        return view('livewire.handler.permissions.delete');
    }
}
