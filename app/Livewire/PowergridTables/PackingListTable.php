<?php

/** Goal: PowerGrid table representing SPK Packing Lists, Caller: Production packing list view, Deps: Production model */

namespace App\Livewire\PowergridTables;

use App\Models\Spk\Production;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PackingListTable extends PowerGridComponent
{
    public string $tableName = 'PackingListTable';

    public ?string $id;

    public ?Production $production = null;

    public function setUp(): array
    {
        return [
            PowerGrid::header(),
            PowerGrid::footer(),
        ];
    }

    public function datasource()
    {
        $this->production = Production::select('id', 'packing_list')->where('id', $this->id)->first();
        $packingList = $this->production?->packing_list ?? [];

        if (is_string($packingList)) {
            $decoded = json_decode($packingList, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $packingList = $decoded;
            }
        }

        return collect($packingList)->map(function ($item, $index) {
            if (is_object($item)) {
                $item = (array) $item;
            }

            if (is_array($item)) {
                return array_merge(['id' => $item['id'] ?? $index + 1], $item);
            }

            return [
                'id' => $index + 1,
                'products' => $item,
            ];
        });
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id_barang')
            ->add('nama_ekspedisi')
            ->add('nama_ekspedisi_formatted', function ($row) {
                return view('components.dashboard.name-w-code', [
                    'code' => strtoupper($row->packing_list_type ?? 'Default'),
                    'name' => $row->nama_ekspedisi,
                ]);
            })
            ->add('nama_barang')
            ->add(fieldName: 'qty_barang')
            ->add('satuan_barang');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id'),
            Column::action('Aksi'),
            Column::make('Nama Ekspedisi', 'nama_ekspedisi')
                ->hidden(),
            Column::make('Nama Ekspsedisi', 'nama_ekspedisi_formatted'),
            Column::make('Nama Barang', 'nama_barang'),
            Column::make('Jumlah', 'qty_barang'),
            Column::make('Satuan', 'satuan_barang'),
        ];
    }

    /**
     * @param  object|array  $row
     */
    public function actions($row): array
    {
        $buttons = [
            Button::add('delete')
                ->slot('Hapus')
                ->class('dark:bg-red-800 text-sm dark:hover:bg-red-900 dark:text-white dark:border-zinc-800 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-red-700')
                ->dispatch('deletePackingList', ['id' => $row->id_barang]),
        ];

        $buttons[] = Button::add('addKit')
            ->slot('Detail')
            ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
            ->route('production.packing-list.kits.add', ['idbarang' => $row->id_barang, 'production' => $this->production->id]);

        if ($row->packing_list_type === 'manual') {
            $buttons[] = Button::add('print')
                ->slot('Print')
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->dispatch('printPackingList', [
                    'id' => $row->id_barang,
                    'nama_ekspedisi' => $row->nama_ekspedisi,
                    'nama_barang' => $row->nama_barang,
                    'jumlah_barang' => $row->qty_barang,
                    'satuan_barang' => $row->satuan_barang,
                    'note' => $row->note,
                ]);
        }

        return $buttons;
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
