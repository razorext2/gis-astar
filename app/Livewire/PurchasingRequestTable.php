<?php

namespace App\Livewire;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
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
                'products_name' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(products, '$'))"),
            ])
            ->where('status_approval', 1)
            ->where('on_delay', 0)
            ->orderBy('nomor_purchasing_request', 'asc');
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
            ->add('nomor_purchasing_request')
            ->add('nomor_purchasing_request_formatted', function ($query) {
                return $query->nomor_purchasing_request ?? 'Belum Diupdate';
            })
            ->add('customer_company', fn ($query) => $query->customer_nama_perusahaan ?? data_get($query->customer, 'nama_perusahaan', '-'))
            ->add('customer_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->customer_contact_person ?? data_get($query->customer, 'contact_person', '-'),
                    'name' => $query->customer_nama_perusahaan ?? data_get($query->customer, 'nama_perusahaan', '-'),
                    'item3' => $query->customer['no_hp'] ?? '-',
                ]);
            })
            ->add('created_at');
    }

    public function columns(): array
    {
        $table = (new SpkMain)->getTable();

        return [
            Column::make('No.', 'no'),

            Column::action('Action'),

            Column::make('Nomor PR', 'nomor_purchasing_request_formatted', 'nomor_purchasing_request'),

            Column::make('SPK', 'nomor_order_formatted', 'nomor_order')
                ->sortable()
                ->searchable(),

            Column::make('Customer', 'customer_formatted', 'customer')
                ->searchable()
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.nama_perusahaan')) LIKE ?")
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.contact_person')) LIKE ?"),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actions(SpkMain $row): array
    {
        $button = [];

        if ($this->user->can('purchasing-request-update') && empty($row->nomor_purchasing_request)) {
            $button[] = Button::make('edit')
                ->slot('Update PR')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('purchasing-request.edit', ['purchasing_request' => $row->id]);
        }

        if ($this->user->can('purchasing-request-detail')) {
            $button[] = Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->route('purchasing-request.show', ['purchasing_request' => $row->id]);
        }

        return $button;
    }
}
