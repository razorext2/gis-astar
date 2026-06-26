<?php

/** Goal: Render and filter SPK list by user permissions, Caller: SpkController, Deps: SpkMain */

namespace App\Livewire\PowergridTables;

use App\Models\Spk\SpkMain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public $user;

    public ?string $tipe_timbangan = null;

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
        $query = SpkMain::query()
            ->select($this->datasourceTableColumns())
            ->with(['addedBy'])
            ->addSelect([
                'customer_contact_person' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(customer, '$.contact_person'))"),
                'products_name' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(products, '$.nama_barang'))"),
            ]);

        if ($this->user->can('spk-list')) {
            // No additional filters, view all
        } elseif ($this->user->can('spk-list-own-only')) {
            $query->where(function ($q) {
                $q->where('added_by', $this->user->id)
                    ->orWhere('assign_to', $this->user->id)
                    ->orWhere('reassign_to', $this->user->id);
            });
        } else {
            if (! $this->user->can('spk-create')) {
                $query->where(function ($q) {
                    $q->where('assign_to', $this->user->id)
                        ->orWhere('reassign_to', $this->user->id);
                })->where('status_approval', 1);
            }
        }

        if (! is_null($this->tipe_timbangan)) {
            $query->where('tipe_timbangan', $this->tipe_timbangan);
        }

        return $query;
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
            ->add('tipe_tagihan')
            ->add('nomor_tagihan')
            ->add('status_approval')
            ->add('on_delay')
            ->add('is_booked')
            ->add('is_using_old_stock')
            ->add('is_using_company_driver')
            ->add('status')
            ->add('created_at')
            ->add('tipe_timbangan')
            ->add('added_by', fn ($query) => view('components.dashboard.name-w-badge', [
                'name' => $query->addedBy->name,
                'is_active' => (bool) ($query->addedBy?->is_active ?? true),
            ]))
            ->add('nomor_order_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'text_color' => match ($query->tipe_tagihan) {
                        'idcppn' => 'green',
                        'idcnon' => 'red',
                        default => 'gray',
                    },
                    'code' => strtoupper($query->tipe_tagihan).' ('.$query->tipe_bayar.')',
                    'name' => $query->nomor_order.($query->revision_count ? 'R'.str_pad($query->revision_count, 2, '0', STR_PAD_LEFT) : ''),
                    'item3' => $query->status_description,
                ]);
            })
            ->add('nomor_tagihan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->status_nomor_tagihan_description,
                    'name' => $query->nomor_tagihan ?? '-',
                ]);
            })
            ->add('customer_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $this->user->can('spk-create') ? $query->customer_contact_person ?? data_get($query->customer, 'contact_person', '-') : '',
                    'name' => $query->customer_nama_perusahaan ?? data_get($query->customer, 'nama_perusahaan', '-'),
                    'item3' => $this->user->can('spk-create') ? $query->customer['no_hp'] ?? '-' : '',
                ]);
            })
            ->add('company_name')
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
            ->add('status_approval_formatted', function ($query) {
                $colors = match ($query->status_approval) {
                    0 => 'yellow',
                    1 => 'green',
                    2 => 'red',
                    3 => 'yellow',
                    4 => 'red',
                    default => 'gray'
                };

                $template = "
                    <div class='flex flex-col gap-1 w-fit font-semibold'>
                        <span class='bg-{$colors}-500 w-fit text-xs px-2.5 flex justify-center items-center py-1 text-{$colors}-800 rounded-lg'>
                            {$query->status_approval_description}
                        </span>";

                if ($query->on_delay) {
                    $template .= "
                        <span class='bg-red-500 text-xs px-2.5 flex justify-center items-center py-1 text-red-100 w-fit rounded-lg'>
                            Delayed
                        </span>";
                }

                if ($query->is_booked) {
                    $template .= "
                        <span class='bg-blue-500 text-xs px-2.5 flex justify-center items-center py-1 text-blue-800 w-fit rounded-lg'>
                            Booked
                        </span>";
                }

                if ($query->is_cancelled && $query->status_approval != 4) {
                    $template .= "
                        <span class='bg-yellow-500 text-xs px-2.5 flex justify-center items-center py-1 text-yellow-800 w-fit rounded-lg'>
                            Request Pembatalan
                        </span>";
                }

                if ($query->is_using_old_stock) {
                    $template .= "
                        <span class='bg-green-300 text-green-700 text-xs px-2.5 py-1 rounded-lg w-fit'>
                            Stok Lama
                        </span>";
                }

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

                $template .= '</div>';

                return $template;
            });
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

            Column::make('Customer', 'customer_formatted', 'company_name')
                ->searchable()
                ->searchableRaw("JSON_UNQUOTE(JSON_EXTRACT($table.customer, '$.contact_person')) LIKE ?"),

            Column::make('Tipe Tagihan', 'tipe_tagihan')
                ->hidden(),

            Column::make('Status Approval', 'status_approval_formatted', 'status_approval')
                ->sortable()
                ->searchable(),

            Column::make('Nomor Penagihan', 'nomor_tagihan_formatted', 'nomor_tagihan')
                ->sortable()
                ->searchable()
                ->hidden(Auth::user()->cannot('spk-create')),

            Column::make('Tipe Timbangan', 'tipe_timbangan')
                ->sortable(),

            Column::make('Delay', 'on_delay')
                ->hidden(true),

            Column::make('Dibooking', 'is_booked')
                ->hidden(true),

            Column::make('Dibuat Oleh', 'added_by')
                ->sortable(),

            Column::make('Stok', 'is_using_old_stock')
                ->hidden(true),

            Column::make('Supir Perusahaan', 'is_using_company_driver')
                ->hidden(true),

            Column::make('Dijemput Customer', 'is_picked_up_by_customer')
                ->hidden(true),
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
            Filter::boolean('on_delay', 'on_delay')
                ->label('Delayed', 'Not Delayed'),
            Filter::boolean('is_booked', 'is_booked')
                ->label('Dibooking', 'Tidak Dibooking'),
            Filter::select('tipe_timbangan', 'tipe_timbangan')
                ->dataSource([
                    ['value' => 'non timbangan jembatan', 'label' => 'Timbangan Lainnya'],
                    ['value' => 'timbangan jembatan', 'label' => 'Timbangan Jembatan'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::boolean('is_using_old_stock', 'is_using_old_stock')
                ->label('Ya', 'Tidak'),
            Filter::boolean('is_using_company_driver', 'is_using_company_driver')
                ->label('Ya', 'Tidak'),
            Filter::boolean('is_picked_up_by_customer', 'is_picked_up_by_customer')
                ->label('Ya', 'Tidak'),
        ];
    }

    public function actions(SpkMain $row): array
    {
        $button = [];

        if ($this->user->can('spk-edit') && ($this->user->can('spk-edit-all') || $this->user->id === $row->added_by) && ($this->user->can('spk-approve') || $row->status_approval !== 4)) {
            $button[] = Button::make('edit')
                ->slot('Edit')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route('spk.edit', ['spk' => $row->id]);
        }

        if ($this->user->can('view', $row)) {
            $button[] = Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-blue-700')
                ->route('spk.show', ['spk' => $row->id]);
        }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}

