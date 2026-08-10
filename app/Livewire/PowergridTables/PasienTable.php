<?php

/** Goal: Display Pasien list table, Caller: pasien.index route, Deps: Pasien */

namespace App\Livewire\PowergridTables;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PasienTable extends PowerGridComponent
{
    public string $tableName = 'PasienTable';

    public string $primaryKey = 'id_pasien';

    public string $sortField = 'id_pasien';

    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()->showSearchInput()->showToggleColumns(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Pasien::query()->with(['user'])->orderBy('nama');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id_pasien')
            ->add('nik')
            ->add('nama')
            ->add('jenis_kelamin_formatted', fn ($r) => $r->jenis_kelamin->label())
            ->add('no_telepon', fn ($r) => $r->no_telepon ?? '-')
            ->add('koordinat_formatted', fn ($r) => $r->hasCoordinates()
                ? "<span class='text-emerald-600 dark:text-emerald-400 text-xs font-medium'>✓ {$r->latitude}, {$r->longitude}</span>"
                : "<span class='text-amber-500 text-xs'>Belum diisi</span>")
            ->add('created_at_formatted', fn ($r) => Carbon::parse($r->created_at)->locale('id')->isoFormat('DD MMM YYYY'));
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi')->bodyAttribute('text-center'),
            Column::make('ID', 'id_pasien')->sortable(),
            Column::make('NIK', 'nik')->searchable(),
            Column::make('Nama Pasien', 'nama')->sortable()->searchable(),
            Column::make('Jenis Kelamin', 'jenis_kelamin_formatted'),
            Column::make('No. Telepon', 'no_telepon'),
            Column::make('Koordinat', 'koordinat_formatted'),
            Column::make('Terdaftar', 'created_at_formatted', 'created_at')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nik', 'pasien.nik')->placeholder('Cari NIK'),
            Filter::inputText('nama', 'pasien.nama')->placeholder('Cari Nama'),
        ];
    }

    public function actionsFromView(Pasien $row)
    {
        return Blade::render("
            <div class='flex gap-2 justify-center'>
                <x-button.primary href=\"{{ route('pasien.edit', \$row->id_pasien) }}\" wire:navigate>Edit</x-button.primary>
            </div>
        ", ['row' => $row]);
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
