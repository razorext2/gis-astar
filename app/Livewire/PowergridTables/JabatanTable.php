<?php

namespace App\Livewire\PowergridTables;

use App\Models\Division;
use App\Models\Jabatan;
use App\Models\Placement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

/** Goal: Display Jabatan table with multiple supervisors column formatted, Caller: Livewire, Deps: Jabatan */
final class JabatanTable extends PowerGridComponent
{
    public string $tableName = 'JabatanTable';

    public bool $deferLoading = true;

    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
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
        return Jabatan::query()
            ->with(['divisionRelasi', 'placementRelasi', 'supervisors', 'pegawai'])
            ->orderBy('nama_jabatan', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'placementRelasi' => [
                'penempatan',
            ],
            'divisionRelasi' => [
                'nama_divisi',
            ],
            'supervisors' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama_jabatan')
            ->add('nama_jabatan_formatted', function ($query) {
                $supervisorsList = $query->supervisors->pluck('name')->implode(', ') ?: 'Belum diatur.';

                return view('components.dashboard.name-w-code', [
                    'code' => '',
                    'name' => $query->nama_jabatan,
                    'item3' => $supervisorsList,
                ]);
            })
            ->add('divisi', fn ($query) => $query->divisionRelasi->nama_divisi)
            ->add('penempatan', fn ($query) => $query->placementRelasi->penempatan)
            ->add('pegawai_list', function ($query) {
                $items = $query->pegawai->map(fn ($p) => $p->full_name)->toArray();

                return view('components.table-component.tags', ['items' => $items]);
            })
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id')
                ->hidden(),
            Column::make('Nama jabatan', 'nama_jabatan_formatted', 'nama_jabatan')
                ->sortable()
                ->searchable(),

            Column::make('Divisi', 'divisi'),

            Column::make('Penempatan', 'penempatan'),

            Column::make('Pegawai', 'pegawai_list'),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        $penempatan = Placement::select(['id', 'penempatan'])->get();
        $divisi = Division::select(['id', 'nama_divisi'])->get();

        return [
            Filter::inputText('nama_jabatan', 'nama_jabatan')
                ->placeholder('Nama Jabatan'),

            Filter::select('penempatan', 'penempatan')
                ->dataSource(collect($penempatan))
                ->optionLabel('penempatan')
                ->optionValue('id'),

            Filter::select('divisi', 'divisi')
                ->dataSource(collect($divisi))
                ->optionLabel('nama_divisi')
                ->optionValue('id'),
        ];
    }

    public function actionsFromView(Jabatan $row)
    {
        $actions = [
            [
                'id' => 'edit-btn',
                'action' => route('jabatan.edit', $row->id),
                'label' => 'Edit',
            ],
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('jabatan-delete'),
        ]);
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[On('confirmDeleteAction')]
    public function confirmDelete(int $id, Request $request): void
    {
        $data = Jabatan::find($id);

        if (! $data) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data yang dipilih berhasil dihapus.', 'success');

            Log::info($request->user()." : Menghapus data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            Log::info($request->user()->kode_pegawai." : Gagal menghapus data {$id}. {$e->getMessage()}");
        }
    }

    public function swal(string $title, string $text, string $icon)
    {
        return $this->dispatch(
            'swal',
            title: $title,
            text: $text,
            icon: $icon
        );
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
