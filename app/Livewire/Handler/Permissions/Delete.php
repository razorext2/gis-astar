<?php

namespace App\Livewire\Handler\Permissions;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

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
        $query = Permission::find($this->id);

        if (!$query) {
            return abort(404);
        }

        try {
            $query->delete();

            $this->dispatch('swal', title: 'Berhasil', text: 'Data berhasil dihapus', icon: 'success');

            return $this->redirect(route('permissions.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error(now() . ': Error saat menghapus data perizinan ->' . $e->getMessage());
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.permissions.delete');
    }
}
