<?php

namespace App\Livewire;

use App\Models\Spk\ProjectAssignment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProjectAssignmentTable extends PowerGridComponent
{
    public string $tableName = 'ProjectAssignmentTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $user;

    public function setUp(): array
    {
        $this->user = auth()->user();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = ProjectAssignment::query()
            ->with('project', 'assignTo');

        if ($this->user->cannot('laporan-harian-validate')) {
            $query->where('assign_to', $this->user->id);
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'assignTo' => [
                'name',
                'kode_pegawai',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no', fn ($query, int $index) => $index + 1)
            ->add('project_id')
            ->add('project_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->project->id,
                    'name' => $query->project->project_name,
                    'item3' => $query->project->start_date,
                ]);
            })
            ->add('nomor_vt')
            ->add('nomor_vt_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->laporan_type,
                    'name' => $query->nomor_vt,
                    'item3' => $query->assignTo->name,
                ]);
            })
            ->add('assign_to')
            ->add('assign_at')
            ->add('deadline_formatted', function ($query) {
                $start = Carbon::parse($query->project->start_date)->locale('id')->isoFormat('D MMMM YYYY');
                $end = Carbon::parse($query->project->end_date)->locale('id')->isoFormat('D MMMM YYYY');

                return $start.' <b>s/d</b> '.$end;
            })
            ->add('status')
            ->add('created_at')
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'no'),

            Column::action('Action'),

            Column::make('Nama Projek', 'project_formatted', 'project_id')
                ->sortable()
                ->searchable(),

            Column::make('Nomor VT', 'nomor_vt_formatted', 'nomor_vt')
                ->sortable()
                ->searchable(),

            Column::make('Deadline', 'deadline_formatted', 'deadline')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable()
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Assign to', 'assign_to')
                ->searchable()
                ->hidden(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('assign_at'),
        ];
    }

    public function actions(ProjectAssignment $row): array
    {
        return [
            Button::add('detail')
                ->slot('Detail')
                ->id()
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->route('report.general.daily', ['id' => $row->id]),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
