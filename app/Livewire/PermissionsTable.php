<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use \Spatie\Permission\Models\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PermissionsTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'PermissionsTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage(25, [0, 10, 25, 50, 500])
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(fileName: 'permissionReport-' . now()->format('Ymdhis'))
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        return Permission::query()
            ->orderBy('name', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('guard_name')
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
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Guard', 'guard_name')
                ->sortable()
                ->searchable(),
            Column::make('Created at', 'created_at_formatted', 'created_at'),
            Column::make('Updated at', 'updated_at_formatted', 'updated_at'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name', 'name'),
            Filter::datetimepicker('created_at', 'created_at')
        ];
    }

    public function actionsFromView(Permission $row)
    {
        return Blade::render("
            <a href='{{ route('permissions.edit', $row->id) }}' class='rounded-lg px-2.5 py-2 ring-1 ring-blue-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-blue-300 focus:scale-105 dark:bg-blue-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-blue-900' wire:navigate>
                Edit
            </a>
        ");
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
