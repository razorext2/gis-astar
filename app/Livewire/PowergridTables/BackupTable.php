<?php

namespace App\Livewire\PowergridTables;

use App\Models\Backup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class BackupTable extends PowerGridComponent
{
    public string $tableName = 'BackupTable';

    public bool $deferLoading = true;

    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
                ->fixedColumns('name'),
        ];
    }

    public function datasource(): Builder
    {
        return Backup::query()
            ->with('user')
            ->latest();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('type')
            ->add('status', fn ($query) => Blade::render('components.table-component.state', ['status' => $query->status == 'success' ? 1 : 0]))
            ->add('user_id', fn ($query) => e($query->user->name))
            ->add('created_at')
            ->add('created_at_formatted', fn ($query) => e(Carbon::parse($query->created_at)->locale('id')->diffForHumans()));
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id')
                ->index(),
            Column::action('Action'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Tipe', 'type')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::make('Oleh', 'user_id')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('type', 'type')
                ->dataSource([
                    ['id' => 'DB', 'name' => 'Database'],
                    ['id' => 'App', 'name' => 'Application'],
                    ['id' => 'Full', 'name' => 'Full Backup'],
                ])
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::datetimepicker('created_at_formatted', 'created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                ]),
        ];
    }

    public function actions(Backup $row): array
    {
        $actions = [];

        $actions[] = Button::make('delete')
            ->slot(Blade::render('<x-icons.trash-bin class="h-5 w-5 text-white" />'))
            ->class('dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-zinc-800 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-red-700 me-0.5')
            ->dispatch('delete', ['id' => $row->id]);

        if ($row->status === 'success') {
            $actions[] = Button::make('download')
                ->slot('Download')
                ->class('dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700 me-0.5')
                ->dispatch('download', ['id' => $row->id]);
        }

        return $actions;
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[On('confirmDeleteAction')]
    public function confirmDelete(int $id)
    {
        // ganti jadi backup-delete
        if (! auth()->user()->can('backup-list')) {
            return abort(403);
        }

        $data = Backup::find($id);

        if (! $data) {
            return abort(404);
        }

        try {
            if (Storage::exists($data->file)) {
                Storage::delete($data->file);
            }

            $data->delete();

            return $this->dispatch('swal', title: 'Terhapus!', text: 'Data yang dipilih berhasil dihapus.', icon: 'success');
        } catch (\Exception $e) {
            Log::error(now().': Terjadi kegagalan saat menghapus data backup -> '.$e->getMessage());

            return $this->dispatch('swal', title: 'Gagal!', text: 'Terjadi kesalahan saat menghapus data.', icon: 'error');
        }
    }

    #[On('download')]
    public function download(int $id)
    {
        return $this->redirect(route('backup.download', $id));
    }

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }
}
