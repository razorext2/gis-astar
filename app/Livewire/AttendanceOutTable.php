<?php

namespace App\Livewire;

use App\Models\AttendanceOut;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AttendanceOutTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'AttendanceOutTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;
    public $pegawai;

    public function setUp(): array
    {
        $auth = Auth::user();

        if ($auth->can('attendance-approve')) {
            $this->checkbox = true;
        }

        $this->pegawai = Pegawai::orderBy('full_name')
            ->whereHas('attendanceOutRelasi')
            ->get();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(fileName: 'absensi-keluar')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->onQueue('absensiKeluar')
                ->onConnection('redis')
        ];
    }

    public function datasource(): Builder
    {
        $data = AttendanceOut::query()
            ->with('pegawaiRelasi');

        if (auth()->user()->kode_pegawai) {
            $data->where('kode_pegawai', auth()->user()->kode_pegawai);
        }

        return $data->latest();
    }

    public function relationSearch(): array
    {
        return [
            'pegawaiRelasi' => [
                'full_name',
                'kode_pegawai',
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai')
            ->add('kode_pegawai_formatted', fn($query) => Blade::render('components.table-component.codename', ['data' => $query]))
            ->add('location', fn($query) => Blade::render('components.table-component.location-and-status', ['data' => $query]))
            ->add('jam_keluar')
            ->add('jam_keluar_formatted', function ($query) {
                $timezone = $query->timezone ?? 'No timezone';

                return Blade::render('components.table-component.two-row-vertical', [
                    'a' => $query->waktuori . ', ' . $timezone,
                    'b' => $query->jam_keluar . ', ' . now()->timezone,
                ]);
            })
            ->add('status')
            ->add('status_formatted', fn($query) => Blade::render('components.table-component.attendance-verify', [
                'status' => $query->status,
                'verified' => $query->verified ? 'verified' : 'unverified',
                'similarity' => (1 - round($query->distance ?? 1, 2)) * 100 . '%',
                'verified_by' => $query->verifiedBy ? $query->verifiedBy->name : $query->verified_by
            ]))
            ->add('photo_url', fn($query) => Blade::render('components.table-component.image-column', ['data' => $query]))
            ->add('created_at')
            ->add('updated_at')
            ->add('verified');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'photo_url'),

            Column::make('Pegawai', 'kode_pegawai_formatted'),

            Column::make('Status Verifikasi', 'status_formatted'),

            Column::make('Jam Keluar', 'jam_keluar_formatted')
                ->sortable()
                ->searchable(),

            Column::make('Lokasi', 'location'),

            Column::action('Aksi')
                ->hidden(isHidden: Auth::user()->can('attendance-approve') == false)
                ->fixedOnResponsive(),

            Column::make('Created at', 'created_at')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Verified', 'verified')
                ->hidden(isHidden: true, isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                    'no_weekends' => true,
                ]),
            Filter::select('kode_pegawai', 'kode_pegawai')
                ->dataSource($this->pegawai)
                ->optionLabel('full_name')
                ->optionValue('kode_pegawai'),
            Filter::select('verified', 'verified')
                ->dataSource([
                    0 => [
                        'name' => 'Unverified',
                        'value' => 0,
                    ],
                    1 => [
                        'name' => 'Verified',
                        'value' => 1,
                    ],
                ])
                ->optionLabel('name')
                ->optionValue('value'),
        ];
    }

    public function actionsFromView($data)
    {
        if (Auth::user()->can('attendance-approve') && $data->verified == false) {
            return view('components.table-component.confirm-button', [
                'data' => $data,
            ]);
        }
    }

    #[On('verifikasi')]
    public function verifikasi($id)
    {
        $this->dispatch(
            'confirmation',
            id: $id,
            tableName: $this->tableName,
            action: 'attendanceVerificationAction'
        );
    }

    #[On('attendanceVerificationAction.{tableName}')]
    public function verificationProcess($id, $tableName)
    {
        if ($tableName == $this->tableName) {
            try {
                $query = AttendanceOut::where('id', $id)->update([
                    'verified' => 1,
                    'verified_by' => Auth::id(),
                    'status' => 1
                ]);

                if ($query) {
                    $this->swal('Berhasil', 'Absensi berhasil di verifikasi', 'success');
                }
            } catch (\Exception $e) {
                Log::error($e);

                return $this->swal('Gagal', 'Absensi gagal di verifikasi', 'error');
            }
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
