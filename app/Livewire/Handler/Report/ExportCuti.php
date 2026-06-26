<?php

/** Goal: Livewire export handler untuk Laporan Cuti, Caller: dashboard.report.cuti, Deps: HasReportExport trait, Spatie Role, ExportReportJob, User */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ExportCuti extends Component
{
    use HasReportExport;

    public array $selectedUsers = [];

    public string $userSearchQuery = '';

    public ?int $roleId = null;

    public ?string $leaveStatus = null;

    public string $dateType = 'created_at';

    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'cuti';
    }

    protected function getFilterOptions(): array
    {
        return [
            'user_id' => ['label' => 'Pengaju Cuti', 'column' => 'user_id'],
        ];
    }

    #[Computed]
    public function userSearchResults()
    {
        if (strlen($this->userSearchQuery) < 1) {
            return [];
        }

        $selectedIds = array_column($this->selectedUsers, 'id');

        return User::select(['id', 'kode_pegawai', 'name', 'is_active'])
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->userSearchQuery.'%')
                    ->orWhere('name', 'like', '%'.$this->userSearchQuery.'%');
            })
            ->when(! empty($selectedIds), fn ($q) => $q->whereNotIn('id', $selectedIds))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    public function selectUser(int $id, string $name, ?string $kodePegawai = null, bool $isActive = true): void
    {
        $this->selectedUsers[] = [
            'id' => $id,
            'name' => $name,
            'kode_pegawai' => $kodePegawai,
            'is_active' => $isActive,
        ];

        $this->userSearchQuery = '';
    }

    public function removeUser(int $id): void
    {
        $this->selectedUsers = array_filter($this->selectedUsers, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        $this->selectedUsers = array_values($this->selectedUsers);
    }

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'role_id' => $this->roleId,
            'status' => $this->leaveStatus,
            'date_type' => $this->dateType,
        ];

        if (! empty($this->selectedUsers)) {
            $this->filterBy = 'user_id';
            $this->filterValue = implode(',', array_column($this->selectedUsers, 'id'));
        } else {
            $this->filterBy = null;
            $this->filterValue = null;
        }

        \App\Jobs\ExportReportJob::dispatch(
            \Illuminate\Support\Facades\Auth::id(),
            $this->getReportType(),
            $this->fromDate,
            $this->toDate,
            $this->filterBy,
            $this->filterValue,
            $this->exportFormat,
            $this->additionalFilters,
        )->delay(now()->addSeconds(2));

        $this->dispatch('swal',
            title: 'Berhasil',
            text: 'Permintaan export sedang diproses. Silahkan cek menu notifikasi nanti.',
            icon: 'success'
        );
    }

    #[Computed]
    public function roles()
    {
        return Role::select(['id', 'name'])->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.handler.report.export-cuti', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
            'roles' => $this->roles(),
        ]);
    }
}
