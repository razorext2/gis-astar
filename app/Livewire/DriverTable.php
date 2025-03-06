<?php

namespace App\Livewire;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DriverTable extends PowerGridComponent
{
    public string $tableName = 'DriverTable';
    public bool $showFilters = true;
    public bool $deferLoading = true;
    public $pegawai;

    public function setUp(): array
    {
        $this->pegawai = User::role('Driver')->get();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
        ];
    }

    public function datasource(): Builder
    {
        $data = Driver::query()
            ->with(['user', 'photoCollect']);

        if (!auth()->user()->can('driver-approve')) {
            $data->where('kode_pegawai', auth()->user()->kode_pegawai);
        }

        return $data->latest();
    }

    public function relationSearch(): array
    {
        return [
            'user' => [
                'name',
                'kode_pegawai'
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai')
            ->add('title')
            ->add('lokasi')
            ->add('keterangan')
            ->add('longitude')
            ->add('latitude')
            ->add('status')
            ->add('status_formatted', function ($query) {
                $status = $query->status;

                return view('components.dashboard.title-w-status-two', [
                    'title' => [
                        0 => 'Diajukan',
                        1 => 'Disetujui',
                        2 => 'Ditolak',
                    ][$status],
                    'status' => $status
                ])->render();
            })
            ->add('notes')
            ->add('validate_by', fn($query) => e($query->user->name))
            ->add('created_at')
            ->add('created_at_formatted', fn($query)
                => Carbon::parse($query->created_at)
                    ->locale('id')
                    ->isoFormat('D MMMM YYYY HH:mm:ss'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Kode pegawai', 'kode_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Judul Laporan', 'title')
                ->sortable()
                ->searchable(),

            Column::make('Lokasi', 'lokasi')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status_formatted', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Keterangan', 'keterangan')
                ->sortable()
                ->searchable(),

            Column::make('Longitude', 'longitude')
                ->sortable()
                ->searchable(),

            Column::make('Latitude', 'latitude')
                ->sortable()
                ->searchable(),

            Column::make('Catatan', 'notes')
                ->sortable()
                ->searchable(),

            Column::make('Divalidasi oleh', 'validate_by')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('kode_pegawai', 'kode_pegawai')
                ->dataSource($this->pegawai)
                ->optionLabel('name')
                ->optionValue('kode_pegawai'),
            Filter::multiSelect('status', 'status')
                ->dataSource([
                    [
                        'value' => 0,
                        'label' => 'Diajukan'
                    ],
                    [
                        'value' => 1,
                        'label' => 'Disetujui'
                    ],
                    [
                        'value' => 2,
                        'label' => 'Ditolak'
                    ],
                ])
                ->optionLabel('label')
                ->optionValue('value'),
            Filter::datepicker('created_at', 'created_at')

        ];
    }

    public function actionsFromView(Driver $row): View
    {
        $actions = [
            [
                'id' => 'show-btn',
                'action' => route('driver.show', $row->id),
                'label' => 'Show'
            ],
            [
                'id' => 'edit-btn',
                'action' => route('driver.edit', $row->id),
                'label' => 'Edit'
            ]
        ];

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

        if (!$data) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');
            return;
        }

        try {
            $data->delete();

            $this->swal('Terhapus!', 'Data yang dipilih berhasil dihapus.', 'success');

            Log::info($request->user() . " : Menghapus data {$id}");
        } catch (\Exception $e) {
            $this->swal('Gagal!', "Terjadi kesalahan saat menghapus data dengan ID <b>$id</b>", 'error');

            Log::info($request->user()->kode_pegawai . " : Gagal menghapus data {$id}. {$e->getMessage()}");
        }
    }

    #[\Livewire\Attributes\On('detail')]
    public function detail($id): void
    {
        $data = Driver::with(['pegawai', 'photoCollect'])
            ->where('id', $id)
            ->first();

        if (!$data) {
            $this->swal('Gagal!', 'Data tidak ditemukan', 'error');
            return;
        }

        $this->dispatch('detailModal', data: $data);
    }

    #[\Livewire\Attributes\On('confirmAction')]
    public function confirmAction($id, $user_id): void
    {
        $query = Driver::find($id);

        if (!$query) {
            $this->swal("Gagal!", 'Data tidak ditemukan.', 'error');
            return;
        }

        try {
            $query->update([
                'status' => 1,
                'validate_by' => $user_id,
            ]);

            $this->swal("Dikonfirmasi!", 'Data yang dipilih berhasil dikonfirmasi.', 'success');
        } catch (\Exception $e) {
            $this->swal("Terjadi kesalahan saat konfirmasi data", $e->getMessage(), 'error');
            return;
        }
    }

    #[\Livewire\Attributes\On('declineAction')]
    public function declineAction($id, $note, $user_id): void
    {
        $query = Driver::find($id);

        if (!$query) {
            $this->swal("Gagal!", 'Data tidak ditemukan.', 'error');
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
            $this->swal("Terjadi kesalahan saat konfirmasi data", $e->getMessage(), 'error');
            return;
        }
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
}
