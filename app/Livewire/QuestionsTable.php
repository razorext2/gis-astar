<?php

namespace App\Livewire;

use \App\Models\Question;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class QuestionsTable extends PowerGridComponent
{
    public string $tableName = 'QuestionsTable';
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
                ->fixedColumns('id', 'for', 'is_active', 'question')
        ];
    }

    public function datasource(): Builder
    {
        return Question::query()
            ->with('addedBy')
            ->orderBy('question', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('for')
            ->add('is_active')
            ->add('question')
            ->add('added_by')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi'),
            Column::make('ID', 'id'),
            Column::make('Untuk', 'for')
                ->sortable()
                ->searchable(),

            Column::make('Is Active', 'is_active'),
            Column::make('Pertanyaan', 'question')
                ->sortable()
                ->searchable(),

            Column::make('Dibuat Oleh', 'added_by')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }
}
