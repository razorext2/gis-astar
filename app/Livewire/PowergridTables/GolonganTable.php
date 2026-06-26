<?php

namespace App\Livewire\PowergridTables;

use \App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class GolonganTable extends PowerGridComponent
{
    public string $tableName = 'GolonganTable';
    public bool $showFilters = true;
    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Golongan::query()
            ->with('jadwalRelasi')
            ->orderBy('nama_golongan', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama_golongan')
            ->add('alias')
            ->add('jadwal', function ($query) {
                $schedule = '';

                foreach ($query->jadwalRelasi as $jadwal) {
                    $schedule .= "<span>{$jadwal->hari} ({$jadwal->jam_masuk} - {$jadwal->jam_keluar})</span>";
                }

                return Blade::render('
                        <div class="flex flex-col">
                           ' . $schedule . ' 
                        </div>
                    ');
            })
            ->add('created_at')
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id')
                ->bodyAttribute('text-center'),
            Column::make('Nama golongan', 'nama_golongan')
                ->sortable()
                ->searchable(),

            Column::make('Alias', 'alias')
                ->sortable()
                ->searchable(),

            Column::make('Jadwal', 'jadwal'),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nama_golongan', 'nama_golongan')
                ->placeholder('Nama Golongan'),
        ];
    }

    public function actions(Golongan $row): array
    {
        return [];
    }

    public function actionsFromView(Golongan $row)
    {
        $actions = [
            [
                'id' => 'edit-btn',
                'action' => route('golongan.edit', $row->id),
                'label' => 'Edit'
            ]
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('golongan-delete'),
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
        $data = Golongan::find($id);

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

