<?php

/** Goal: Leave balance table with search, year filter, edit quota & reset, Caller: manage-balances.index, Deps: User, LeaveBalance */

namespace App\Livewire\Handler\LeaveRequest\ManageBalances;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveBalance;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

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
        $user = User::with(['leaveBalances' => fn ($q) => $q->where('year', $this->year)])->findOrFail($userId);
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
        }])->findOrFail($userId);

        $this->historyUserName = $user->name;
        $this->historyData = $user->leaveRequests->toArray();
        $this->isHistoryOpen = true;
    }

    public function saveBalance(): void
    {
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
        if (!$user->join_date) {
            return 12; // Jika join_date kosong, berikan default 12
        }

        $joinDate = \Carbon\Carbon::parse($user->join_date);
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
        $this->runSafely(function () use ($userId) {
            $user = User::findOrFail($userId);
            $quota = $this->calculateDefaultQuota($user);
            LeaveBalance::updateOrCreate(
                ['user_id' => $userId, 'year' => $this->year],
                ['total_quota' => $quota, 'used_quota' => 0]
            );
            $this->dispatch('swal', icon: 'success', title: 'Reset', text: "Saldo {$user->name} berhasil direset menjadi {$quota} hari.");
        });
    }

    // --- Reset all (bulk) ---

    public function resetAll(): void
    {
        $this->runSafely(function () {
            // Ambil ID User Pegawai yang sudah memiliki used_quota > 0 (untuk dilewati)
            $lockedUserIds = LeaveBalance::where('year', $this->year)
                ->where('used_quota', '>', 0)
                ->whereHas('user', fn ($q) => $q->whereHas('pegawai'))
                ->pluck('user_id')
                ->toArray();

            // Ambil semua User yang memiliki relasi Pegawai
            $users = User::whereHas('pegawai')->get();

            $reset = 0;
            $skipped = 0;

            foreach ($users as $user) {
                // Jika user ada di daftar locked, tambahkan ke hitungan skipped dan lewati
                if (in_array($user->id, $lockedUserIds)) {
                    $skipped++;

                    continue;
                }

                $quota = $this->calculateDefaultQuota($user);

                LeaveBalance::updateOrCreate(
                    ['user_id' => $user->id, 'year' => $this->year],
                    ['total_quota' => $quota, 'used_quota' => 0]
                );

                $reset++;
            }

            $text = "{$reset} saldo pegawai berhasil direset.";
            if ($skipped > 0) {
                $text .= " {$skipped} pegawai dilewati karena sudah memiliki riwayat pemakaian cuti.";
            }

            $this->dispatch('swal', icon: 'success', title: 'Reset Massal', text: $text);
        });
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
            ->orderBy('name')
            ->paginate(10)
            ->onEachSide(1); // max 5 page numbers: 1 ... prev current next ... last

        return view('livewire.handler.leave-request.manage-balances.table', [
            'users' => $users,
        ]);
    }
}
