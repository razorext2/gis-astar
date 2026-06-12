<?php

namespace App\Livewire\PowergridTables;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PurchasingRequestTable extends PowerGridComponent
{
    public string $tableName = 'PurchasingRequestTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $user;

    public function setUp(): array
    {
        $this->user = auth()->user();

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
                'customer_contact_person' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer, '$.contact_person'))"),
                'nomor_purchasing_request_json' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(nomor_purchasing_request_json, '$'))"),
            ])
            ->where('status_approval', 1)
            ->where('on_delay', 0)
            ->orderBy('nomor_order', 'desc');
    }

    protected function datasourceTableColumns(): array
    {
        return [sprintf('%s.*', (new SpkMain)->getTable())];
    }

    public function relationSearch(): array
    {
        return [];
    }

    protected int $rowNumber = 0;

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no', fn () => ++$this->rowNumber)
            ->add('nomor_order')
            ->add('is_using_old_stock')
            ->add('company_name')
            ->add('is_using_old_stock_formatted', function ($query) {
                if ($query->is_using_old_stock) {
                    return '<span class="bg-green-300 text-green-700 text-xs px-2.5 py-1 rounded-lg font-semibold"> Stok Lama </span>';
                }
            })
            ->add('nomor_order_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => strtoupper($query->tipe_tagihan).' ('.$query->tipe_bayar.')',
                    'name' => $query->nomor_order.($query->revision_count ? 'R'.str_pad($query->revision_count, 2, '0', STR_PAD_LEFT) : ''),
                    'item3' => $query->status_description,
                ]);
            })
            ->add('nomor_purchasing_request')
            ->add('nomor_purchasing_request_formatted', function ($query) {
                return $query->nomor_purchasing_request ? $query->nomor_purchasing_request : ($query->nomor_purchasing_request_json ? collect($query->nomor_purchasing_request_json)->implode(', ') : 'Belum di Update');
            })
            ->add('customer_formatted', function ($query) {
                return $query->company_name ?? data_get($query->customer, 'nama_perusahaan', '-');
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        $table = (new SpkMain)->getTable();

        return [
            Column::make('No.', 'no'),

            Column::action('Action'),

            Column::make('Nomor PR', 'nomor_purchasing_request_formatted')
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.nomor_purchasing_request_json, '$')) LIKE ?"),

            Column::make('Nomor PR', 'nomor_purchasing_request')
                ->hidden(true)
                ->searchable(),

            Column::make('Tipe Tagihan', 'tipe_tagihan')->hidden(),

            Column::make('Penggunaan Stok', 'is_using_old_stock_formatted', 'is_using_old_stock'),

            Column::make('SPK', 'nomor_order_formatted', 'nomor_order')
                ->sortable()
                ->searchable(),

            Column::make('Customer', 'customer_formatted', 'company_name')
                ->searchable()
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.contact_person')) LIKE ?"),
        ];
    }

    public function filters(): array
    {
        $filters = [
            Filter::inputText('nomor_order', 'nomor_order')
                ->placeholder('Nomor SPK'),
            Filter::boolean('is_using_old_stock', 'is_using_old_stock')
                ->label('Ya', 'Tidak'),
            Filter::select('tipe_tagihan', 'tipe_tagihan')
                ->dataSource([
                    ['value' => 'idcnon', 'label' => 'IDC Non PPN'],
                    ['value' => 'idcppn', 'label' => 'IDC PPN'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
        ];

        return $filters;
    }

    public function actions(SpkMain $row): array
    {
        $button = [];

        if ($this->user->can('purchasing-request-update') && empty($row->nomor_purchasing_request || $row->nomor_purchasing_request_json) && ($row->is_using_old_stock == false)) {
            $button[] = Button::make('edit')
                ->slot('Update PR')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route('purchasing-request.edit', ['purchasing_request' => $row->id]);
        }

        if ($this->user->can('purchasing-request-detail')) {
            $button[] = Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->route('purchasing-request.show', ['purchasing_request' => $row->id]);
        }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}

