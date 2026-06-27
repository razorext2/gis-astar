<?php

namespace App\Livewire\PowergridTables;

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

    public function setUp(): array
    {
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
            ->addSelect(DB::raw('
                CASE
                    WHEN tb_spk_project_assignments.status = "assigned" THEN 1
                    WHEN tb_spk_project_assignments.status = "in_progress" THEN 2
                    WHEN tb_spk_project_assignments.status = "completed" THEN 3
                    WHEN tb_spk_project_assignments.status = "cancelled" THEN 4
                    ELSE 0
                END as status_priority
            '))
            ->orderBy('created_at', 'desc');

        if (auth()->user()->cannot('laporan-harian-approve')) {
            $query->where('assign_to', auth()->user()->id);
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

    protected int $rowNumber = 0;

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no', fn () => ++$this->rowNumber)
            ->add('project_id')
            ->add('project_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => '',
                    'name' => $query->project->project_name,
                    'item3' => $query->project->customer_name,
                ]);
            })
            ->add('company_name', fn ($query) => $query->project->customer_name)
            ->add('project_name', fn ($query) => $query->project->project_name)
            ->add('nomor_vt')
            ->add('nomor_vt_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->laporan_type,
                    'name' => $query->nomor_vt,
                    'item3' => $query->assignTo->name,
                    'is_active_item3' => $query->assignTo?->is_active ?? true,
                ]);
            })
            ->add('deadline_priority')
            ->add('deadline_formatted', function ($query) {
                $start = Carbon::parse($query->project->start_date);
                $end = Carbon::parse($query->project->end_date)->endOfDay();
                $now = Carbon::now();

                $total = $start->diffInDays($end);
                $sisaHari = (int) $now->diffInDays($end, false);
                $sisaJam = (int) $now->diffInHours($end, false);

                // helper render badge
                $badge = fn ($text, $bg, $textColor) => "
                    <span class='{$bg} text-xs px-2.5 flex justify-center items-center py-1 {$textColor} w-fit rounded-lg'>
                        {$text}
                    </span>
                ";

                // deadline
                $deadlineBadge = '';

                if ($query->status !== 'completed') {
                    if ($sisaHari < 0) {
                        $deadlineBadge = $badge('Habis Waktu', 'bg-red-500', 'text-red-100');
                    } elseif ($sisaJam < 24) {
                        $deadlineBadge = $badge('Hari ini!', 'bg-red-500', 'text-red-100');
                    } elseif ($sisaHari <= ($total / 2)) {
                        $deadlineBadge = $badge("{$sisaHari} Hari", 'bg-yellow-500', 'text-yellow-800');
                    } else {
                        $deadlineBadge = $badge("{$sisaHari} Hari", 'bg-green-500', 'text-green-800');
                    }
                }

                // status project
                $statusMap = [
                    'completed' => ['Selesai', 'bg-green-500', 'text-green-800'],
                    'cancelled' => ['Dibatalkan', 'bg-red-500', 'text-red-100'],
                    'in_progress' => ['Proses', 'bg-yellow-500', 'text-yellow-800'],
                    'assigned' => ['Diassign', 'bg-yellow-500', 'text-yellow-800'],
                ];

                $statusBadge = '';

                if (isset($statusMap[$query->status])) {
                    [$text, $bg, $color] = $statusMap[$query->status];
                    $statusBadge = $badge($text, $bg, $color);
                }

                return "
                    <div class='flex gap-1 w-fit font-semibold'>
                        {$deadlineBadge}
                        {$statusBadge}
                    </div>
                ";
            })
            ->add('assign_to')
            ->add('assign_at')
            ->add('start_end_date_formatted', function ($query) {
                $start = Carbon::parse($query->project->start_date)->locale('id')->isoFormat('D MMMM YYYY');
                $end = Carbon::parse($query->project->end_date)->locale('id')->isoFormat('D MMMM YYYY');

                return $start.' <b>s/d</b> '.$end;
            })
            ->add('deadline_priority')
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

            Column::make('Nama Perusahaan', 'company_name', 'project.customer_name')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-wrap'),

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
            Filter::inputText('project_name', 'project_name')
                ->placeholder('Projek XXX'),
            Filter::select('status', 'status')
                ->dataSource([
                    ['value' => 'assigned', 'label' => 'Diajukan'],
                    ['value' => 'in_progress', 'label' => 'Dikerjakan'],
                    ['value' => 'completed', 'label' => 'Selesai'],
                    ['value' => 'cancelled', 'label' => 'Dibatalkan'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::inputText('nomor_vt', 'nomor_vt')
                ->placeholder('VT-XXX'),
            Filter::inputText('company_name', 'tb_spk_projects.customer_name')
                ->placeholder('PT. XXX'),
        ];
    }

    public function actions(ProjectAssignment $row): array
    {
        return [
            Button::add('detail')
                ->slot('Detail')
                ->id()
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->route('report.general.daily', ['id' => $row->id]),
        ];
    }

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }
}
