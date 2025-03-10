<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use \Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class RolesTable extends PowerGridComponent
{
    public string $tableName = 'RolesTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage(25, [0, 10, 25, 50, 500])
                ->showRecordCount(),
            PowerGrid::responsive()
                ->fixedColumns('name', 'guard_name', 'created_at', 'updated_at')
        ];
    }

    public function datasource(): Builder
    {
        return Role::query()
            ->with('permissions')
            ->orderBy('name', 'asc');
    }

    public function relationSearch(): array
    {
        return [

        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('guard_name')
            ->add('permissions', function ($query) {
                $data = $query->permissions->pluck('name');

                return view('components.table-component.tags', ['items' => $data]);
            })
            ->add('created_at')
            ->add('created_at_formatted', function ($query) {
                $date = Carbon::parse($query->created_at)->locale('id')->isoFormat('D MMMM YYYY');
                $time = Carbon::parse($query->created_at)->locale('id')->isoFormat('HH:mm:ss');

                return view('components.dashboard.custom-date', ['date' => $date, 'time' => $time]);
            })
            ->add('updated_at')
            ->add('updated_at_formatted', function ($query) {
                $date = Carbon::parse($query->updated_at)->locale('id')->isoFormat('D MMMM YYYY');
                $time = Carbon::parse($query->updated_at)->locale('id')->isoFormat('HH:mm:ss');

                return view('components.dashboard.custom-date', ['date' => $date, 'time' => $time]);
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Nama Role', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Guard', 'guard_name')
                ->sortable(),
            Column::make('Permissions', 'permissions'),
            Column::make('Created at', 'created_at')
                ->hidden(),
            Column::make('Updated at', 'updated_at')
                ->hidden(),
            Column::make('Created at', 'created_at_formatted', 'created_at'),
            Column::make('Updated at', 'updated_at_formatted', 'updated_at')
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name', 'name'),
            Filter::datetimepicker('created_at', 'created_at')
        ];
    }

    public function btnClass()
    {
        return 'dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-gray-700 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-red-700 me-0.5';
    }

    public function actionsFromView(Role $row)
    {
        return Blade::render("
            <a href='{{ route('roles.edit', $row->id) }}' class='rounded-lg px-2.5 py-2 ring-1 ring-blue-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-blue-300 focus:scale-105 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900' wire:navigate>
                Edit
            </a>
        ");


        // return view('components.dashboard.single-button', [
        //     'id' => $row->id,
        //     'data' => [
        //         'id' => 'editBtn' . $row->id,
        //         'action' => route('roles.edit', $row->id),
        //         'label' => 'Detail',
        //         'navigate' => true,
        //     ]
        // ]);
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
