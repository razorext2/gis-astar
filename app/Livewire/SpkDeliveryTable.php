<?php

namespace App\Livewire;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SpkDeliveryTable extends PowerGridComponent
{
    public string $tableName = 'SpkDeliveryTable';

    public function setUp(): array
    {
        $this->showCheckBox();

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
        return SpkMain::query();
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
            ->add('nomor_order')
            ->add('tipe_tagihan')
            ->add('nomor_tagihan')
            ->add('nomor_tagihan_formatted', function ($query) {
                return $query->nomor_tagihan ?? '<span class="text-xs text-red-100 bg-red-500 px-2 py-0.5 rounded-full">Belum Diupdate</span>';
            })
            ->add('tipe_bayar')
            ->add('customer')
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

            Column::make('Customer', 'customer_formatted', 'customer')
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
        return [
            Button::make('edit')
                ->slot('Update Pengiriman')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('delivery.edit', ['id' => $row->id]),
        ];
    }
}
