<?php
/** Goal: Manage leave balances and leave types, Caller: resources/views/dashboard/leave-request/manage.blade.php, Deps: User, LeaveBalance, LeaveType */

namespace App\Livewire\Handler\LeaveRequest\ManageBalances;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use HandlesErrors, WithPagination;

    public $search = '';
    public $year;

    // Leave Type properties
    public $isModalOpen = false;
    public $editMode = false;
    public $typeId;
    public $typeName, $typeCode, $typeAnualDeduction = false, $typeDefaultDays = 0, $typeRequiresAttachment = false;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->reset(['typeName', 'typeCode', 'typeAnualDeduction', 'typeDefaultDays', 'typeRequiresAttachment', 'editMode', 'typeId']);
        
        if ($id) {
            $this->editMode = true;
            $this->typeId = $id;
            $type = LeaveType::findOrFail($id);
            $this->typeName = $type->name;
            $this->typeCode = $type->code;
            $this->typeAnualDeduction = $type->is_anual_deduction;
            $this->typeDefaultDays = $type->default_days;
            $this->typeRequiresAttachment = $type->requires_attachment;
        }

        $this->isModalOpen = true;
    }

    public function saveType()
    {
        $this->validate([
            'typeName' => 'required|min:3',
            'typeCode' => 'required|unique:tb_leave_types,code,' . $this->typeId,
            'typeDefaultDays' => 'integer|min:0',
        ]);

        $this->runSafely(function() {
            LeaveType::updateOrCreate(['id' => $this->typeId], [
                'name' => $this->typeName,
                'code' => $this->typeCode,
                'is_anual_deduction' => $this->typeAnualDeduction,
                'default_days' => $this->typeDefaultDays,
                'requires_attachment' => $this->typeRequiresAttachment,
            ]);

            $this->isModalOpen = false;
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Tipe cuti berhasil disimpan.');
        });
    }

    public function deleteType($id)
    {
        $this->runSafely(function() use ($id) {
            $type = LeaveType::findOrFail($id);
            if ($type->leaveRequests()->exists()) {
                throw new \Exception('Tidak dapat menghapus tipe cuti yang sudah memiliki data pengajuan.');
            }
            $type->delete();
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Tipe cuti berhasil dihapus.');
        });
    }

    public function render()
    {
        $users = User::with(['pegawai', 'leaveBalances' => function($q) {
                $q->where('year', $this->year);
            }])
            ->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_pegawai', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        $leaveTypes = LeaveType::all();

        return view('livewire.handler.leave-request.manage-balances.index', [
            'users' => $users,
            'leaveTypes' => $leaveTypes
        ]);
    }
}
