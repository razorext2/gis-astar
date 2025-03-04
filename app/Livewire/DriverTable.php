<?php

namespace App\Livewire;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DriverTable extends PowerGridComponent
{
    public string $tableName = 'DriverTable';
    public bool $showFilters = true;
    public bool $deferLoading = true;
    public $pegawai;

    public function setUp(): array
    {
        $this->showCheckBox();
        $this->pegawai = User::role('Driver')->get();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
        ];
    }

    public function datasource(): Builder
    {
        return Driver::query()
            ->with(['user', 'photoCollect'])
            ->latest();
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
                'kode_pegawai'
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai')
            ->add('title')
            ->add('lokasi')
            ->add('keterangan')
            ->add('longitude')
            ->add('latitude')
            ->add('status', function ($query) {
                $status = $query->status;

                return view('components.dashboard.title-w-status-two', [
                    'title' => [
                        0 => 'Diajukan',
                        1 => 'Disetujui',
                        2 => 'Ditolak',
                    ][$status],
                    'status' => $status
                ])->render();
            })
            ->add('notes')
            ->add('validate_by')
            ->add('created_at')
            ->add('created_at_formatted', fn($query)
                => Carbon::parse($query->created_at)
                    ->locale('id')
                    ->isoFormat('D MMMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Kode pegawai', 'kode_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Judul Laporan', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Lokasi', 'lokasi')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable()
                ->searchable(),

            Column::make('Longitude', 'longitude')
                ->sortable()
                ->searchable(),

            Column::make('Latitude', 'latitude')
                ->sortable()
                ->searchable(),

            Column::make('Catatan', 'notes')
                ->sortable()
                ->searchable(),

            Column::make('Divalidasi oleh', 'validate_by')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('kode_pegawai', 'kode_pegawai')
                ->dataSource($this->pegawai)
                ->optionLabel('name')
                ->optionValue('kode_pegawai'),
            Filter::multiSelect('status', 'status')
                ->dataSource([
                    [
                        'value' => 0,
                        'label' => 'Diajukan'
                    ],
                    [
                        'value' => 1,
                        'label' => 'Disetujui'
                    ],
                    [
                        'value' => 2,
                        'label' => 'Ditolak'
                    ],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::datepicker('created_at', 'created_at')

        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Driver $row): array
    {
        return [];
    }

    public function actionsFromView(Driver $row): View
    {
        $actions = [
            [
                'id' => 'show-btn',
                'action' => route('driver.show', $row->id),
                'label' => 'Detail'
            ]
        ];

        if (auth()->user()->can('driver-approve')) {
            $actions[] = [
                'id' => 'confirm-btn',
                'action' => 'javascript:void(0)',
                'label' => 'Confirm'
            ];

            if (auth()->user()->can('driver-delete')) {
                $actions[] = [
                    'id' => 'edit-btn',
                    'action' => route('driver.edit', $row->id),
                    'label' => 'Edit'
                ];

                $actions[] = [
                    'id' => 'delete-btn',
                    'action' => 'javascript:void(0)',
                    'label' => 'Hapus',
                ];
            }

            return view('components.dashboard.action-buttons', [
                'id' => $row->id,
                'datas' => $actions,
            ]);
        } else {
            return view('components.dashboard.single-button', [
                'id' => $row->id,
                'data' => [
                    'id' => 'detailBtn' . $row->id,
                    'action' => route('driver.show', $row->id),
                    'label' => 'Detail',
                ]
            ]);
        }
    }
}
