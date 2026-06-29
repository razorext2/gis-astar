<?php

/** Goal: PowerGrid table representing divisions, Caller: Division dashboard, Deps: Division model */

namespace App\Livewire\PowergridTables;

use App\Models\Division;
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

final class DivisionTable extends PowerGridComponent
{
    public string $tableName = 'DivisionTable';

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
        return Division::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_divisi')
            ->add('nama_divisi')
            ->add('created_at')
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),

            Column::make('Kode divisi', 'kode_divisi')
                ->sortable()
                ->searchable()
                ->bodyAttribute('text-center'),

            Column::make('Nama divisi', 'nama_divisi')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('kode_divisi', 'kode_divisi'),
            Filter::inputText('nama_divisi', 'nama_divisi'),
        ];
    }

    public function actions(Division $row): array
    {
        return [];
    }

    public function actionsFromView(Division $row)
    {
        $actions = [
            [
                'id' => 'edit-btn',
                'action' => route('division.edit', $row->id),
                'label' => 'Edit',
            ],
        ];

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'delete' => auth()->user()->can('divisi-delete'),
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
        $data = Division::find($id);

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
