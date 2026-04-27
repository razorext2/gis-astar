<?php

namespace App\Livewire\Handler\LeaveRequest\ManageBalances;

/** Goal: Manage leave balances for all users, Caller: resources/views/dashboard/leave-request/manage.blade.php, Deps: User, LeaveBalance */

use App\Livewire\Concerns\HandlesErrors;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use HandlesErrors, WithPagination;

    public $search = '';
    public $year;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function render()
    {
        // For UI design phase, using dummy data mixed with real query if possible
        // But for pure design, I'll provide a nice structure
        $users = User::with(['pegawai', 'leaveBalances' => function($q) {
                $q->where('year', $this->year);
            }])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('kode_pegawai', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.handler.leave-request.manage-balances.index', [
            'users' => $users
        ]);
    }
}
