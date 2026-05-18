<?php

namespace App\Livewire;

use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProductionTable extends PowerGridComponent
{
    public string $tableName = 'ProductionTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $user;

    public ?string $tipe_timbangan = null;

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
            ->join('tb_spk', 'tb_spk.id', '=', 'tb_produksi.id_spk')
            ->addSelect(['tb_produksi.*'])
            ->with(['spk', 'assignTo', 'productionHistories'])
            ->whereHas('spk', function (Builder $q) {
                // filter tipe timbangan
                if (! is_null($this->tipe_timbangan)) {
                    $q->where('tipe_timbangan', $this->tipe_timbangan);
                }

                // auth rule
                if ($this->user->cannot('spk-create')) {
                    $q->where('status_approval', 1) // spk udh disetujui
                        ->where('on_delay', 0) // ga delay
                        ->where('is_booked', 0) // ga lg booking
                        ->where('is_cancelled', 0) // ga dicancel
                        ->where('status', '>=', 2); // dalam proses produksi / update pr / is_using_old_stock
                }
            });

        // filter diluar spk
        if ($this->user->cannot('spk-create')) {
            $query->whereHas('productionHistories', fn ($history) => $history->where('status_produksi', '>', 0))
                ->where(function ($q) {
                    $q->where('tb_produksi.assign_to', $this->user->id)
                        ->orWhere('tb_produksi.reassign_to', $this->user->id);
                });
        }

        $query->orderByDesc('tb_produksi.created_at');

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'spk' => [
                'nomor_order',
                'tipe_timbangan',
                'company_name',
            ],
            'productionHistories' => [
                'status_produksi',
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
                    'code' => '',
                    'name' => data_get($query->spk->customer, 'nama_perusahaan', '-'),
                    'item3' => '',
                ]);
            })
            ->add('id_spk')
            ->add('nomor_order', fn ($query) => $query->spk->nomor_order)
            ->add('nomor_order_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->spk->nomor_tagihan ?? 'Nomor tagihan belum ada.',
                    'name' => $query->spk->nomor_order.($query->spk->revision_count ? 'R'.str_pad($query->spk->revision_count, 2, '0', STR_PAD_LEFT) : ''),
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
            ->add('status_spk', function ($query) {
                $template = "<div class='flex flex-col gap-1 w-fit font-semibold'>";

                if ($query->spk->on_delay) {
                    $template .= "
                        <span class='bg-red-500 text-xs px-2 flex justify-center items-center py-1.5 text-red-100 w-fit rounded-full'>
                            Delayed
                        </span>";
                }

                if ($query->spk->status_approval === 2) {
                    $template .= "
                        <span class='bg-red-500 text-xs px-2 flex justify-center items-center py-1.5 text-red-100 w-fit rounded-full'>
                            SPK Ditolak
                        </span>";
                }

                if ($query->spk->is_using_old_stock) {
                    $template .= "
                        <span class='bg-green-300 text-green-700 text-xs px-2  py-1.5 rounded-lg w-fit'>
                            Stok Lama
                        </span>";
                }

                if ($query->spk->is_using_company_driver) {
                    $template .= "
                        <span class='bg-blue-400 text-blue-700 text-xs px-2  py-1.5 rounded-lg w-fit'>
                            Supir Perusahaan
                        </span>";
                }

                if ($query->spk->is_picked_up_by_customer) {
                    $template .= "
                        <span class='bg-purple-400 text-purple-700 text-xs px-2.5 py-1 rounded-lg w-fit'>
                            Dijemput Customer
                        </span>";
                }

                $template .= '</div>';

                return $template;
            })
            ->add('status_produksi', fn ($query) => $query->productionHistories->last()->status_produksi ?? 0)
            ->add('status_produksi_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => '',
                    'name' => ucfirst($query->productionHistories?->last()->status_produksi_description['label'] ?? '-'),
                ]);
            })
            ->add('packing_list')
            ->add('created_at')
            ->add('tipe_timbangan', fn ($query) => $query->spk->tipe_timbangan)
            ->add('tipe_timbangan_formatted', function ($query) {
                $latest_status_produksi = $query->productionHistories?->last()?->status_produksi ? $query->productionHistories->last()->status_produksi_description['label'] : 'Belum ada progres.';

                // dump($productionHistories);

                return view('components.dashboard.name-w-code', [
                    'code' => '',
                    'name' => ucwords($query->spk->tipe_timbangan),
                    'item3' => ucwords($latest_status_produksi),
                ]);
            })
            ->add('is_using_company_driver', fn ($query) => $query->spk->is_using_company_driver)
            ->add('is_picked_up_by_customer', fn ($query) => $query->spk->is_picked_up_by_customer)
            ->add('is_using_old_stock', fn ($query) => $query->spk->is_using_old_stock);
    }

    public function columns(): array
    {
        $table = (new SpkMain)->getTable();

        return [
            Column::make('No', 'no'),
            Column::action('Action'),
            Column::make('Nomor SPK', 'nomor_order_formatted', 'nomor_order')
                ->searchable(),
            Column::make('Status SPK', 'status_spk', 'status_spk'),
            Column::make('Supir perusahaan', 'is_using_company_driver')->hidden(),
            Column::make('Dijemput Customer', 'is_picked_up_by_customer')->hidden(),
            Column::make('Old Stock', 'is_using_old_stock')->hidden(),
            Column::make('Customer', 'customer_info', 'company_name')
                ->searchable(),
            Column::make('Assign to', 'assign_to_formatted', 'assign_to'),
            Column::make('Tipe Timbangan', 'tipe_timbangan_formatted', 'tipe_timbangan'),
            Column::make('Products', 'products_formatted'),
            Column::make('Status produksi', 'status_produksi_formatted', 'status_produksi'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('tipe_timbangan', 'tipe_timbangan')
                ->dataSource([
                    ['value' => 'non timbangan jembatan', 'label' => 'Timbangan Lainnya'],
                    ['value' => 'timbangan jembatan', 'label' => 'Timbangan Jembatan'],
                ])
                ->optionLabel('label')
                ->optionValue('value')
                ->builder(function ($builder, $value) {
                    $builder->whereHas('spk', function ($q) use ($value) {
                        $q->where('tipe_timbangan', $value);
                    });
                }),
            Filter::boolean('is_using_company_driver', field: 'is_using_company_driver')
                ->label('Ya', 'Tidak'),
            Filter::boolean('is_picked_up_by_customer', field: 'is_picked_up_by_customer')
                ->label('Ya', 'Tidak'),
            Filter::boolean('is_using_old_stock', field: 'is_using_old_stock')
                ->label('Ya', 'Tidak'),
        ];
    }

    public function actions(Production $row)
    {
        $button = [];

        if ($this->user->can('spk-detail')) {
            $button[] = Button::make('detail', 'Detail')
                ->slot('👁 SPK')
                ->id($row->spk->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->route('spk.show', ['spk' => $row->spk->id]);
        }

        if ($this->user->can('produksi-detail')) {
            $button[] = Button::make('detail', 'Detail')
                ->slot('+ Produksi')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->route('production.show', ['production' => $row->id]);
        }

        if ($row->productionHistories?->last()?->status_produksi === 10 && $this->user->can('produksi-update-packing-list') && $row->spk->is_using_company_driver == false) {
            $button[] = Button::make('packinglist', 'Packing List')
                ->slot('+ Packing List')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route('production.packing-list.add', ['production' => $row->id]);
        }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
