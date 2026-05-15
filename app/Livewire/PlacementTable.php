<?php

namespace App\Livewire;

use \App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class PlacementTable extends PowerGridComponent
{
    public string $tableName = 'PlacementTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
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
        return Placement::with(['hrds', 'managements']);
    }

    public function relationSearch(): array
    {
        return [
            'hrds' => [
                'name',
            ],
            'managements' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_penempatan')
            ->add('penempatan', function ($query) {
                return view(
                    'components.dashboard.date-w-name',
                    [
                        'date' => $query->penempatan,
                        'name' => $query->alamat
                    ]
                )
                    ->render();
            })
            ->add('longitude', function ($query) {
                return view('components.dashboard.date-w-name', [
                    'date' => $query->radius . ' Meter',
                    'name' => $query->latitude . ', ' . $query->longitude
                ])
                    ->render();
            })
            ->add('hrd_names', function ($query) {
                return $query->hrds->pluck('name')->implode(', ') ?: '-';
            })
            ->add('management_names', function ($query) {
                return $query->managements->pluck('name')->implode(', ') ?: '-';
            })
            ->add('restrict_app')
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id'),
            Column::make('Kode penempatan', 'kode_penempatan')
                ->sortable()
                ->searchable(),

            Column::make('Penempatan', 'penempatan')
                ->sortable()
                ->searchable(),

            Column::make('Tim HRD', 'hrd_names')
                ->searchable(),
                
            Column::make('Tim Manajemen', 'management_names')
                ->searchable(),

            Column::make('Longitude', 'longitude')
                ->sortable()
                ->searchable(),

            Column::make('Restrict app', 'restrict_app')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actionsFromView(Placement $row)
    {
        $actions = [
            [
                'id' => 'edit-btn',
                'action' => route('placement.edit', $row->id),
                'label' => 'Edit'
            ]
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('placement-delete'),
        ]);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDelete($id, Request $request): void
    {
        $data = Placement::find($id);

        if (!$data) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');
            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data yang dipilih berhasil dihapus.', 'success');

            Log::info($request->user() . " : Menghapus data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            Log::info($request->user()->kode_pegawai . " : Gagal menghapus data {$id}. {$e->getMessage()}");
        }
    }

    public function swal($title, $text, $icon)
    {
        return $this->dispatch(
            'swal',
            title: $title,
            text: $text,
            icon: $icon
        );
    }
}
