<?php

namespace App\Livewire;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

/** Goal: Display Jabatan table with multiple supervisors column formatted, Caller: Livewire, Deps: Jabatan */

final class JabatanTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'JabatanTable';

    public bool $deferLoading = true;

    public bool $showFilters = true;

    public $penempatan;

    public $divisi;

    public function setUp(): array
    {
        $this->penempatan = \App\Models\Placement::select('id', 'penempatan')->get();
        $this->divisi = \App\Models\Division::select('id', 'nama_divisi')->get();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),

            PowerGrid::exportable(fileName: 'jabatanReport-'.now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS),

            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Jabatan::query()
            ->with(['divisionRelasi', 'placementRelasi', 'supervisors'])
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
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->visibleInExport(false)
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id')
                ->hidden(),
            Column::make('Nama jabatan', 'nama_jabatan_formatted', 'nama_jabatan')
                ->sortable()
                ->searchable(),

            Column::make('Divisi', 'divisi'),

            Column::make('Penempatan', 'penempatan'),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nama_jabatan', 'nama_jabatan')
                ->placeholder('Nama Jabatan'),

            Filter::select('penempatan', 'penempatan')
                ->dataSource(collect($this->penempatan))
                ->optionLabel('penempatan')
                ->optionValue('id'),

            Filter::select('divisi', 'divisi')
                ->dataSource(collect($this->divisi))
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

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDelete($id, Request $request): void
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
