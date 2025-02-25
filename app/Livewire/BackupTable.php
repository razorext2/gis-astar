<?php

namespace App\Livewire;

use App\Models\Backup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class BackupTable extends PowerGridComponent
{
    public string $tableName = 'BackupTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
                ->fixedColumns('name')
        ];
    }

    public function datasource(): Builder
    {
        return Backup::query()
            ->with('user')
            ->latest();
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
            ->add('type')
            ->add('status', fn($query) => \Illuminate\Support\Facades\Blade::render('components.table-component.state', ['status' => $query->status == 'success' ? 1 : 0]))
            ->add('user_id', fn($query) => e($query->user->name))
            ->add('created_at')
            ->add('created_at_formatted', fn($query) => e(Carbon::parse($query->created_at)->locale('id')->diffForHumans()));
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->index(),
            Column::action('Action'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Tipe', 'type')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Oleh', 'user_id')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('type', 'type')
                ->dataSource([
                    ['id' => 'DB', 'name' => 'Database'],
                    ['id' => 'App', 'name' => 'Application'],
                    ['id' => 'Full', 'name' => 'Full Backup'],
                ])
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                ]),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Backup $row): array
    {
        return [];
    }

    public function actionsFromView(Backup $row): View
    {
        return view('components.button.actions', ['id' => $row->id]);
    }
}
