<?php

namespace App\Livewire;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class InvoiceTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'InvoiceTable';
    public bool $deferLoading = true;
    public bool $showFilters = false;
    public string $sortField = 'updated_at';
    public string $sortDirection = 'desc';
    public bool $multiSort = true;

    public $user;

    public function setUp(): array
    {
        $this->user = auth()->user();

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
            // PowerGrid::responsive(),
            PowerGrid::exportable(now()->format('ymdhis') . '-InvoiceTable.xlsx')
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true)
        ];
    }

    public function datasource(): Builder
    {
        $query = Invoice::query()
            ->with(['addedBy', 'latestUpdateBy', 'details']);

        if ($this->user->can('invoice-list-pku')) {
            $query->whereHas('details', function (Builder $detailQuery) {
                $detailQuery
                    ->where('informasi_pengiriman->tujuan', 'pku');
            });
        }

        if ($this->user->can('invoice-list-jkt')) {
            $query->whereHas('details', function (Builder $detailQuery) {
                $detailQuery
                    ->where('informasi_pengiriman->tujuan', 'jkt');
            });
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'addedBy' => [
                'id',
                'kode_pegawai',
                'name'
            ],
            'latestUpdateBy' => [
                'id',
                'kode_pegawai',
                'name'
            ]
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
            ->add('invoice_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->nama_customer,
                    'name' => $query->no_faktur_pajak,
                    'item3' => $query->tgl_invoice
                ]);
            })
            ->add('btt_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->tgl_btt,
                    'name' => $query->nomor_btt
                ]);
            })
            ->add('no_penjualan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->no_penjualan,
                    'name' => $query->no_piutang
                ]);
            })
            ->add('status_pengiriman_formatted', function ($query) {
                $status = match ($query->status_pengiriman) {
                    '0' => 'Belum Dikirim',
                    '1' => 'Sedang Dalam Pengiriman',
                    '2' => 'Sudah Diterima',
                    default => 'Tidak Diketahui',
                };

                return $status;
            })
            ->add('status_formatted', function ($query) {
                $status = match ($query->status_pengiriman) {
                    '0' => 'Belum Dikirim',
                    '1' => 'Sedang Dalam Pengiriman',
                    '2' => 'Sudah Diterima',
                    default => 'Tidak Diketahui',
                };

                return view('components.dashboard.name-w-code', [
                    'code' => $query->tipe_invoice,
                    'name' => $status,
                    'item3' => $query->status_terbaru
                ]);
            })
            ->add('user_info_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => 'Ditambah oleh: ' . $query->addedBy->name,
                    'name' => 'Terakhir update: ' . $query->latestUpdateBy->name,
                    'item3' => 'Dibuat Tanggal: ' . Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMMM YYYY')
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
        ];
    }

    public function actions(Invoice $row)
    {
        $button = [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('invoice.show', ['invoice' => $row->id])
        ];

        return $button;
    }

    protected function queryString()
    {
        return $this->powerGridQueryString();
    }
}
