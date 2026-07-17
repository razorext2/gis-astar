<?php

/** Goal: Provide a reactive data table for Invoices with live search, filters, actions, and SPA navigation.
 * Caller: resources/views/dashboard/invoice/index*.blade.php
 * Deps: App\Models\Invoice, PowerComponents\LivewirePowerGrid\PowerGridComponent
 */

namespace App\Livewire\PowergridTables;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
final class InvoiceTable extends PowerGridComponent
{

    public string $tableName = 'InvoiceTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public string $sortField = 'updated_at';

    public string $sortDirection = 'desc';

    public bool $multiSort = true;

    public string $currentRoute;

    public function booted(): void
    {
        if (empty($this->currentRoute)) {
            $this->currentRoute = request()->route()?->getName() ?? '';
        }
    }

    public function setUp(): array
    {
        if (empty($this->currentRoute)) {
            $this->currentRoute = request()->route()?->getName() ?? '';
        }

        if (auth()->user()->can('invoice-delete')) {
            $this->showCheckBox();
        }

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Invoice::query()->with(['addedBy', 'latestUpdateBy', 'details']);

        return $this->applyInvoiceFilter($query);
    }

    /**
     * Apply route-based and permission-based filters to the invoice query.
     *
     * Each entry defines: the required permission, the matching route, and
     * an optional filter (either a direct column value or a JSON path on details).
     *
     * @param  Builder<Invoice>  $query
     * @return Builder<Invoice>
     */
    private function applyInvoiceFilter(Builder $query): Builder
    {
        $route = $this->currentRoute;

        /** @var array<int, array{permission: string, route: string, tipe_invoice?: string, tujuan?: string}> */
        $filterMap = [
            ['permission' => 'invoice-list',     'route' => 'invoice.all.index'],
            ['permission' => 'invoice-list',     'route' => 'invoice.medan.index', 'tipe_invoice' => 'dalkot'],
            ['permission' => 'invoice-list',     'route' => 'invoice.cust.index',  'tujuan' => 'cust'],
            ['permission' => 'invoice-list-pku', 'route' => 'invoice.pku.index',   'tujuan' => 'pku'],
            ['permission' => 'invoice-list-jkt', 'route' => 'invoice.jkt.index',   'tujuan' => 'jkt'],
        ];

        foreach ($filterMap as $filter) {
            if (! auth()->user()->can($filter['permission'])) {
                continue;
            }

            if ($filter['route'] !== $route) {
                continue;
            }

            if (isset($filter['tipe_invoice'])) {
                return $query->where('tipe_invoice', $filter['tipe_invoice']);
            }

            if (isset($filter['tujuan'])) {
                return $query->whereHas('details', fn ($q) => $q->where('informasi_pengiriman->tujuan', $filter['tujuan']));
            }

            return $query;
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'addedBy' => [
                'id',
                'kode_pegawai',
                'name',
            ],
            'latestUpdateBy' => [
                'id',
                'kode_pegawai',
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nomor_btt')
            ->add('tgl_btt')
            ->add('tgl_invoice')
            ->add('no_piutang')
            ->add('no_penjualan')
            ->add('no_faktur_pajak')
            ->add('nama_customer')
            ->add('tipe_invoice')
            ->add('status_pengiriman')
            ->add('status_awal')
            ->add('status_terbaru')
            ->add('added_by')
            ->add('latest_update_by')
            ->add('created_at')
            ->add('tipe_tagihan')
            ->add('invoice_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->nama_customer,
                    'name' => $query->no_faktur_pajak,
                    'item3' => $query->tgl_invoice,
                ]);
            })
            ->add('btt_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->tgl_btt,
                    'name' => $query->nomor_btt,
                    'item3' => Str::upper($query->tipe_tagihan) ?? '-',
                ]);
            })
            ->add('no_penjualan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->no_penjualan,
                    'name' => $query->no_piutang,
                ]);
            })
            ->add('status_formatted', function ($query) {
                $status = match ($query->status_pengiriman) {
                    '0' => 'Belum Dikirim',
                    '1' => 'Sedang Dalam Pengiriman',
                    '2' => 'Sudah Diterima',
                    '3' => 'Belum Diterima',
                    default => 'Tidak Diketahui',
                };

                return view('components.dashboard.name-w-code', [
                    'code' => $query->tipe_invoice,
                    'name' => $status,
                    'item3' => $query->status_terbaru,
                ]);
            })
            ->add('user_info_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => 'Ditambah oleh: '.$query->addedBy->name,
                    'name' => 'Terakhir update: '.$query->latestUpdateBy->name,
                    'item3' => 'Dibuat Tanggal: '.Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMMM YYYY'),
                    'is_active_code' => $query->addedBy?->is_active ?? true,
                    'is_active' => $query->latestUpdateBy?->is_active ?? true,
                ]);
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Invoice', 'invoice_formatted', 'no_faktur_pajak')
                ->sortable()
                ->searchable(),

            Column::make('Bukti Tanda Terima', 'btt_formatted', 'nomor_btt')
                ->sortable()
                ->searchable(),

            Column::make('No Penjualan', 'no_penjualan_formatted', 'no_penjualan')
                ->sortable()
                ->searchable(),

            Column::make('Status Pengiriman', 'status_pengiriman')
                ->hidden(true),
            Column::make('Nama Customer', 'nama_customer')->hidden(true),

            Column::make('Status Invoice', 'status_formatted', 'tipe_invoice'),
            Column::make('Oleh', 'user_info_formatted', 'added_by'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('no_faktur_pajak', 'no_faktur_pajak')
                ->placeholder('Cari no faktur pajak'),

            Filter::inputText('nomor_btt', 'nomor_btt')
                ->placeholder('Cari nomor btt'),

            Filter::inputText('nama_customer', 'nama_customer')
                ->placeholder('Cari nama customer'),

            Filter::select('status_pengiriman', 'status_pengiriman')
                ->dataSource([
                    ['name' => 'Belum Dikirim', 'value' => '0'],
                    ['name' => 'Sedang Dalam Pengiriman', 'value' => '1'],
                    ['name' => 'Sudah Diterima', 'value' => '2'],
                    ['name' => 'Belum Diterima', 'value' => '3'],
                ])
                ->optionLabel('name')
                ->optionValue('value'),

            Filter::select('status_formatted', 'tipe_invoice')
                ->dataSource([
                    ['name' => 'Dalkot', 'value' => 'dalkot'],
                    ['name' => 'Lukot', 'value' => 'lukot'],
                ])
                ->optionLabel('name')
                ->optionValue('value'),

            Filter::select('invoice_formatted', 'tipe_tagihan')
                ->dataSource([
                    ['name' => 'IDC PPN', 'value' => 'idcppn'],
                    ['name' => 'IDY PPN', 'value' => 'idyppn'],
                ])
                ->optionLabel('name')
                ->optionValue('value'),
        ];
    }

    public function actions(Invoice $row): array
    {
        $checkRoute = match ($this->currentRoute) {
            'invoice.medan.index' => 'invoice.medan.show',
            'invoice.jkt.index' => 'invoice.jkt.show',
            'invoice.pku.index' => 'invoice.pku.show',
            'invoice.all.index' => 'invoice.all.show',
            'invoice.cust.index' => 'invoice.cust.show',
            default => 'invoice.medan.show',
        };

        $button = [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route($checkRoute, ['invoice' => $row->id])
                ->attributes(['wire:navigate.hover' => true]),
        ];

        return $button;
    }

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }
}
