<?php

namespace App\Livewire;

use App\Models\LogHistory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class LogTable extends PowerGridComponent
{
    public string $tableName = 'LogTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showSoftDeletes(true)
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::responsive()
                ->fixedColumns('actions', 'user_name'),
            PowerGrid::footer()
                ->showPerPage(perPage: 10, perPageValues: [10, 25, 50, 100, 500, 0])
                ->showRecordCount('full'),
        ];
    }

    public function btnClass()
    {
        return 'dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-gray-700 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-red-700 me-0.5';
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot('Bulk delete')
                ->class($this->btnClass())
                ->dispatch('bulkDelete.' . $this->tableName, []),
        ];
    }

    public function datasource(): Builder
    {
        return LogHistory::query()
            ->with('userRelasi:id,name,kode_pegawai')
            ->latest();
    }

    public function relationSearch(): array
    {
        return [
            'userRelasi' => [
                'name',
                'kode_pegawai',
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('user_name', fn($query) => e($query->userRelasi->name))
            ->add('employee_code', fn($query) => e($query->userRelasi->kode_pegawai ?? '-'))
            ->add('user_action')
            ->add('ip_address')
            ->add('user_agent')
            ->add('user_location')
            ->add('created_at', fn($query) => Carbon::parse($query->created_at)->locale('id'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('#', 'id')
                ->index(),
            Column::make('Kode Pegawai', 'employee_code'),
            Column::make('Nama User', 'user_name'),
            Column::make('User Action', 'user_action')
                ->sortable()
                ->searchable(),
            Column::make('IP Address', 'ip_address')
                ->sortable()
                ->searchable(),
            Column::make('User Agent', 'user_agent')
                ->sortable()
                ->searchable(),
            Column::make('Created At', 'created_at')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('user_name', 'user_id')
                ->dataSource(\App\Models\User::select('id', 'name')->get())
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::select('user_action', 'user_action')
                ->dataSource([
                    ['id' => 'login', 'name' => 'Login'],
                    ['id' => 'logout', 'name' => 'Logout'],
                    ['id' => 'create', 'name' => 'Create'],
                    ['id' => 'update', 'name' => 'Update'],
                    ['id' => 'delete', 'name' => 'Delete'],
                ])
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::datetimepicker('created_at', 'created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                ]),
        ];
    }

    public function actions(LogHistory $row): array
    {
        return [
            Button::add('delete')
                ->slot(Blade::render('<x-icons.trash-bin class="h-5 w-5 text-white" />'))
                ->id()
                ->class($this->btnClass())
                ->dispatch('delete', ['logId' => $row->id])
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($logId): void
    {
        $this->dispatch('confirmDelete', id: $logId);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDelete($logId): void
    {
        $data = Loghistory::find($logId);

        if (!$data) {
            $this->dispatch(
                'swal',
                title: 'Gagal!',
                text: "Terjadi kesalahan saat menghapus data dengan ID <b>$logId</b>",
                icon: 'error'
            );

            return;
        }

        $data->delete();

        $this->dispatch(
            'swal',
            title: 'Terhapus!',
            text: 'Data yang dipilih berhasil dihapus.',
            icon: 'success'
        );
    }

    #[\Livewire\Attributes\On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        if (!$this->checkboxValues) {
            $this->dispatch(
                'swal',
                title: 'Gagal!',
                text: 'Tidak ada data yang dipilih.',
                icon: 'error'
            );

            return;
        }

        $this->dispatch('confirmBulkDelete', id: $this->checkboxValues, tableName: $this->tableName);
    }

    #[\Livewire\Attributes\On('confirmBulkDeleteAction.{tableName}')]
    public function confirmBulkDelete(): void
    {
        LogHistory::destroy($this->checkboxValues);
        $this->js('window.pgBulkActions.clearAll()');

        $this->dispatch(
            'swal',
            title: 'Terhapus!',
            text: 'Data yang dipilih berhasil dihapus.',
            icon: 'success'
        );
    }
}
