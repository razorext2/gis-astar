<?php

namespace App\Livewire\Forms\Roles;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Post extends Form
{
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required')]
    public array $selectedPermissions = [];

    public function store()
    {
        try {
            DB::beginTransaction();

            // Buat role baru
            $role = Role::create(['name' => $this->name]);

            // Pastikan permission yang dikirim benar
            $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('id')->toArray();

            // Sync permission
            $role->syncPermissions($validPermissions);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(now() . ': Error saat menambah data perizinan ->' . $e->getMessage());
        }
    }

    public function update($role)
    {
        try {
            DB::beginTransaction();

            // simpan role name
            $role->name = $this->name;
            $role->save();

            // pastikan permission yang dikirim benar
            $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('id')->toArray();

            // sync permission
            $role->syncPermissions($validPermissions);

            // commit perubahan ke database
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
