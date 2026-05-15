<?php

/** Goal: Manage leave types (CRUD), Caller: livewire.handler.leave-request.manage-balances.index, Deps: LeaveType */

namespace App\Livewire\Handler\LeaveRequest\ManageLeaveTypes;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\LeaveRequest\LeaveType;
use Livewire\Component;

class Index extends Component
{
    use HandlesErrors;

    public bool $isModalOpen = false;

    public bool $editMode = false;

    public ?int $typeId = null;

    public string $typeName = '';

    public string $typeCode = '';

    public bool $typeAnualDeduction = false;

    public int $typeDefaultDays = 0;

    public bool $typeRequiresAttachment = false;

    public function openModal(?int $id = null): void
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
            $this->typeDefaultDays = $type->default_days ?? 0;
            $this->typeRequiresAttachment = $type->requires_attachment;
        }

        $this->isModalOpen = true;
    }

    public function saveType(): void
    {
        $this->validate([
            'typeName'       => 'required|min:3',
            'typeCode'       => 'required|unique:tb_leave_types,code,'.$this->typeId,
            'typeDefaultDays' => 'integer|min:0',
        ]);

        $this->runSafely(function () {
            LeaveType::updateOrCreate(['id' => $this->typeId], [
                'name'               => $this->typeName,
                'code'               => $this->typeCode,
                'is_anual_deduction' => $this->typeAnualDeduction,
                'default_days'       => $this->typeDefaultDays,
                'requires_attachment' => $this->typeRequiresAttachment,
            ]);

            $this->isModalOpen = false;
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Tipe cuti berhasil disimpan.');
        });
    }

    public function deleteType(int $id): void
    {
        $this->runSafely(function () use ($id) {
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
        $leaveTypes = LeaveType::select(['id', 'name', 'code', 'is_anual_deduction', 'default_days', 'requires_attachment'])->get();

        return view('livewire.handler.leave-request.manage-leave-types.index', [
            'leaveTypes' => $leaveTypes,
        ]);
    }
}
