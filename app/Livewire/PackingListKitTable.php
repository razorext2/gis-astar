<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Riskihajar\Terbilang\Facades\Terbilang;

final class PackingListKitTable extends PowerGridComponent
{
    public string $tableName = 'PackingListKitTable';

    public $idbarang;

    public function datasource(): Collection
    {
        $data = \App\Models\Spk\PackingListKit::where('id_barang_produksi', $this->idbarang)->get()->toArray();

        return collect($data);
    }

    public function setUp(): array
    {
        return [
            PowerGrid::header(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama_kit')
            ->add('nama_kit_formatted', function ($row) {
                $jmlh = $row->jumlah_kit;
                $jmlh_terbilang = ucfirst(Terbilang::make($jmlh));
                $satuan = $row->satuan_kit;

                return $jmlh.' ('.$jmlh_terbilang.') '.$satuan.' '.$row->nama_kit;
            })
            ->add('peti', function ($row) {

                $peti = $row->peti;

                // Normalisasi jika JSON string
                if (is_string($peti)) {
                    $peti = json_decode($peti, true);
                }

                if (! is_array($peti)) {
                    return null;
                }

                return collect($peti)
                    ->map(function ($box) {

                        $box = (array) $box;

                        $boxName = $box['box_name'] ?? null;

                        if (! $boxName) {
                            return null;
                        }

                        $kitsOutput = collect($box['kits'] ?? [])
                            ->map(fn ($kit) => (array) $kit)
                            ->filter(fn ($kit) => ! empty($kit['kit_name']) &&
                                ! empty($kit['kit_qty']) &&
                                ! empty($kit['kit_unit'])
                            )
                            ->map(fn ($kit) => "{$kit['kit_name']} {$kit['kit_qty']} {$kit['kit_unit']}"
                            )
                            ->implode('<br>');

                        return $kitsOutput
                            ? "<strong>{$boxName}</strong><br>{$kitsOutput}"
                            : "<strong>{$boxName}</strong>";

                    })
                    ->filter()
                    ->implode('<br><br>');
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),

            Column::make('Name', 'nama_kit_formatted', 'nama_kit'),

            Column::make('Peti', 'peti'),

        ];
    }

    public function actions($row)
    {
        return [
            Button::add('remove')
                ->slot('Hapus')
                ->class('dark:bg-red-800 text-sm dark:hover:bg-red-900 dark:text-white dark:border-zinc-800 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-red-700')
                ->dispatch('deletePackingListKit', ['id' => $row->id]),
        ];
    }
}
