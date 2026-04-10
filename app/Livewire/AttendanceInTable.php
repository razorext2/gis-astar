<?php

namespace App\Livewire;

use App\Models\Attendance;
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

final class AttendanceInTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'AttendanceTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $pegawai;

    public ?int $kodePegawai = null;

    public function setUp(): array
    {
        $auth = Auth::user();

        if ($auth->can('attendance-approve')) {
            $this->checkbox = true;
        }

        $this->pegawai = Pegawai::orderBy('full_name')
            ->whereHas('attendanceRelasi')
            ->get();

        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive()
                ->fixedColumns('kode_pegawai_formatted', 'action'),
            PowerGrid::exportable(fileName: 'absensi-masuk-'.now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        $data = Attendance::query()
            ->with('pegawaiRelasi', 'verifiedBy');

        if (auth()->user()->kode_pegawai) {
            $data->where('kode_pegawai', auth()->user()->kode_pegawai);
        }

        if ($this->kodePegawai) {
            $data->where('kode_pegawai', $this->kodePegawai);
        }

        return $data->latest();
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
                'waktu' => $query->jam_masuk,
                'pegawai' => $query->pegawaiRelasi,
            ]))
            ->add('location', fn ($query) => Blade::render('components.table-component.location-and-status', ['data' => $query]))
            ->add('jam_masuk')
            ->add('jam_masuk_formatted', function ($query) {
                $timezone = $query->timezone ?? 'No timezone';

                return Blade::render('components.table-component.two-row-vertical', [
                    'a' => $query->waktuori.', '.$timezone,
                    'b' => $query->jam_masuk.', '.now()->timezone,
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
            ->add('verified');
    }

    public function columns(): array
    {
        return [
            Column::make('#', 'photo_url')
                ->visibleInExport(false),

            Column::make('Pegawai', 'kode_pegawai_formatted'),

            Column::make('Status Verifikasi', 'status_formatted'),

            Column::make('Jam Masuk', 'jam_masuk_formatted')
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
                $query = Attendance::where('id', $id)->update([
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
