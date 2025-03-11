<?php

namespace App\Livewire\Handler\Permissions;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Update extends Component
{
    #[Validate('required|string|min:5|max:30')]
    public string $name;
    public string $guard_name;
    public ?Permission $permission = null;

    public function mount($id)
    {
        $this->permission = Permission::find($id);

        if (!$this->permission) {
            return abort(404);
        }

        $this->name = $this->permission->name;
        $this->guard_name = $this->permission->guard_name;
    }

    public function save()
    {
        $this->validate();

        try {
            $this->permission->name = $this->name;

            $this->permission->save();

            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil mengubah data perizinan', icon: 'success');

            $this->redirect(route('permissions.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error(now() . ': Error saat mengubah data perizinan ->' . $e->getMessage());
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.permissions.update');
    }
}
