<?php

namespace App\Livewire\Handler\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public User $user;
    public $name;
    public $email;
    public $is_active;
    public $deactivation_reason;
    public $password;
    public $password_confirmation;
    public $selected_roles = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->deactivation_reason = $user->deactivation_reason;
        $this->selected_roles = $user->roles->pluck('name')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:8|same:password_confirmation',
            'selected_roles' => 'required|array|min:1',
            'is_active' => 'required|boolean',
            'deactivation_reason' => 'required_if:is_active,0|nullable|string|max:255',
        ];
    }

    protected $messages = [
        'deactivation_reason.required_if' => 'Alasan nonaktif wajib diisi jika status diatur ke Tidak Aktif.',
        'selected_roles.required' => 'Minimal pilih satu role.',
        'password.same' => 'Konfirmasi password tidak cocok.',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ];

        if (!$this->is_active) {
            $data['deactivation_at'] = now();
            $data['deactivation_reason'] = $this->deactivation_reason;
            
            // Hapus session jika user dinonaktifkan
            DB::table('sessions')->where('user_id', $this->user->id)->delete();
        } else {
            $data['deactivation_reason'] = null;
            $data['deactivation_at'] = null;
        }

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);
        $this->user->syncRoles($this->selected_roles);

        return redirect()->route('users.index')
            ->with('status', 'Berhasil memperbarui data user: ' . $this->user->name);
    }

    public function render()
    {
        return view('livewire.handler.user.edit', [
            'list_roles' => Role::orderBy('name', 'asc')->get(),
        ]);
    }
}
