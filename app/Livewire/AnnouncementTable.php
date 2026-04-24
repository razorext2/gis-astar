<?php

namespace App\Livewire;

use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class AnnouncementTable extends PowerGridComponent
{
    public string $tableName = 'AnnouncementTable';

    public bool $deferLoading = true;

    public bool $showFilters = true;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            Powergrid::responsive(),
            PowerGrid::footer()
                ->showPerPage(perPage: 10, perPageValues: [10, 25, 50, 100, 500, 0])
                ->showRecordCount(),
        ];
    }

    public function btnClass()
    {
        return 'dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-zinc-800 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-red-700 me-0.5';
    }

    public function header(): array
    {
        return [];
    }

    public function datasource(): Builder
    {
        return Announcement::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('status', function ($row) {
                return view('components.table-component.status', ['status' => $row->status]);
            })
            ->add('updated_at')
            ->add('updated_at_formatted', function (Announcement $row) {
                return Carbon::parse($row->updated_at)->locale('id')->diffForHumans();
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),

            Column::make('Judul', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Deskripsi', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Updated at', 'updated_at_formatted', 'updated_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::boolean('status')
                ->label('Aktif', 'Tidak aktif'),
            Filter::inputText('title', 'title'),
        ];
    }

    public function actions(Announcement $row): array
    {
        return [];
    }

    public function actionsFromView(Announcement $row): View
    {
        $actions = [
            [
                'id' => 'state-btn',
                'action' => 'javascript:void(0)',
                'label' => 'Ubah Status',
            ],
            [
                'id' => 'edit-btn',
                'action' => 'javascript:void(0)',
                'label' => 'Edit',
            ],
            [
                'id' => 'delete-btn',
                'action' => 'javascript:void(0)',
                'label' => 'Hapus',
            ],
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
        ]);
    }
}
