<?php

/** Goal: PowerGrid table representing placements, Caller: Placement dashboard, Deps: Placement model, HandlesErrors */

namespace App\Livewire\PowergridTables;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Placement;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PlacementTable extends PowerGridComponent
{
    use HandlesErrors;

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
            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Placement::query()->with(['hrds.pegawai', 'managements.pegawai']);
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
                        'name' => Str::limit($query->alamat, 40),
                    ]
                )
                    ->render();
            })
            ->add('longitude', function ($query) {
                return view('components.dashboard.date-w-name', [
                    'date' => $query->radius.' Meter',
                    'name' => Str::limit($query->latitude.', '.$query->longitude, 8),
                ])
                    ->render();
            })
            ->add('hrd_names', function ($query) {
                return $query->hrds->map(fn ($user) => $user->pegawai?->nick_name ?? $user->name)->implode(', ') ?: '-';
            })
            ->add('management_names', function ($query) {
                return $query->managements->map(fn ($user) => $user->pegawai?->nick_name ?? $user->name)->implode(', ') ?: '-';
            })
            ->add('restrict_app')
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY, HH:mm'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id'),
            Column::make('Kode', 'kode_penempatan')
                ->sortable()
                ->searchable(),

            Column::make('Penempatan', 'penempatan')
                ->sortable()
                ->searchable(),

            Column::make('Tim HRD', 'hrd_names')
                ->searchable(),

            Column::make('Tim Manajemen', 'management_names')
                ->searchable(),

            Column::make('Lokasi', 'longitude')
                ->sortable()
                ->searchable(),

            Column::make('Pembatasan', 'restrict_app')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actionsFromView(Placement $row): View
    {
        $actions = [
            [
                'id' => 'edit-btn',
                'action' => route('placement.edit', $row->id),
                'label' => 'Edit',
            ],
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('placement-delete'),
        ]);
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[On('confirmDeleteAction')]
    public function confirmDelete(int $id): void
    {
        $this->runSafely(function () use ($id) {
            $data = Placement::query()->findOrFail($id);
            $data->delete();
            $this->dispatch('swal', title: 'Terhapus!', text: 'Data yang dipilih berhasil dihapus.', icon: 'success');
        }, "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>");
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
