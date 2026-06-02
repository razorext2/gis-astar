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

    public ?int $status_kirim = null;

    public function setUp(): array
    {
        // if (auth()->user()->can('spk-approve')) {
        //     $this->showCheckBox();
        // }

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
            ->whereHas('production', function ($production) {

                if (auth()->user()->cannot('spk-approve')) {
                    // tampilkan data hanya packing_list not null atau is_using_company_driver = true atau is_picked_up_by_customer = true
                    $production->where(function ($p) {
                        $p->whereRaw('COALESCE(JSON_LENGTH(packing_list), 0) > 0')
                            ->orWhere('is_using_company_driver', true)
                            ->orWhere('is_picked_up_by_customer', true);
                    });
                }

                $production->whereHas('productionHistories', function ($history) {
                    $history->where('status_produksi', 10)
                        ->whereRaw('id = (SELECT id FROM tb_produksi_histories
                                                WHERE tb_produksi_histories.id_produksi = tb_produksi.id
                                                ORDER BY created_at DESC
                                                LIMIT 1)
                                                ');
                });

            });

        if ($this->status_kirim !== '' && $this->status_kirim !== null) {
            $query->whereHas('latestDelivery', function ($q) {
                $q->where('status_kirim', '=', $this->status_kirim);
            });
        }

        if (auth()->user()->can('spk-list-own-only')) {
            $query->where('added_by', auth()->id());
        }

        $query->orderBy('created_at', 'desc');

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
            ->add('status_formatted', function ($query) {
                $template = '<div class="flex flex-col gap-1 w-fit font-semibold">
                                <span class="text-xs px-2.5 py-1 rounded-lg bg-green-600 text-green-300">'
                                    .$query->status_description.'
                                </span>';

                if ($query->is_using_company_driver) {
                    $template .= "
                        <span class='bg-blue-400 text-blue-700 text-xs px-2.5 py-1 rounded-lg w-fit'>
                            Supir Perusahaan
                        </span>";
                }

                if ($query->is_picked_up_by_customer) {
                    $template .= "
                        <span class='bg-purple-400 text-purple-700 text-xs px-2.5 py-1 rounded-lg w-fit'>
                            Dijemput Customer
                        </span>";
                }

                if ($query->deliveries?->last()?->status_kirim && $query->deliveries?->last()->status_kirim == 1) {
                    $template .= "
                        <span class='bg-green-400 text-green-700 text-xs px-2.5 py-1 rounded-lg w-fit'>
                            Pengiriman Selesai
                        </span>";
                }

                $template .= '</div>';

                return $template;
            })
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

            Column::make('Status', 'status_formatted', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Tipe tagihan', 'tipe_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('Nomor tagihan', 'nomor_tagihan_formatted', 'nomor_tagihan')
                ->sortable()
                ->searchable(),

            Column::make('No tagihan updated by', 'no_tagihan_updated_by_formatted', 'no_tagihan_updated_by')
                ->hidden(true),

            Column::make('Supir Perusahaan', 'is_using_company_driver')->hidden(),
            Column::make('Dijemput Customer', 'is_picked_up_by_customer')->hidden(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('nomor_order', 'nomor_order')
                ->placeholder('Nomor SPK'),
            Filter::select('tipe_tagihan', 'tipe_tagihan')
                ->dataSource([
                    ['value' => 'idcnon', 'label' => 'IDC Non PPN'],
                    ['value' => 'idcppn', 'label' => 'IDC PPN'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::boolean('is_using_company_driver', 'is_using_company_driver')
                ->label('Ya', 'Tidak'),
            Filter::boolean('is_picked_up_by_customer', 'is_picked_up_by_customer')
                ->label('Ya', 'Tidak'),
        ];
    }

    public function actions(SpkMain $row): array
    {
        return [
            Button::make('edit')
                ->slot($row->deliveries?->count() < 1 ? 'Update Pengiriman' : 'Pengiriman')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route('delivery.edit', ['id' => $row->id]),
        ];
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
