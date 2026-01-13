<?php

namespace App\Livewire;

use App\Models\Spk\Production;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProductionTable extends PowerGridComponent
{
    public string $tableName = 'ProductionTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $user;

    public function setUp(): array
    {
        $this->user = auth()->user();

        if ($this->user->can('production-delete')) {
            $this->showCheckBox();
        }

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Production::query()
            ->with(['spk', 'assignTo', 'productionHistories']);

        if ($this->user->cannot('spk-create')) {
            $query->whereHas('spk', fn ($query) => $query->where('status_approval', 1)->where('on_delay', 0))
                ->whereHas('productionHistories', fn ($query) => $query->where('status_produksi', '>', 0))
                ->where('assign_to', $this->user->id);
        }

        $query->orderBy('created_at', 'desc');

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'spk' => [
                'nomor_order',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no', fn ($query, int $index) => $index + 1)
            ->add('customer_info', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->spk->customer['contact_person'] ?? '-',
                    'name' => $query->spk->customer['nama_perusahaan'] ?? '-',
                    'item3' => $query->spk->customer['alamat'] ?? '-',
                ]);
            })
            ->add('id_spk')
            ->add('nomor_order', fn ($query) => $query->spk->nomor_order ?? '-')
            ->add('nomor_order_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->spk->nomor_tagihan ?? 'Nomor tagihan belum ada.',
                    'name' => $query->spk->nomor_order ?? '-',
                ]);
            })
            ->add('assign_to')
            ->add('assign_to_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => 'Kode Pegawai: '.($query->assignTo->kode_pegawai ?? '-'),
                    'name' => $query->assignTo->name ?? '-',
                ]);
            })
            ->add('products_formatted', function ($query) {
                $products = $query->spk->products;

                if (is_string($products)) {
                    $decoded = json_decode($products, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $products = $decoded;
                    }
                }

                $list = collect($products ?? [])
                    ->map(function ($product) {
                        if (is_object($product)) {
                            $product = (array) $product;
                        }

                        $name = $product['nama_barang'] ?? '-';
                        $qty = $product['jumlah_unit'] ?? null;

                        return $qty !== null ? "{$name} ({$qty} Unit)" : $name;
                    })
                    ->filter()
                    ->values()
                    ->all();

                return implode('<br>', $list);
            })
            ->add('status_produksi', fn ($query) => $query->productionHistories->last()->status_produksi ?? 0)
            ->add('status_produksi_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => '',
                    'name' => ucfirst($query->productionHistories?->last()->status_produksi_description['label']),
                ]);
            })
            ->add('packing_list')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'no'),
            Column::action('Action'),
            Column::make('Nomor SPK', 'nomor_order_formatted', 'nomor_order')
                ->searchable(),
            Column::make('Customer', 'customer_info'),
            Column::make('Assign to', 'assign_to_formatted', 'assign_to'),
            Column::make('Products', 'products_formatted'),
            Column::make('Status produksi', 'status_produksi_formatted', 'status_produksi'),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actions(Production $row)
    {
        $button = [];

        if ($this->user->can('produksi-detail')) {
            $button[] = Button::make('detail', 'Detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->route('production.show', ['production' => $row->id]);
        }

        if ($row->productionHistories?->last()?->status_produksi === 10 && $this->user->can('produksi-update-packing-list')) {
            $button[] = Button::make('packinglist', 'Packing List')
                ->slot('Packing List')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('production.packing-list.add', ['production' => $row->id]);
        }

        return $button;
    }
}
