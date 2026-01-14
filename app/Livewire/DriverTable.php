<?php

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

    public string $status;

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $user;

    public function setUp(): array
    {
        $this->user = Auth::user();

        $this->status = Request::query('status') ?? '';

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
        $roles = [];
        $data = Driver::query()->with(['user', 'photoCollect']);

        if (! auth()->user()->can('driver-approve')) {
            $data->where('kode_pegawai', auth()->user()->kode_pegawai)
                ->where(function ($query) {
                    $query->whereDate('assign_date', '<=', now())
                        ->orWhereNull('assign_date');
                });
        } else {
            if ($this->user->can('driver-list-jkt')) {
                $roles[] = 'Driver-Jkt';
            }

            if ($this->user->can('driver-list-medan')) {
                $roles[] = 'Driver-Medan';
            }

            $data->whereHas('user.roles', fn ($role) => $role->whereIn('name', $roles));
        }

        if ($this->status != '') {
            match ($this->status) {
                'unapproved' => $data->where('status', 0),
                'approved' => $data->where('status', 1),
                'rejected' => $data->where('status', 2),
                'needrevision' => $data->where('status', 3),
                'notassigned' => $data->where('status', 4),
                'notupdated' => $data->where('status', 5)
            };
        }

        $data->orderBy('created_at', 'desc')
            ->orderBy('status', 'desc');

        return $data;
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
                'kode_pegawai',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai', function ($query) {
                return view('components.dashboard.name-code-button', [
                    'user' => $query->user,
                    'data' => $query,
                ])->render();
            })
            ->add('title')
            ->add('lokasi', fn ($query) => view('components.table-component.title-location-coordinate', ['data' => $query])->render())
            ->add('status', fn ($query) => $query->status ?? '-')
            ->add('status_formatted', function ($query) {
                $status = $query->status;

                return view('components.dashboard.title-w-status-two', [
                    'title' => [
                        0 => 'Diajukan',
                        1 => 'Disetujui',
                        2 => 'Ditolak',
                        3 => 'Revisi',
                        4 => 'Belum diassign',
                        5 => 'Belum diupdate',
                    ][$status],
                    'status' => $status,
                    'id' => $query->id,
                ])->render();
            })
            ->add('created_at')
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)
                ->locale('id')
                ->isoFormat('D MMMM YYYY HH:mm:ss'))
            ->add('assign_date')
            ->add('assign_date_formatted', function ($query) {
                $date = $query->assign_date;

                if ($date) {
                    return Carbon::parse($date)
                        ->locale('id')
                        ->isoFormat('D MMMM YYYY HH:mm:ss');
                } else {
                    return '-';
                }
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Kode pegawai', 'kode_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Lokasi', 'lokasi')
                ->sortable()
                ->searchable()
                ->bodyAttribute('min-w-80'),

            Column::make('Status', 'status_formatted', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Di Assign Tgl', 'assign_date_formatted', 'assign_date')
                ->sortable(),

            Column::make('Di Buat Tgl', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        $filters = [
            Filter::inputText('title', 'title'),
            Filter::inputText('lokasi', 'lokasi'),
            Filter::multiSelect('status', 'status')
                ->dataSource([
                    ['value' => 0, 'label' => 'Diajukan'],
                    ['value' => 1, 'label' => 'Disetujui'],
                    ['value' => 2, 'label' => 'Ditolak'],
                    ['value' => 3, 'label' => 'Revisi'],
                    ['value' => 4, 'label' => 'Belum diassign'],
                    ['value' => 5, 'label' => 'Belum diupdate'],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::datepicker('created_at', 'created_at'),
        ];

        return $filters;
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

        if ($row->status == 3 || auth()->user()->can('driver-approve')) {
            $actions[] = [
                'id' => 'edit-btn',
                'action' => route('driver.edit', $row->id),
                'label' => 'Edit',
            ];
        }

        return view('components.dashboard.action-buttons', [
            'id' => $row->id,
            'datas' => $actions,
            'detail' => $row->status == 0 && auth()->user()->can('driver-approve'),
            'delete' => auth()->user()->can('driver-delete'),
        ]);
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    #[\Livewire\Attributes\On('confirmDeleteAction')]
    public function confirmDelete($id, Request $request): void
    {
        $data = Driver::find($id);

        if (! $data) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data yang dipilih berhasil dihapus.', 'success');

            Log::info($request->user()." : Menghapus data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            Log::info($request->user()->kode_pegawai." : Gagal menghapus data {$id}. {$e->getMessage()}");
        }
    }

    #[\Livewire\Attributes\On('detail')]
    public function detail($id): void
    {
        $data = Driver::with(['pegawai', 'photoCollect'])
            ->where('id', $id)
            ->first();

        if (! $data) {
            $this->swal('Gagal!', 'Data tidak ditemukan', 'error');

            return;
        }

        $this->dispatch('detailDriverModal', data: $data);
    }

    #[\Livewire\Attributes\On('confirmAction')]
    public function confirmAction($id): void
    {
        $user_id = Auth::id();
        $query = Driver::find($id);

        if (! $query) {
            $this->swal('Gagal!', 'Data tidak ditemukan.', 'error');

            return;
        }

        try {
            $query->update([
                'status' => 1,
                'validate_by' => $user_id,
            ]);

            $this->swal('Dikonfirmasi!', 'Data yang dipilih berhasil dikonfirmasi.', 'success');
        } catch (\Exception $e) {
            $this->swal('Terjadi kesalahan saat konfirmasi data', $e->getMessage(), 'error');

            return;
        }
    }

    #[\Livewire\Attributes\On('declineAction')]
    public function declineAction($id, $note): void
    {
        $user_id = Auth::id();
        $query = Driver::find($id);

        if (! $query) {
            $this->swal('Gagal!', 'Data tidak ditemukan.', 'error');

            return;
        }

        try {
            $query->update([
                'status' => 2,
                'notes' => $note,
                'validate_by' => $user_id,
            ]);

            $this->swal('Ditolak!', 'Laporan yang dipilih berhasil ditolak', 'success');
        } catch (\Exception $e) {
            $this->swal('Terjadi kesalahan saat konfirmasi data', $e->getMessage(), 'error');

            return;
        }
    }

    #[\Livewire\Attributes\On('revisionAction')]
    public function revisionAction($id, $note): void
    {
        $user_id = Auth::id();
        $query = Driver::find($id);

        if (! $query) {
            $this->swal('Gagal!', 'Data tidak ditemukan.', 'error');

            return;
        }

        try {
            $query->update([
                'status' => 3,
                'notes' => $note,
                'validate_by' => $user_id,
            ]);

            $this->swal('Direvisi!', 'Laporan yang dipilih berhasil direvisi', 'success');
        } catch (\Exception $e) {
            $this->swal('Terjadi kesalahan saat konfirmasi data', $e->getMessage(), 'error');

            return;
        }
    }

    #[\Livewire\Attributes\On('assign')]
    public function assign($id)
    {
        return redirect()->route('driver.assign.to', $id);
    }

    public function swal($title, $text, $icon)
    {
        return $this->dispatch(
            'swal',
            title: $title,
            text: $text,
            icon: $icon
        );
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
