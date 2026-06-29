<?php

/** Goal: Display collector route overview table with active status support, Caller: routes/web.php, Deps: User */

namespace App\Livewire\PowergridTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class CollectorRouteTable extends PowerGridComponent
{
    public string $tableName = 'CollectorRouteTable';

    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()->role('collector');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai', fn ($row) => view('components.dashboard.date-w-name', [
                'date' => $row->kode_pegawai,
                'name' => 'ID: '.$row->id,
            ]))
            ->add('name', fn ($row) => view('components.dashboard.name-w-badge', [
                'name' => $row->name,
                'is_active' => (bool) $row->is_active,
            ]))
            ->add('email');
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('Kode / ID', 'kode_pegawai')
                ->searchable(),

            Column::make('Nama Lengkap', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(User $row): array
    {
        return [
            Button::add('routeDetail')
                ->slot('Detail')
                ->id($row->id)
                ->class('rounded-lg px-2.5 py-2 ring-1 ring-green-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-green-300 focus:scale-105 dark:bg-green-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-green-900')
                ->route('routes.collector.detail', ['pegawai' => $row->kode_pegawai ?? '123']),
        ];
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
