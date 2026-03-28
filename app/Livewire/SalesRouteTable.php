<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

    public $user;

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
        $this->user = auth()->user();

        $query = User::query()->with(['pegawai', 'roles']);

        $roles = [];

        if ($this->user->hasRole('Kasir') || $this->user->can('sales-export-kurir-bank')) {
            $roles = ['Kurir-Bank'];
        }

        if ($this->user->hasRole(['HRD-IDY', 'Marketing-IDY']) || $this->user->can('sales-export-idy')) {
            $roles = ['Sales-IDY'];
        }

        if ($this->user->hasRole('Marketing') || $this->user->can('sales-export-medan')) {
            $roles = ['Sales'];
        }

        if ($this->user->hasRole('Service-Agrotec') || $this->user->can('sales-export-agrotec')) {
            $roles = ['Sales-Agrotec'];
        }

        if ($this->user->hasRole(['Marketing-PKU', 'Management-PKU']) || $this->user->can('sales-export-pku')) {
            $roles = ['Sales-PKU'];
        }

        if ($this->user->hasRole(['Marketing-JKT', 'Management-JKT']) || $this->user->can('sales-export-jkt')) {
            $roles = ['Sales-JKT'];
        }

        if ($this->user->hasRole(['Admin', 'Management', 'Management-Special', 'HRD']) || $this->user->can('sales-export-all')) {
            $roles = ['Sales', 'Sales-PKU', 'Sales-IDY', 'Sales-JKT', 'Sales-Agrotec', 'Kurir-Bank'];
        }

        if (! empty($roles)) {
            $query->role($roles);
        }

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
            ->add('kode_pegawai')
            ->add('name')
            ->add('email')
            ->add('role', fn ($query) => collect($query->roles->pluck('name'))->implode(', '));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),

            Column::make('UserID', 'id'),

            Column::make('Kode Pegawai', 'kode_pegawai')
                ->sortable()
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

        if (Auth::user()->can('sales-export-all')) {
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
                ->class('rounded-lg px-2.5 py-2 ring-1 ring-green-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-green-300 focus:scale-105 dark:bg-green-800 dark:text-white dark:ring-gray-700 dark:hover:bg-green-900')
                ->route('routes.sales.detail', ['pegawai' => $row->kode_pegawai ?? 'N/A']),
        ];
    }
}
