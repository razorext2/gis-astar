<?php

/** Goal: Tabel laporan Sales dengan filtering berbasis permission, Caller: routes/web.php (sales.index), Deps: Sales, Auth, PowerGrid */

namespace App\Livewire;

use App\Models\Sales;
use App\Services\Sales\SalesRegionResolver;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class SalesTable extends PowerGridComponent
{
    public string $tableName = 'SalesTable';

    public bool $showFilters = false;

    public ?User $user = null;

    public function setUp(): array
    {
        $this->user = Auth::user();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage(perPage: 10, perPageValues: [10, 25, 50, 100, 500, 0])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Sales::query()
            ->leftJoin('tb_pegawai', 'tb_sales.kode_pegawai', '=', 'tb_pegawai.kode_pegawai')
            ->select('tb_sales.*', 'tb_pegawai.full_name')
            ->with(['userRelasi.roles']);

        if (! $this->user->can('sales-approve')) {
            $query->where('tb_sales.kode_pegawai', $this->user->kode_pegawai);
        } else {
            $allowedRoles = SalesRegionResolver::resolveForUser($this->user);

            if (! empty($allowedRoles)) {
                $query->whereHas('userRelasi.roles', function ($q) use ($allowedRoles) {
                    $q->whereIn('name', $allowedRoles);
                });
            }
        }

        return $query->orderBy('tb_sales.status')->latest('tb_sales.created_at');
    }

    public function relationSearch(): array
    {
        return [
            'pegawaiRelasi' => [
                'full_name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('pegawai_view', function ($data) {
                return view('components.dashboard.name-w-code', [
                    'code' => $data->kode_pegawai ?? 'N/A',
                    'name' => $data->full_name ?? 'N/A',
                ])->render();
            })
            ->add('title_view', function ($data) {
                return view('components.dashboard.title-w-status-two', [
                    'status' => $data->status,
                    'title'  => $data->short_title,
                ])->render();
            })
            ->add('customer_view', function ($data) {
                return view('components.dashboard.name-w-code', [
                    'code' => $data->customer_telp ?? 'N/A',
                    'name' => $data->customer_name ?? 'N/A',
                ])->render();
            })
            ->add('lokasi_view', function ($data) {
                return view('components.dashboard.location-w-coordinate', [
                    'location' => $data->lokasi ?? 'N/A',
                    'long'     => $data->longitude ?? 'N/A',
                    'lat'      => $data->latitude ?? 'N/A',
                ])->render();
            })
            ->add('created_at_view', function ($data) {
                return view('components.dashboard.created-updated', [
                    'created' => $data->created_at,
                    'updated' => '',
                ])->render();
            })
            ->add('kode_pegawai')
            ->add('full_name')
            ->add('title')
            ->add('customer_name')
            ->add('status')
            ->add('created_at')
            ->add('role_name', fn ($data) => $data->userRelasi?->roles?->pluck('name')->implode(', ') ?: '');
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi'),

            Column::make('Pegawai', 'pegawai_view', 'kode_pegawai')
                ->searchable(),

            Column::make('Judul Laporan', 'title_view', 'title')
                ->searchable(),

            Column::make('Customer', 'customer_view', 'customer_name')
                ->searchable(),

            Column::make('Lokasi', 'lokasi_view'),

            Column::make('Waktu Dibuat', 'created_at_view', 'created_at')
                ->sortable(),

            Column::make('Nama Pegawai', 'full_name')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Role', 'role_name')
                ->hidden(isHidden: true, isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        $filters = [
            Filter::inputText('title', 'tb_sales.title')->placeholder('Judul laporan'),

            Filter::inputText('customer_name', 'tb_sales.customer_name')->placeholder('Nama customer'),

            Filter::select('status', 'tb_sales.status')
                ->dataSource([
                    0 => ['name' => 'Belum divalidasi', 'value' => 0],
                    1 => ['name' => 'Disetujui', 'value' => 1],
                    2 => ['name' => 'Ditolak', 'value' => 2],
                ])
                ->optionLabel('name')
                ->optionValue('value'),

            Filter::datetimepicker('created_at', 'tb_sales.created_at')
                ->params(['timezone' => 'Asia/Jakarta']),
        ];

        if ($this->user->can('sales-approve')) {
            $filters[] = Filter::inputText('full_name', 'tb_pegawai.full_name')->placeholder('Nama sales');
        }

        if ($this->user->can('sales-export-all')) {
            $filters[] = Filter::select('role_name', 'role_name')
                ->dataSource([
                    ['name' => 'Sales Medan',    'value' => 'Sales'],
                    ['name' => 'Sales Jakarta',  'value' => 'Sales-JKT'],
                    ['name' => 'Sales Pekanbaru','value' => 'Sales-PKU'],
                    ['name' => 'Sales Indodaya', 'value' => 'Sales-IDY'],
                    ['name' => 'Kurir Bank',     'value' => 'Kurir-Bank'],
                    ['name' => 'Sales Agrotec',  'value' => 'Sales-Agrotec'],
                ])
                ->optionLabel('name')
                ->optionValue('value')
                ->builder(function (Builder $query, $value) {
                    $query->whereHas('userRelasi.roles', fn ($q) => $q->where('name', $value));
                });
        }

        return $filters;
    }

    public function actionsFromView($data): View
    {
        $actions = [
            [
                'id'     => 'show-btn',
                'action' => route('sales.show', $data->id),
                'label'  => 'Detail',
            ],
        ];

        if ($this->user->can('sales-approve')) {
            if ($this->user->can('sales-delete')) {
                $actions[] = [
                    'id'     => 'edit-btn',
                    'action' => route('sales.edit', $data->id),
                    'label'  => 'Edit',
                ];
            }

            return view('components.dashboard.action-buttons', [
                'id'     => $data->id,
                'datas'  => $actions,
                'detail' => $data->status == 0,
                'delete' => $this->user->can('sales-delete'),
            ]);
        }

        return view('components.dashboard.single-button', [
            'id'   => $data->id,
            'data' => [
                'id'     => 'detailBtn'.$data->id,
                'action' => route('sales.show', $data->id),
                'label'  => 'Detail',
            ],
        ]);
    }

    #[On('detail')]
    public function detail(int $id): void
    {
        $this->dispatch('openSalesValidateModal', id: $id);
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $this->dispatch('confirmSalesDelete', id: $id);
    }

    #[On('confirmSalesDeleteAction')]
    public function confirmDelete(int $id): void
    {
        $data = Sales::find($id);

        if (! $data) {
            $this->swal('Gagal!', "Data dengan ID <b>$id</b> tidak ditemukan.", 'error');

            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data berhasil dihapus.', 'success');

            Log::info($this->user->kode_pegawai." : Menghapus sales data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data.", 'error');

            Log::error($this->user->kode_pegawai." : Gagal menghapus sales {$id}. {$e->getMessage()}");
        }
    }

    public function swal(string $title, string $text, string $icon): void
    {
        $this->dispatch('swal', title: $title, text: $text, icon: $icon);
    }
}
