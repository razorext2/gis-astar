<?php

namespace App\Livewire;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SpkTable extends PowerGridComponent
{
    public string $tableName = 'SpkTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public string $sortDirection = 'asc';

    public bool $multiSort = true;

    public $user;

    public function setUp(): array
    {
        $this->user = auth()->user();

        if ($this->user->can('spk-delete')) {
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
        return SpkMain::query()
            ->select($this->datasourceTableColumns())
            ->addSelect([
                'customer_nama_perusahaan' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer, '$.nama_perusahaan'))"),
                'customer_contact_person' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer, '$.contact_person'))"),
                'products_name' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(products, '$.nama_barang'))"),
            ]);
    }

    protected function datasourceTableColumns(): array
    {
        return [sprintf('%s.*', (new SpkMain)->getTable())];
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no', fn ($query, int $index) => $index + 1)
            ->add('nomor_order')
            ->add('nomor_order_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => strtoupper($query->tipe_tagihan).' ('.$query->tipe_bayar.')',
                    'name' => $query->nomor_order,
                    'item3' => $query->status_description,
                ]);
            })
            ->add('tipe_tagihan')
            ->add('nomor_tagihan')
            ->add('nomor_tagihan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->status_nomor_tagihan_description,
                    'name' => $query->nomor_tagihan ?? '-',
                ]);
            })
            ->add('customer_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->customer_contact_person ?? data_get($query->customer, 'contact_person', '-'),
                    'name' => $query->customer_nama_perusahaan ?? data_get($query->customer, 'nama_perusahaan', '-'),
                    'item3' => $query->customer['no_hp'] ?? '-',
                ]);
            })
            ->add('products_formatted', function ($query) {
                $products = $query->products;

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

                        return $qty !== null ? "- {$name} ({$qty} Unit)" : $name;
                    })
                    ->filter()
                    ->values()
                    ->all();

                return implode('<br>', $list);
            })
            ->add('informasi_pengiriman')
            ->add('informasi_pengiriman_formatted', function ($query) {
                $data = $query->informasi_pengiriman;

                if (is_null($data)) {
                    return 'SPK belum dikirim';
                }

                return view('components.dashboard.name-w-code', [
                    'code' => $data['estimated_time_departure'] ?? '-',
                    'name' => $data['no_kontrak'] ?? '-',
                    'item3' => $data['estimated_time_arrival'] ?? '-',
                ]);
            })
            ->add('status_approval')
            ->add('status_approval_formatted', function ($query) {
                $colors = match ($query->status_approval) {
                    0 => 'yellow',
                    1 => 'green',
                    2 => 'red',
                    3 => 'yellow',
                    default => 'yellow'
                };

                $template = "
                    <div class='flex flex-col  gap-1'>
                        <span class='bg-{$colors}-500 w-fit text-xs px-4 py-1 text-{$colors}-700 items-center flex rounded-full'>
                            {$query->status_approval_description}
                        </span>";

                if ($query->on_delay === 1) {
                    $template .= "
                        <span class='bg-red-400 text-xs px-2 py-1 text-red-700 text-center w-fit items-center flex rounded-full'>
                            DELAYED
                        </span>";
                }

                $template .= '</div>';

                return $template;
            })
            ->add('status')
            ->add('created_at');
    }

    public function columns(): array
    {
        $table = (new SpkMain)->getTable();

        return [
            Column::make('No.', 'no'),

            Column::action('Action'),

            Column::make('SPK', 'nomor_order_formatted', 'nomor_order')
                ->sortable()
                ->searchable(),

            Column::make('Tipe Tagihan', 'tipe_tagihan')
                ->hidden(),

            Column::make('Status SPK', 'status_approval_formatted', 'status_approval')
                ->sortable()
                ->searchable(),

            Column::make('Nomor Penagihan', 'nomor_tagihan_formatted', 'nomor_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Customer', 'customer_formatted', 'customer')
                ->searchable()
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.nama_perusahaan')) LIKE ?")
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.contact_person')) LIKE ?"),

            // Column::make('Barang Dipesan', 'products_formatted', 'products')
            //     ->searchable()
            //     ->searchableRaw("JSON_SEARCH($table.products, 'one', ?, NULL, '$[*].nama_barang') IS NOT NULL"),

            Column::make('Status Pengiriman', 'informasi_pengiriman_formatted'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nomor_order', 'nomor_order')
                ->placeholder('Nomor SPK'),
            Filter::select('tipe_tagihan', 'tipe_tagihan')
                ->dataSource([
                    ['value' => 'idcnonppn', 'label' => 'IDC Non PPN'],
                    ['value' => 'idcppn', 'label' => 'IDC PPN'],
                    ['value' => 'idyppn', 'label' => 'IDY PPN'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::select('status_approval', 'status_approval')
                ->dataSource([
                    ['label' => 'Menunggu Persetujuan', 'value' => 0],
                    ['label' => 'Disetujui', 'value' => 1],
                    ['label' => 'Ditolak', 'value' => 2],
                    ['label' => 'Butuh Revisi', 'value' => 3],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }

    public function actions(SpkMain $row): array
    {
        $button = [];

        if ($this->user->can('spk-edit')) {
            $button[] = Button::make('edit')
                ->slot('Edit')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('spk.edit', ['spk' => $row->id]);
        }

        if ($this->user->can('spk-detail')) {
            $button[] = Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->route('spk.show', ['spk' => $row->id]);
        }

        // if ($this->user->can('spk-validate')) {
        //     $button[] = Button::make('detail')
        //         ->slot('Approve')
        //         ->id($row->id)
        //         ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700');
        // }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
