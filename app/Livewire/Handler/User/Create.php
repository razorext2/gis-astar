<?php

namespace App\Livewire\Handler\User;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    use HandlesErrors;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public $selected_roles = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:password_confirmation',
            'selected_roles' => 'required|array|min:1',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama lengkap wajib diisi.',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email ini sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.same' => 'Konfirmasi password tidak cocok.',
        'selected_roles.required' => 'Minimal pilih satu role.',
        'selected_roles.min' => 'Minimal pilih satu role.',
    ];

    public function save()
    {
        $this->validate();

        return $this->runSafely(function () {
            DB::transaction(function () {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'is_active' => true,
                ]);

                $user->assignRole($this->selected_roles);
            });

            return redirect()->route('users.index')
                ->with('status', 'Berhasil menambah data user: '.$this->name);
        }, 'Gagal menambah data user', [
            'action' => 'create user',
            'email' => $this->email,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.user.create', [
            'list_roles' => Role::orderBy('name', 'asc')->get(),
        ]);
    }
}
