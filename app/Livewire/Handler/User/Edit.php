<?php

/** Goal: Edit user account, Caller: Admin User Management, Deps: User Model, Role Model, SpkMain Model */

namespace App\Livewire\Handler\User;

use App\Jobs\TransferSpkOwnershipJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    use HandlesErrors;

    public User $user;

    public $name;

    public $email;

    public $is_active;

    public $deactivation_reason;

    public $password;

    public $password_confirmation;

    public $selected_roles = [];

    public $spk_count = 0;

    public $transfer_user_id;

    public $transfer_search = '';

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->deactivation_reason = $user->deactivation_reason;
        $this->selected_roles = $user->roles->pluck('name')->toArray();
        $this->spk_count = $user->spks()->count();
    }

    protected function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|min:8|same:password_confirmation',
            'selected_roles' => 'required|array|min:1',
            'is_active' => 'required|boolean',
            'deactivation_reason' => 'required_if:is_active,0|nullable|string|max:255',
        ];

        if (! $this->is_active && $this->spk_count > 0) {
            $rules['transfer_user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }

    protected $messages = [
        'deactivation_reason.required_if' => 'Alasan nonaktif wajib diisi jika status diatur ke Tidak Aktif.',
        'selected_roles.required' => 'Minimal pilih satu role.',
        'password.same' => 'Konfirmasi password tidak cocok.',
        'transfer_user_id.required' => 'Penerima pengalihan data SPK wajib dipilih.',
    ];

    public function getEligibleRoles(): array
    {
        $roles = $this->user->roles->pluck('name')->toArray();

        if (count($roles) > 1) {
            $filtered = array_values(array_filter(
                $roles,
                fn ($role) => ! in_array(strtolower($role), ['employee', 'admin'])
            ));

            if (! empty($filtered)) {
                return $filtered;
            }
        }

        return $roles;
    }

    public function selectTransferUser(int $userId): void
    {
        $this->transfer_user_id = $userId;
    }

    public function clearTransferUser(): void
    {
        $this->transfer_user_id = null;
        $this->transfer_search = '';
    }

    public function save(): mixed
    {
        $this->validate();

        return $this->runSafely(function () {
            DB::transaction(function () {
                $data = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'is_active' => $this->is_active,
                ];

                if (! $this->is_active) {
                    $data['deactivation_at'] = now();
                    $data['deactivation_reason'] = $this->deactivation_reason;

                    // Hapus session jika user dinonaktifkan
                    DB::table('sessions')->where('user_id', $this->user->id)->delete();

                    // Pengalihan data SPK jika ada — diproses secara asinkron via queue
                    if ($this->spk_count > 0 && $this->transfer_user_id) {
                        TransferSpkOwnershipJob::dispatch(
                            $this->user->id,
                            $this->transfer_user_id,
                            auth()->id()
                        );
                    }
                } else {
                    $data['deactivation_reason'] = null;
                    $data['deactivation_at'] = null;
                }

                if (! empty($this->password)) {
                    $data['password'] = Hash::make($this->password);
                }

                $this->user->update($data);
                $this->user->syncRoles($this->selected_roles);
            });

            return redirect()->route('users.index')
                ->with('status', 'Berhasil memperbarui data user: '.$this->name);
        }, 'Gagal memperbarui data user', [
            'action' => 'update user',
            'updated_user_id' => $this->user->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function render(): View
    {
        $eligibleUsers = collect();
        $selectedTransferUser = null;

        if (! $this->is_active && $this->spk_count > 0) {
            $eligibleRoles = $this->getEligibleRoles();

            if (! empty($eligibleRoles)) {
                $eligibleUsers = User::query()
                    ->where('id', '!=', $this->user->id)
                    ->where('is_active', 1)
                    ->whereHas('roles', fn ($q) => $q->whereIn('name', $eligibleRoles))
                    ->when($this->transfer_search, fn ($q) => $q->where('name', 'like', '%'.$this->transfer_search.'%'))
                    ->limit(5)
                    ->get();
            }

            if ($this->transfer_user_id) {
                $selectedTransferUser = User::find($this->transfer_user_id);
            }
        }

        return view('livewire.handler.user.edit', [
            'list_roles' => Role::orderBy('name', 'asc')->get(),
            'eligible_users' => $eligibleUsers,
            'selected_transfer_user' => $selectedTransferUser,
        ]);
    }
}
