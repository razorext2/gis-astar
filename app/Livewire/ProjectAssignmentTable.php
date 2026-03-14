<?php

namespace App\Livewire;

use App\Models\Spk\ProjectAssignment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public bool $multiSort = true;

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

    public function datasource()
    {
        $query = ProjectAssignment::query()
            ->with('project', 'assignTo')
            ->join('tb_spk_projects', 'tb_spk_projects.id', '=', 'tb_spk_project_assignments.project_id')
            ->select('tb_spk_project_assignments.*')
            ->addSelect(DB::raw('
                CASE
                    WHEN tb_spk_projects.end_date < NOW() THEN 4
                    WHEN DATEDIFF(tb_spk_projects.end_date, NOW()) <= (DATEDIFF(tb_spk_projects.end_date, tb_spk_projects.start_date) * 0.25) THEN 1
                    WHEN DATEDIFF(tb_spk_projects.end_date, NOW()) <= (DATEDIFF(tb_spk_projects.end_date, tb_spk_projects.start_date) * 0.5) THEN 2
                    ELSE 3
                END as deadline_priority
            '))
            ->addSelect('tb_spk_projects.end_date as project_end_date')
            ->orderBy('tb_spk_projects.end_date', 'desc');

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
            'project' => [
                'project_name',
                'customer_name',
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
                    'code' => '',
                    'name' => $query->project->project_name,
                    'item3' => $query->project->customer_name ?? '-',
                ]);
            })
            ->add('customer_name', fn ($query) => $query->project->customer_name)
            ->add('project_name', fn ($query) => $query->project->project_name)
            ->add('nomor_vt')
            ->add('nomor_vt_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->laporan_type,
                    'name' => $query->nomor_vt,
                    'item3' => $query->assignTo->name,
                ]);
            })
            ->add('deadline_priority')
            ->add('deadline_formatted', function ($query) {
                $start = Carbon::parse($query->project->start_date);
                $end = Carbon::parse($query->project->end_date)->endOfDay();
                $now = Carbon::now();

                $total = $start->diffInDays($end);
                $sisaHari = $now->diffInDays($end, false); // false = bisa negatif
                $sisaJam = $now->diffInHours($end, false);

                $template = "<div class='flex flex-col gap-1 w-fit font-semibold'>";

                if ($sisaHari < 0) {
                    $template .= "
                        <span class='bg-red-500 text-xs px-2.5 flex justify-center items-center py-1 text-red-100 w-fit rounded-lg'>
                            Deadline
                        </span>";
                } elseif ($sisaJam < 24) {
                    $template .= "
                        <span class='bg-red-500 text-xs px-2.5 flex justify-center items-center py-1 text-red-100 w-fit rounded-lg'>
                            Hari ini!
                        </span>";
                } elseif ($sisaHari <= ($total / 2)) {
                    $template .= "
                        <span class='bg-yellow-500 text-xs px-2.5 flex justify-center items-center py-1 text-yellow-800 w-fit rounded-lg'>
                            {$sisaHari} Hari lagi!
                        </span>";
                } else {
                    $template .= "
                        <span class='bg-green-500 text-xs px-2.5 flex justify-center items-center py-1 text-green-800 w-fit rounded-lg'>
                            ".(int) $sisaHari.' Hari
                        </span>';
                }

                $template .= '</div>';

                return $template;
            })
            ->add('assign_to')
            ->add('assign_at')
            ->add('start_end_date_formatted', function ($query) {
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

            Column::make('Nama Projek', 'project_formatted', 'project_name')
                ->sortable()
                ->searchable(),

            Column::make('Nomor VT', 'nomor_vt_formatted', 'nomor_vt')
                ->sortable()
                ->searchable(),

            Column::make('Deadline', 'deadline_formatted', 'deadline_priority')
                ->sortable(),

            Column::make('Tanggal', 'start_end_date_formatted', 'start_date')
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
            // Filter::datetimepicker('assign_at'),
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
}
