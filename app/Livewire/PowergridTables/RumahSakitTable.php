<?php

/** Goal: Display RumahSakit list table, Caller: rs.index route, Deps: RumahSakit */

namespace App\Livewire\PowergridTables;

use App\Models\RumahSakit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class RumahSakitTable extends PowerGridComponent
{
    public string $tableName = 'RumahSakitTable';

    public string $primaryKey = 'id_rumah_sakit';

    public string $sortField = 'id_rumah_sakit';

    public bool $deferLoading = true;

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
        return RumahSakit::query()->orderBy('nama_rumah_sakit');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_rumah_sakit')
            ->add('nama_rumah_sakit')
            ->add('alamat', fn ($r) => \Str::limit($r->alamat, 40))
            ->add('no_telepon', fn ($r) => $r->no_telepon ?? '-')
            ->add('layanan_formatted', fn ($r) => collect($r->layanan_list)
                ->map(fn ($l) => "<span class='inline-block px-1.5 py-0.5 text-xs rounded bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 mr-1'>{$l}</span>")
                ->implode(''))
            ->add('koordinat_formatted', fn ($r) => "<span class='text-xs text-emerald-600'>{$r->latitude}, {$r->longitude}</span>");
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi')->bodyAttribute('text-center'),
            Column::make('ID', 'id_rumah_sakit')->sortable(),
            Column::make('Nama RS', 'nama_rumah_sakit')->sortable()->searchable(),
            Column::make('Alamat', 'alamat'),
            Column::make('Telepon', 'no_telepon'),
            Column::make('Layanan', 'layanan_formatted'),
            Column::make('Koordinat', 'koordinat_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nama_rumah_sakit', 'rumah_sakit_rujukan.nama_rumah_sakit')->placeholder('Cari nama RS'),
        ];
    }

    public function delete(int $id): void
    {
        $rs = RumahSakit::find($id);

        if ($rs) {
            $nama = $rs->nama_rumah_sakit;
            $rs->delete();
            $this->dispatch('swal', title: 'Berhasil', text: "Data RS {$nama} berhasil dihapus.", icon: 'success');
        }
    }

    public function restore(int $id): void
    {
        $rs = RumahSakit::withTrashed()->find($id);

        if ($rs) {
            $nama = $rs->nama_rumah_sakit;
            $rs->restore();
            $this->dispatch('swal', title: 'Berhasil', text: "Data RS {$nama} berhasil dikembalikan.", icon: 'success');
        }
    }

    public function actionsFromView(RumahSakit $row)
    {
        return Blade::render("
            <div class='flex gap-2 justify-center'>
                @if(!\$row->trashed())
                    <x-button.primary href=\"{{ route('rs.edit', \$row->id_rumah_sakit) }}\" wire:navigate>Edit</x-button.primary>
                    <x-button.danger type=\"button\"
                        x-on:click=\"Swal.fire({
                            title: 'Hapus Rumah Sakit?',
                            text: 'Data RS {{ \$row->nama_rumah_sakit }} akan dihapus.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                \$wire.delete({{ \$row->id_rumah_sakit }});
                            }
                        })\">
                        Hapus
                    </x-button.danger>
                @else
                    <x-button.secondary type=\"button\" wire:click=\"restore({{ \$row->id_rumah_sakit }})\">
                        Restore
                    </x-button.secondary>
                @endif
            </div>
        ", ['row' => $row]);
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
