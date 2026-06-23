<?php

/** Goal: Leave balance table with search, year filter, edit quota & reset, Caller: manage-balances.index, Deps: User, LeaveBalance, Spatie Role */

namespace App\Livewire\Handler\LeaveRequest\ManageBalances;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveBalance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Table extends Component
{
    use HandlesErrors, WithPagination;

    public string $search = '';

    public int $year;

    // Edit State
    public bool $isEditOpen = false;

    public ?int $editUserId = null;

    public string $editUserName = '';

    public int $editTotalQuota = 0;

    public int $editUsedQuota = 0;

    // History State
    public bool $isHistoryOpen = false;

    public ?string $historyUserName = '';

    public array $historyData = [];

    // Reset Filter State
    public bool $isResetFilterOpen = false;

    public string $resetMode = 'all';

    public ?int $resetRoleId = null;

    public array $resetSelectedRoleIds = [];

    public array $resetSelectedUsers = [];

    public string $resetUserSearchQuery = '';

    public function mount(): void
    {
        $this->year = (int) date('Y');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedYear(): void
    {
        $this->resetPage();
    }

    // --- Edit Balance ---

    public function openEdit(int $userId): void
    {
        $user = User::with(['leaveBalances' => fn ($q) => $q->where('year', $this->year)])
            ->where('is_active', true)
            ->findOrFail($userId);
        $balance = $user->leaveBalances->first();

        $this->editUserId = $userId;
        $this->editUserName = $user->name;
        $this->editTotalQuota = $balance ? $balance->total_quota : 0;
        $this->editUsedQuota = $balance ? $balance->used_quota : 0;
        $this->isEditOpen = true;
    }

    public function openHistory(int $userId): void
    {
        $user = User::with(['leaveRequests' => function ($q) {
            $q->whereYear('start_date', $this->year)
                ->with('leaveType')
                ->latest();
        }])
            ->where('is_active', true)
            ->findOrFail($userId);

        $this->historyUserName = $user->name;
        $this->historyData = $user->leaveRequests->toArray();
        $this->isHistoryOpen = true;
    }

    public function saveBalance(): void
    {
        abort_unless(auth()->user()->can('leave-balance-manage'), 403);

        $user = User::where('is_active', true)->findOrFail($this->editUserId);

        $this->validate([
            'editTotalQuota' => 'required|integer|min:0',
            'editUsedQuota' => 'required|integer|min:0',
        ]);

        $this->runSafely(function () {
            LeaveBalance::updateOrCreate(
                ['user_id' => $this->editUserId, 'year' => $this->year],
                ['total_quota' => $this->editTotalQuota, 'used_quota' => $this->editUsedQuota]
            );

            $this->isEditOpen = false;
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Saldo cuti berhasil diperbarui.');
        });
    }

    // --- Reset single user ---

    private function calculateDefaultQuota(User $user): int
    {
        if (! $user->join_date) {
            return 12; // Jika join_date kosong, berikan default 12
        }

        $joinDate = Carbon::parse($user->join_date);
        $joinYear = $joinDate->year;
        $joinMonth = $joinDate->month;

        $yearsWorked = $this->year - $joinYear;

        if ($yearsWorked < 1) {
            return 0;
        } elseif ($yearsWorked == 1) {
            return max(0, 12 - $joinMonth);
        } else {
            return 12;
        }
    }

    public function resetBalance(int $userId): void
    {
        abort_unless(auth()->user()->can('leave-balance-manage'), 403);

        $this->runSafely(function () use ($userId) {
            $user = User::where('is_active', true)->findOrFail($userId);
            $quota = $this->calculateDefaultQuota($user);
            LeaveBalance::updateOrCreate(
                ['user_id' => $userId, 'year' => $this->year],
                ['total_quota' => $quota, 'used_quota' => 0, 'reset_at' => now(), 'reset_by' => auth()->id()]
            );
            $this->dispatch('swal', icon: 'success', title: 'Reset', text: "Saldo {$user->name} berhasil direset menjadi {$quota} hari.");
        });
    }

    // --- Reset Filter Modal ---

    public function openResetModal(): void
    {
        $this->resetMode = 'all';
        $this->resetRoleId = null;
        $this->resetSelectedRoleIds = [];
        $this->resetSelectedUsers = [];
        $this->resetUserSearchQuery = '';
        $this->isResetFilterOpen = true;
    }

    #[Computed]
    public function resetUserSearchResults(): mixed
    {
        if (strlen($this->resetUserSearchQuery) < 1) {
            return [];
        }

        $selectedIds = array_column($this->resetSelectedUsers, 'id');

        return User::select(['id', 'kode_pegawai', 'name'])
            ->whereHas('pegawai')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->where('name', 'like', '%'.$this->resetUserSearchQuery.'%')
                    ->orWhere('kode_pegawai', 'like', '%'.$this->resetUserSearchQuery.'%');
            })
            ->when(! empty($selectedIds), fn ($q) => $q->whereNotIn('id', $selectedIds))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    public function selectResetUser(int $id, string $name, ?string $kodePegawai = null): void
    {
        $this->resetSelectedUsers[] = ['id' => $id, 'name' => $name, 'kode_pegawai' => $kodePegawai];
        $this->resetUserSearchQuery = '';
    }

    public function removeResetUser(int $id): void
    {
        $this->resetSelectedUsers = array_values(
            array_filter($this->resetSelectedUsers, fn ($item) => $item['id'] !== $id)
        );
    }

    #[Computed]
    public function roles(): mixed
    {
        return Role::select(['id', 'name'])->orderBy('name')->get();
    }

    // --- Reset (bulk with filter) ---

    public function resetByFilter(): void
    {
        abort_unless(auth()->user()->can('leave-balance-manage'), 403);

        if ($this->resetMode === 'role' && empty($this->resetSelectedRoleIds)) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pilih minimal satu role.');

            return;
        }

        if ($this->resetMode === 'users' && empty($this->resetSelectedUsers)) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Pilih minimal satu user.');

            return;
        }

        $this->runSafely(function () {
            $lockedUserIds = LeaveBalance::where('year', $this->year)
                ->where('used_quota', '>', 0)
                ->whereHas('user', fn ($q) => $q->whereHas('pegawai')->where('is_active', true))
                ->pluck('user_id')
                ->toArray();

            $reset = 0;
            $skipped = 0;

            $query = User::whereHas('pegawai')->where('is_active', true);

            if ($this->resetMode === 'role') {
                $query->whereHas('roles', fn ($q) => $q->whereIn('id', $this->resetSelectedRoleIds));
            } elseif ($this->resetMode === 'users') {
                $query->whereIn('id', array_column($this->resetSelectedUsers, 'id'));
            }

            $query->chunk(100, function ($users) use ($lockedUserIds, &$reset, &$skipped) {
                foreach ($users as $user) {
                    if (in_array($user->id, $lockedUserIds)) {
                        $skipped++;

                        continue;
                    }

                    $quota = $this->calculateDefaultQuota($user);

                    LeaveBalance::updateOrCreate(
                        ['user_id' => $user->id, 'year' => $this->year],
                        ['total_quota' => $quota, 'used_quota' => 0, 'reset_at' => now(), 'reset_by' => auth()->id()]
                    );

                    $reset++;
                }
            });

            $text = "{$reset} saldo pegawai berhasil direset.";
            if ($skipped > 0) {
                $text .= " {$skipped} pegawai dilewati karena sudah memiliki riwayat pemakaian cuti.";
            }

            $this->isResetFilterOpen = false;
            $this->dispatch('swal', icon: 'success', title: 'Reset Saldo', text: $text);
        });
    }

    public function resetAll(): void
    {
        $this->resetMode = 'all';
        $this->resetByFilter();
    }

    public function render()
    {
        $users = User::with(['pegawai', 'leaveBalances' => function ($q) {
            $q->where('year', $this->year);
        }])
            ->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('kode_pegawai', 'like', '%'.$this->search.'%');
            })
            ->whereHas('pegawai')
            ->where('is_active', true)
            ->orderBy('name')
            ->paginate(10)
            ->onEachSide(1); // max 5 page numbers: 1 ... prev current next ... last

        return view('livewire.handler.leave-request.manage-balances.table', [
            'users' => $users,
        ]);
    }
}
