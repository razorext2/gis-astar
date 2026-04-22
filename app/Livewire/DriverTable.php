<?php

/** Goal: Tabel manajemen laporan Driver dengan filtering berbasis permission, Caller: routes/web.php (driver.index), Deps: Driver, Auth, PowerGrid */

namespace App\Livewire;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class DriverTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'DriverTable';

    public string $status = '';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public ?\App\Models\User $user = null;

    // Label status Driver — single source of truth untuk fields() dan filters()
    private const STATUS_LABELS = [
        0 => 'Diajukan',
        1 => 'Disetujui',
        2 => 'Ditolak',
        3 => 'Revisi',
        4 => 'Belum diassign',
        5 => 'Belum diupdate',
    ];

    public function setUp(): array
    {
        // Inisialisasi state di setUp() — hook resmi PowerGrid, tidak override mount() parent
        $this->user = Auth::user();
        $this->status = Request::query('status', '');

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::exportable(fileName: 'driverReport-'.now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        return Driver::query()
            ->with(['user', 'photoCollect'])
            ->when(
                $this->user->can('driver-approve'),
                function (Builder $query) {
                    $roles = collect([
                        'Driver-Jkt' => 'driver-list-jkt',
                        'Driver-Medan' => 'driver-list-medan',
                    ])->filter(fn ($permission) => $this->user->can($permission))->keys()->toArray();

                    $query->where(function (Builder $q) use ($roles) {
                        $q->when(! empty($roles), fn ($q) => $q->where(fn ($q) => $q
                            ->whereNotNull('kode_pegawai')
                            ->whereHas('user.roles', fn ($role) => $role->whereIn('name', $roles))
                        ))->orWhere(fn ($q) => $q
                            ->whereNull('kode_pegawai')
                            ->where('assign_by', $this->user->id)
                        );
                    });
                },
                fn (Builder $query) => $query->where('kode_pegawai', $this->user->kode_pegawai)
            )
            ->when($this->status !== '', function (Builder $query) {
                $statusMap = [
                    'unapproved' => 0, 'approved' => 1, 'rejected' => 2,
                    'needrevision' => 3, 'notassigned' => 4, 'notupdated' => 5,
                ];

                $query->when(isset($statusMap[$this->status]), fn ($q) => $q->where('status', $statusMap[$this->status]));
            })
            ->orderByDesc('created_at')
            ->orderByDesc('status');
    }

    public function relationSearch(): array
    {
        return [
            'user' => ['name', 'kode_pegawai'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai', fn ($row) => view('components.dashboard.name-code-button', [
                'user' => $row->user,
                'data' => $row,
            ])->render())
            ->add('title')
            ->add('lokasi', fn ($row) => view('components.table-component.title-location-coordinate', ['data' => $row])->render())
            ->add('status', fn ($row) => $row->status ?? '-')
            ->add('status_formatted', fn ($row) => view('components.dashboard.title-w-status-two', [
                'title' => self::STATUS_LABELS[$row->status] ?? '-',
                'status' => $row->status,
                'id' => $row->id,
            ])->render())
            ->add('created_at')
            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)
                ->locale('id')
                ->isoFormat('D MMMM YYYY HH:mm:ss'))
            ->add('assign_date')
            ->add('assign_date_formatted', fn ($row) => $row->assign_date
                ? Carbon::parse($row->assign_date)->locale('id')->isoFormat('D MMMM YYYY')
                : '-')
            ->add('tipe_kunjungan')
            ->add('tipe_tagihan');
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Kode pegawai', 'kode_pegawai')
                ->sortable()
                ->searchable()
                ->bodyAttribute('min-w-44'),

            Column::make('Lokasi', 'lokasi')
                ->sortable()
                ->searchable()
                ->bodyAttribute('min-w-72'),

            Column::make('Judul', 'title')
                ->searchable()
                ->hidden(),

            Column::make('Status', 'status_formatted', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Di Assign Tgl', 'assign_date_formatted', 'assign_date')
                ->sortable(),

            Column::make('Di Buat Tgl', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Tipe Kunjungan', 'tipe_kunjungan', 'tipe_kunjungan')
                ->hidden(),

            Column::make('Tipe Tagihan', 'tipe_tagihan', 'tipe_tagihan')
                ->hidden(),
        ];
    }

    public function filters(): array
    {
        $statusSource = collect(self::STATUS_LABELS)
            ->map(fn ($label, $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();

        return [
            Filter::inputText('title', 'title'),
            Filter::inputText('lokasi', 'lokasi'),
            Filter::multiSelect('status', 'status')
                ->dataSource($statusSource)
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::datepicker('created_at', 'created_at'),
            Filter::multiSelect('tipe_kunjungan', 'tipe_kunjungan')
                ->dataSource([
                    ['value' => 'ATRBRG', 'label' => 'Antar Barang (SR)'],
                    ['value' => 'JPTBRG', 'label' => 'Jemput Barang'],
                    ['value' => 'ATRTEK', 'label' => 'Antar Teknisi'],
                    ['value' => 'JPTTEK', 'label' => 'Jemput Teknisi'],
                    ['value' => 'DLL', 'label' => 'Lainnya'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::select('tipe_tagihan', 'tipe_tagihan')
                ->dataSource([
                    ['value' => 'idcnon', 'label' => 'IDC Non PPN'],
                    ['value' => 'idcppn', 'label' => 'IDC PPN'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
        ];
    }

    public function actionsFromView(Driver $row): View
    {
        $actions = [
            [
                'id' => 'show-btn',
                'action' => route('driver.show', $row->id),
                'label' => 'Detail',
            ],
        ];

        // Gunakan $this->user (di-cache di mount()) — bukan auth() berulang kali
        if ($row->status == 3 || $this->user->can('driver-approve')) {
            $actions[] = [
                'id' => 'edit-btn',
                'action' => route('driver.edit', $row->id),
                'label' => 'Edit',
            ];
        }

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'detail' => $row->status == 0 && $this->user->can('driver-approve'),
            'delete' => $this->user->can('driver-delete'),
        ]);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDelete($id): void
    {
        $data = Driver::find($id);

        if (! $data) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data yang dipilih berhasil dihapus.', 'success');

            Log::info($this->user->kode_pegawai." : Menghapus data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            Log::info($this->user->kode_pegawai." : Gagal menghapus data {$id}. {$e->getMessage()}");
        }
    }

    #[\Livewire\Attributes\On('detail')]
    public function detail($id): void
    {
        // Gunakan find() langsung — lebih ringkas dari where()->first()
        $data = Driver::with(['pegawai', 'photoCollect'])->find($id);

        if (! $data) {
            $this->swal('Gagal!', 'Data tidak ditemukan', 'error');

            return;
        }

        $this->dispatch('detailDriverModal', data: $data);
    }

    #[\Livewire\Attributes\On('confirmAction')]
    public function confirmAction($id): void
    {
        $this->updateDriverStatus($id, ['status' => 1], 'Dikonfirmasi!', 'Data yang dipilih berhasil dikonfirmasi.');
    }

    #[\Livewire\Attributes\On('declineAction')]
    public function declineAction($id, $note): void
    {
        $this->updateDriverStatus($id, ['status' => 2, 'notes' => $note], 'Ditolak!', 'Laporan yang dipilih berhasil ditolak.');
    }

    #[\Livewire\Attributes\On('revisionAction')]
    public function revisionAction($id, $note): void
    {
        $this->updateDriverStatus($id, ['status' => 3, 'notes' => $note], 'Direvisi!', 'Laporan yang dipilih berhasil direvisi.');
    }

    /**
     * DRY helper: update status Driver + set validate_by.
     * Dipanggil oleh confirmAction, declineAction, revisionAction.
     */
    private function updateDriverStatus(int $id, array $payload, string $successTitle, string $successMsg): void
    {
        $driver = Driver::find($id);

        if (! $driver) {
            $this->swal('Gagal!', 'Data tidak ditemukan.', 'error');

            return;
        }

        try {
            $driver->update(array_merge($payload, ['validate_by' => Auth::id()]));

            $this->swal($successTitle, $successMsg, 'success');
        } catch (\Exception $e) {
            $this->swal('Terjadi kesalahan', $e->getMessage(), 'error');
        }
    }

    #[\Livewire\Attributes\On('assign')]
    public function assign(int $id): void
    {
        $this->redirect(route('driver.assign.to', $id));
    }

    public function swal(string $title, string $text, string $icon): void
    {
        $this->dispatch('swal', title: $title, text: $text, icon: $icon);
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
