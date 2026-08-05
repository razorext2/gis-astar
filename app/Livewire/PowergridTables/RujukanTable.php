<?php

/** Goal: Display Rujukan list table, Caller: rujukan.index, Deps: Rujukan */

namespace App\Livewire\PowergridTables;

use App\Enums\StatusRujukan;
use App\Models\Rujukan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class RujukanTable extends PowerGridComponent
{
    public string $tableName = 'RujukanTable';

    public string $primaryKey = 'id_rujukan';

    public string $sortField = 'id_rujukan';

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
        return Rujukan::query()
            ->with(['pasien', 'rumahSakit', 'user'])
            ->orderByDesc('created_at');
    }

    public function fields(): PowerGridFields
    {
        $badgeColors = [
            'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
            'disetujui' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
            'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
            'selesai' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
        ];

        return PowerGrid::fields()
            ->add('id_rujukan')
            ->add('no_rujukan')
            ->add('pasien_nama', fn ($r) => $r->pasien?->nama ?? '-')
            ->add('rumah_sakit_nama', fn ($r) => $r->rumahSakit?->nama_rumah_sakit ?? '-')
            ->add('status_formatted', function ($r) use ($badgeColors) {
                $color = $badgeColors[$r->status->value] ?? 'bg-zinc-100 text-zinc-600';
                $label = $r->status->label();

                return "<span class='inline-block px-2 py-0.5 rounded-full text-xs font-semibold {$color}'>{$label}</span>";
            })
            ->add('tanggal_formatted', fn ($r) => Carbon::parse($r->tanggal_rujukan)->locale('id')->isoFormat('DD MMM YYYY HH:mm'))
            ->add('dokter_nama', fn ($r) => $r->user?->name ?? '-');
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi')->bodyAttribute('text-center'),
            Column::make('No. Rujukan', 'no_rujukan')->searchable(),
            Column::make('Pasien', 'pasien_nama')->searchable(),
            Column::make('Rumah Sakit', 'rumah_sakit_nama')->searchable(),
            Column::make('Status', 'status_formatted', 'status')->sortable(),
            Column::make('Tanggal', 'tanggal_formatted', 'tanggal_rujukan')->sortable(),
            Column::make('Dokter', 'dokter_nama'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('no_rujukan', 'rujukan.no_rujukan')->placeholder('No. Rujukan'),
            Filter::select('status_formatted', 'rujukan.status')
                ->dataSource(collect(StatusRujukan::cases())->map(fn ($s) => ['value' => $s->value, 'label' => $s->label()]))
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }

    public function actionsFromView(Rujukan $row)
    {
        return Blade::render("
            <div class='flex gap-2 justify-center'>
                <x-button.primary href=\"{{ route('rujukan.show', \$row->id_rujukan) }}\" wire:navigate>Detail</x-button.primary>
            </div>
        ", ['row' => $row]);
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
