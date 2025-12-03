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
        $this->user = Auth::user();
        $query = User::query()->with(['pegawai', 'roles']);

        if ($this->user->hasRole(['Marketing'])) {
            $query->role(['sales']);
        }

        if ($this->user->hasRole(['Marketing-PKU', 'Management-PKU'])) {
            $query->role(['sales-pku']);
        }

        if ($this->user->hasRole(['Marketing-JKT', 'Management-JKT'])) {
            $query->role(['sales-jkt']);
        }

        if ($this->user->hasRole(['Admin', 'Management', 'Management-Special'])) {
            $query->role(['sales', 'sales-jkt', 'sales-pku']);
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'roles' => [
                'role',
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
        return [
            Filter::select('role', 'role')
                ->dataSource([
                    ['name' => 'Sales Medan', 'value' => 'sales'],
                    ['name' => 'Sales Pekanbaru', 'value' => 'sales-pku'],
                    ['name' => 'Sales Jakarta', 'value' => 'sales-jkt'],
                ])
                ->optionLabel('name')
                ->optionValue('value'),
        ];
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
