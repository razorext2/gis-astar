<?php

/** Goal: Display sales route overview table with active status support, Caller: routes/web.php, Deps: User, SalesRegionResolver */

namespace App\Livewire\PowergridTables;

use App\Models\User;
use App\Services\Sales\SalesRegionResolver;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SalesRouteTable extends PowerGridComponent
{
    public string $tableName = 'SalesRouteTable';

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
        $roles = SalesRegionResolver::resolveForUser(auth()->user());

        $query = User::query()->with(['pegawai', 'roles']);

        if (! empty($roles)) {
            $query->role($roles);
        }

        $query->orderBy('is_active', 'desc');

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'roles' => [
                'name',
            ],
        ];
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
            ->add('email')
            ->add('role', fn ($query) => collect($query->roles->pluck('name'))->implode(', '));
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

            Column::make('Role', 'role'),
        ];
    }

    public function filters(): array
    {
        $filters = [];

        if (auth()->user()->can('sales-export-all')) {
            $filters[] = Filter::select('role', 'role')
                ->dataSource([
                    ['name' => 'Sales Medan', 'value' => 'Sales'],
                    ['name' => 'Sales Pekanbaru', 'value' => 'Sales-PKU'],
                    ['name' => 'Sales Jakarta', 'value' => 'Sales-JKT'],
                    ['name' => 'Sales Indodaya', 'value' => 'Sales-Indodaya'],
                    ['name' => 'Kurir Bank', 'value' => 'Kurir-Bank'],
                    ['name' => 'Sales Agrotec', 'value' => 'Sales-Agrotec'],
                ])
                ->optionLabel('name')
                ->optionValue('value')
                ->builder(fn (Builder $builder, string $value) => $builder->whereHas(
                    'roles',
                    fn (Builder $roleQuery) => $roleQuery->where('name', $value)
                ));
        }

        $filters[] = Filter::inputText('name', 'name')
            ->placeholder('Nama');

        $filters[] = Filter::inputText('kode_pegawai', 'kode_pegawai')
            ->placeholder('Kode Jari');

        return $filters;

    }

    public function actions(User $row): array
    {
        return [
            Button::add('routeDetail')
                ->slot('Detail')
                ->id($row->id)
                ->class('rounded-lg px-2.5 py-2 ring-1 ring-green-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-green-300 focus:scale-105 dark:bg-green-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-green-900')
                ->route('routes.sales.detail', ['pegawai' => $row->kode_pegawai ?? 'N/A']),
        ];
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
