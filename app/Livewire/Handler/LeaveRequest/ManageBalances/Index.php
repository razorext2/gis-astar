<?php

/** Goal: Tab router for Pengaturan Cuti (Kelola Saldo / Tipe Cuti), Caller: routes/web.php, Deps: ManageBalances.Table, ManageLeaveTypes.Index */

namespace App\Livewire\Handler\LeaveRequest\ManageBalances;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.handler.leave-request.manage-balances.index');
    }
}
