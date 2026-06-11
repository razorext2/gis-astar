<?php

namespace App\Livewire\PowergridTables;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class BillingTable extends PowerGridComponent
{
    public string $tableName = 'BillingTable';

    public function setUp(): array
    {
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
        $query = SpkMain::query()
            ->with('noTagihanUpdatedBy');

        $query->orderBy('status_nomor_tagihan', 'asc');

        if (auth()->user()->can('spk-create') && auth()->user()->can('spk-list-own-only')) {
            $query->where('added_by', auth()->user()->id);
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id_formatted', fn ($query, $index) => $index + 1)
            ->add('nomor_order', fn ($query) => $query->nomor_order.($query->revision_count ? 'R'.str_pad($query->revision_count, 2, '0', STR_PAD_LEFT) : ''))
            ->add('tipe_tagihan')
            ->add('nomor_tagihan')
            ->add('nomor_tagihan_formatted', function ($query) {
                return $query->nomor_tagihan ?? '<span class="text-xs text-red-100 bg-red-500 px-2 py-0.5 rounded-full">Belum Diupdate</span>';
            })
            ->add('tipe_bayar')
            ->add('company_name')
            ->add('customer_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => ucwords($query->tipe_tagihan).' - '.$query->tipe_bayar,
                    'name' => $query->customer['nama_perusahaan'],
                    'item3' => $query->customer['contact_person'].' ('.$query->customer['no_hp'].')',
                ]);
            })
            ->add('status')
            ->add('status_formatted', fn ($query) => '<span class="text-sm text-green-500">'.$query->status_description.'</span>')
            ->add('no_tagihan_updated_by')
            ->add('no_tagihan_updated_by_formatted', fn ($query) => $query->noTagihanUpdatedBy->name ?? '<span class="text-xs text-red-100 bg-red-500 px-2 py-0.5 rounded-full">Belum Diupdate</span>')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id_formatted'),

            Column::action('Action'),

            Column::make('Nomor order', 'nomor_order')
                ->sortable()
                ->searchable(),

            Column::make('Customer', 'customer_formatted', 'company_name')
                ->sortable()
                ->searchable(),

            Column::make('Tipe tagihan', 'tipe_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Nomor tagihan', 'nomor_tagihan_formatted', 'nomor_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status_formatted', 'status')
                ->sortable()
                ->searchable(),

            Column::make('No tagihan updated by', 'no_tagihan_updated_by_formatted', 'no_tagihan_updated_by'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('tgl_cetak'),
        ];
    }

    public function actions(SpkMain $row): array
    {
        $statusColor = match ($row->status_nomor_tagihan) {
            1 => [
                'label' => 'Riwayat',
                'color' => 'dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white text-white  hover:bg-blue-700',
            ],
            0 => [
                'label' => 'Assign',
                'color' => 'dark:bg-green-800 dark:hover:bg-green-900 dark:text-white text-white  hover:bg-green-700',
            ],
        };

        return [
            Button::make('edit')
                ->slot($statusColor['label'])
                ->id($row->id)
                ->class('text-sm dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold  border border-zinc-200 '.$statusColor['color'])
                ->route('billing.edit', ['id' => $row->id]),
        ];
    }

    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn () => ! auth()->user()->canAny([
                    'spk-no-tagihan-idcppn-edit',
                    'spk-no-tagihan-idcnonppn-edit',
                    'spk-no-tagihan-idyppn-edit',
                ]))
                ->hide(),
        ];
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}

