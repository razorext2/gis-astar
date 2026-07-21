<?php

namespace App\Livewire\Handler\Roles;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Roles\Post;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Update extends Component
{
    use HandlesErrors;

    public Post $form;

    public $permissions;

    public ?Role $role = null; // Ubah menjadi nullable untuk keamanan

    public array $rolePermissions = [];

    public bool $selectAll = false;

    public string $searchPermission = '';

    public function mount(Role|int|string $role)
    {
        $this->role = $role instanceof Role ? $role : Role::find($role);

        // Jika role tidak ditemukan, redirect atau tampilkan error
        if (! $this->role) {
            abort(404);
        }

        $this->form->name = $this->role->name;

        $this->rolePermissions = $this->role->permissions()->pluck('id')->all();
        $this->form->selectedPermissions = $this->rolePermissions;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // Jika Select All dicentang, pilih semua permissions
            $this->form->selectedPermissions = $this->permissions->pluck('id')->all();
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
        $this->form->validate();

        $this->runSafely(function () {
            // panggil method update
            $this->form->update($this->role);

            // panggil event swal untuk menampilkan pesan
            $this->dispatch('swal', title: 'Berhasil', text: 'Berhasil mengubah data role', icon: 'success');

            // redirect
            $this->redirect(route('roles.index'), navigate: true);
        }, 'Gagal mengubah data role.', [
            'action' => 'update role',
            'role_id' => $this->role->id ?? null,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        $permissionsQuery = Permission::select('id', 'name')
            ->where('name', 'like', '%'.$this->searchPermission.'%')
            ->get();

        $this->permissions = $permissionsQuery;

        $groupedPermissions = $permissionsQuery->groupBy(fn ($permission) => explode('-', $permission->name)[0]);

        return view('livewire.handler.roles.update', compact('groupedPermissions'));
    }
}
