<?php

namespace App\Livewire;

use App\Models\BigEvent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class BigEventTable extends PowerGridComponent
{
    public string $tableName = 'BigEventTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
        ];
    }

    public function datasource(): Builder
    {
        return BigEvent::query()
            ->orderBy('start_date', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('name')
            ->add('description')
            ->add('location')
            ->add('start_date_formatted', fn(BigEvent $model) => Carbon::parse($model->start_date)->format('d/m/Y'))
            ->add('end_date_formatted', fn(BigEvent $model) => Carbon::parse($model->end_date)->format('d/m/Y'))
            ->add('status')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Description', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Location', 'location')
                ->sortable()
                ->searchable(),

            Column::make('Start date', 'start_date_formatted', 'start_date')
                ->sortable(),

            Column::make('End date', 'end_date_formatted', 'end_date')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('status', 'status')
                ->dataSource([
                    ['name' => 'Aktif', 'value' => 'active'],
                    ['name' => 'Tidak Aktif', 'value' => 'inactive'],
                    ['name' => 'Sedang Berlangsung', 'value' => 'ongoing'],
                ])
                ->optionLabel('name')
                ->optionValue('value'),
            Filter::datepicker('start_date'),
            Filter::datepicker('end_date'),
        ];
    }

    public function actions(BigEvent $row): array
    {
        $button = [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('event.show', ['event' => $row->id]),
            Button::make('edit')
                ->slot('Ubah')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('event.edit', ['event' => $row->id]),
        ];

        return $button;
    }
}
