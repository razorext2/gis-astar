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

    public function setUp(): array
    {
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
            PowerGrid::responsive(),
            PowerGrid::exportable(now()->format('ymdhis') . '-InvoiceTable.xlsx')
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true)
        ];
    }

    public function datasource(): Builder
    {
        return Invoice::query()
            ->with(['addedBy', 'latestUpdateBy'])
            ->orderBy('created_at', 'desc');
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
                    'code' => $query->nomor_btt,
                    'name' => $query->tgl_btt
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
            ->add('added_by_formatted', fn($query) => $query->addedBy->name)
            ->add('latest_update_by_formatted', fn($query) => $query->latestUpdateBy->name)
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMMM YYYY'));
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

            Column::make('Tipe Invoice', 'tipe_invoice')
                ->sortable()
                ->searchable(),

            Column::make('Status Pengiriman', 'status_pengiriman_formatted', 'status_pengiriman')
                ->sortable()
                ->searchable(),

            Column::make('Status Terbaru', 'status_terbaru')
                ->sortable()
                ->searchable(),

            Column::make('Ditambah Oleh', 'added_by_formatted', 'added_by')
                ->sortable()
                ->searchable(),

            Column::make('Diperbarui Oleh', 'latest_update_by_formatted', 'latest_update_by')
                ->sortable()
                ->searchable(),

            Column::make('Dibuat Tanggal', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('no_faktur_pajak', 'no_faktur_pajak')
                ->placeholder('Cari no faktur pajak'),
            Filter::inputText('nomor_btt', 'nomor_btt')
                ->placeholder('Cari nomor btt'),
            Filter::inputText('tgl_btt', 'tgl_btt')
                ->placeholder('Cari tgl btt'),
            Filter::inputText('nama_customer', 'nama_customer')
                ->placeholder('Cari nama customer'),
            Filter::inputText('added_by_formatted', 'added_by')
                ->placeholder('Cari added by'),
            Filter::select('status_pengiriman_formatted', 'status_pengiriman')
                ->dataSource([
                    ['name' => 'Belum Dikirim', 'value' => '0'],
                    ['name' => 'Sudah Dikirim', 'value' => '1'],
                    ['name' => 'Sedang Dalam Pengiriman', 'value' => '2'],
                ])
                ->optionLabel('name')
                ->optionValue('value')
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
}
