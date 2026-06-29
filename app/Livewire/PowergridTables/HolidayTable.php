<?php

/** Goal: Display national holidays in a searchable table. Caller: Livewire Components, Deps: Holiday model, PowerGrid */

namespace App\Livewire\PowergridTables;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\System\Holiday;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class HolidayTable extends PowerGridComponent
{
    use HandlesErrors;

    public string $tableName = 'HolidayTable';

    public bool $deferLoading = true;

    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),

            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Holiday::query()->orderBy('date', 'desc');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('date_formatted', fn ($query) => Carbon::parse($query->date)->locale('id')->isoFormat('DD MMMM YYYY'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),

            Column::make('Tanggal', 'date_formatted', 'date')
                ->sortable(),

            Column::make('Nama Libur', 'name')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('date'),
            Filter::inputText('name')->placeholder('Cari nama libur...'),
        ];
    }

    public function actionsFromView(Holiday $row)
    {
        $actions = []; // No edit for now as requested user selects from API

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('holiday-delete'), // Check permission
        ]);
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        if (auth()->user()->cannot('holiday-delete')) {
            $this->dispatch('swal', title: 'Akses Ditolak', text: 'Anda tidak memiliki izin untuk menghapus data.', icon: 'error');

            return;
        }
        $this->dispatch('confirmDelete', id: $id);
    }

    #[On('confirmDeleteAction')]
    public function confirmDelete(int $id): void
    {
        $this->runSafely(function () use ($id) {
            $data = Holiday::findOrFail($id);
            $data->delete();
            $this->dispatch('swal', title: 'Terhapus!', text: 'Data libur berhasil dihapus.', icon: 'success');
        }, 'Gagal menghapus data libur.');
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
