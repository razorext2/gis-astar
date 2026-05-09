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
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Spatie\Permission\Models\Role;

final class AttendanceOutTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'AttendanceOutTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $pegawai;

    public $jabatan;

    public $roles;

    public ?int $kodePegawai = null;

    public function setUp(): array
    {
        $auth = Auth::user();

        if ($auth->can('attendance-approve')) {
            $this->checkbox = true;
            $this->jabatan = \App\Models\Jabatan::select('id', 'nama_jabatan')->get();
            $this->roles = Role::select('id', 'name')->get();
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
            PowerGrid::exportable(fileName: 'absensi-keluar-'.now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        return AttendanceOut::query()
            ->with(['pegawaiRelasi', 'user'])
            ->join('tb_pegawai', 'tb_attendance_out.kode_pegawai', '=', 'tb_pegawai.kode_pegawai')
            ->leftJoin('users', 'tb_pegawai.kode_pegawai', '=', 'users.kode_pegawai')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('tb_attendance_out.*', 'tb_pegawai.full_name', 'tb_pegawai.jabatan', 'users.is_active')
            ->groupBy('tb_attendance_out.id', 'tb_pegawai.full_name', 'tb_pegawai.jabatan', 'users.is_active')
            ->when(auth()->user()->kode_pegawai, fn ($query, $kode) => $query->where('tb_attendance_out.kode_pegawai', $kode))
            ->when($this->kodePegawai, fn ($query, $kode) => $query->where('tb_attendance_out.kode_pegawai', $kode))
            ->latest('tb_attendance_out.jam_keluar');
    }

    public function relationSearch(): array
    {
        return [
            'pegawaiRelasi' => [
                'full_name',
                'kode_pegawai',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai')
            ->add('kode_pegawai_formatted', fn ($query) => Blade::render('components.table-component.codename', [
                'waktu' => $query->jam_keluar,
                'pegawai' => $query->pegawaiRelasi,
            ]))
            ->add('location', fn ($query) => Blade::render('components.table-component.location-and-status', ['data' => $query]))
            ->add('jam_keluar')
            ->add('jam_keluar_formatted', function ($query) {
                $timezone = $query->timezone ?? 'No timezone';

                return Blade::render('components.table-component.two-row-vertical', [
                    'a' => $query->waktuori.', '.$timezone,
                    'b' => $query->jam_keluar.', '.now()->timezone,
                ]);
            })
            ->add('status')
            ->add('status_formatted', fn ($query) => Blade::render('components.table-component.attendance-verify', [
                'status' => $query->status,
                'verified' => $query->verified ? 'verified' : 'unverified',
                'similarity' => (1 - round($query->distance ?? 1, 2)) * 100 .'%',
                'verified_by' => $query->verifiedBy ? $query->verifiedBy->name : $query->verified_by,
            ]))
            ->add('photo_url', fn ($query) => Blade::render('components.table-component.image-column', ['data' => $query]))
            ->add('created_at')
            ->add('updated_at')
            ->add('verified')
            ->add('full_name', fn ($query) => $query->full_name ?? '')
            ->add('jabatan', fn ($query) => $query->jabatan ?? '')
            ->add('roles_formatted', fn ($query) => collect($query->pegawaiRelasi?->userRelasi?->roles?->pluck('name'))->implode(', '))
            ->add('is_active', fn ($query) => $query->is_active ?? '');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'photo_url')
                ->visibleInExport(false),

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
                ->hidden(isHidden: true, isForceHidden: true)
                ->visibleInExport(true),

            Column::make('Verified', 'verified')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Nama Pegawai', 'full_name')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Jabatan', 'jabatan')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Roles', 'roles_formatted')
                ->hidden(isHidden: true, isForceHidden: true),

            Column::make('Status Akun', 'is_active')
                ->hidden(isHidden: true, isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        $filters = [
            Filter::datetimepicker('created_at', 'tb_attendance_out.created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                ]),
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

        if (Auth::user()->can('attendance-approve')) {
            $filters = array_merge($filters, [
                Filter::inputText('full_name', 'tb_pegawai.full_name')
                    ->placeholder('Nama Pegawai'),

                Filter::inputText('kode_pegawai', 'tb_attendance_out.kode_pegawai')
                    ->placeholder('Kode Jari'),

                Filter::select('jabatan', 'tb_pegawai.jabatan')
                    ->dataSource(collect($this->jabatan))
                    ->optionLabel('nama_jabatan')
                    ->optionValue('id'),

                Filter::select('roles_formatted', 'roles.id')
                    ->dataSource(collect($this->roles))
                    ->optionLabel('name')
                    ->optionValue('id'),

                Filter::boolean('is_active', 'users.is_active')
                    ->label('Aktif', 'Non-aktif'),
            ]);
        } else {
            $filters[] = Filter::select('kode_pegawai', 'kode_pegawai')
                ->dataSource($this->pegawai)
                ->optionLabel('full_name')
                ->optionValue('kode_pegawai');
        }

        return $filters;
    }

    public function actionsFromView($data)
    {
        if (Auth::user()->can('attendance-approve') && $data->verified == false && $data->status == 0) {
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
                    'status' => 1,
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
