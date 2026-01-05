<?php

namespace App\Livewire;

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

    public function setUp(): array
    {
        return [
            PowerGrid::header(),
            PowerGrid::footer(),
        ];
    }

    public function datasource()
    {
        $production = Production::where('id', $this->id)->first();
        $packingList = $production?->packing_list ?? [];

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
            ->add('nama_barang')
            ->add(fieldName: 'qty_barang')
            ->add('satuan_barang')
            ->add('nama_ekspedisi');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'id'),
            Column::action('Aksi'),
            Column::make('Nama Ekspedisi', 'nama_ekspedisi'),
            Column::make('Nama Barang', 'nama_barang'),
            Column::make('Jumlah', 'qty_barang'),
            Column::make('Satuan', 'satuan_barang'),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('print')
                ->slot('Print')
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->dispatch('printPackingList', [
                    'id' => $row->id_barang,
                    'nama_ekspedisi' => $row->nama_ekspedisi,
                    'nama_barang' => $row->nama_barang,
                    'jumlah_barang' => $row->qty_barang,
                    'satuan_barang' => $row->satuan_barang,
                    'note' => $row->note,
                ]),
            Button::add('addKit')
                ->slot('Tambah Kit')
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->dispatch('addKit', ['id' => $row->id_barang]),
        ];
    }
}
