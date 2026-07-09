<?php

namespace App\Livewire\Handler\Permissions;

use App\Livewire\Concerns\HandlesErrors;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

/** Goal: Handle updating permission model and show its roles, Caller: routes/web.php, Deps: Spatie\Permission\Models\Permission */
class Update extends Component
{
    use HandlesErrors;

    #[Validate('required|string|min:5|max:30')]
    public string $name;

    public string $guard_name;

    public ?Permission $permission = null;

    public function mount($id)
    {
        $this->permission = Permission::with('roles')->find($id);

        if (! $this->permission) {
            return abort(404);
        }

        $this->name = $this->permission->name;
        $this->guard_name = $this->permission->guard_name;
    }

    public function save()
    {
        $this->validate();

        $this->runSafely(function () {
            $this->permission->name = $this->name;

            $this->permission->save();

            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil mengubah data perizinan', icon: 'success');

            $this->redirect(route('permissions.index'), navigate: true);
        }, 'Gagal mengubah data perizinan.', [
            'action' => 'update permission',
            'permission_id' => $this->permission->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.permissions.update');
    }
}
