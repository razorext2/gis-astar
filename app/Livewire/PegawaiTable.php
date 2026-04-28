<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Spatie\Permission\Models\Role;

final class PegawaiTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'PegawaiTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public $golongan;

    public $jabatan;

    public $roles;

    public function setUp(): array
    {
        $this->golongan = \App\Models\Golongan::select('id', 'nama_golongan')->get();
        $this->jabatan = \App\Models\Jabatan::select('id', 'nama_jabatan')->get();
        $this->roles = Role::select('id', 'name')->get();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage(25)
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(fileName: 'userAccount-'.now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        return Pegawai::query()
            ->leftJoin('users', 'tb_pegawai.kode_pegawai', '=', 'users.kode_pegawai')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('tb_pegawai.*', 'users.is_active', 'users.deactivation_reason')
            ->groupBy('tb_pegawai.id', 'users.is_active', 'users.deactivation_reason')
            ->with(['userRelasi', 'userRelasi.roles', 'userRelasi.currentLeave', 'jabatanRelasi', 'golonganRelasi'])
            ->orderBy('users.is_active', 'desc')
            ->orderBy('full_name', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'jabatanRelasi' => [
                'nama_jabatan',
            ],
            'golonganRelasi' => [
                'nama_golongan',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('is_active')
            ->add('user_id', fn ($query) => $query->userRelasi->id ?? '-')
            ->add('jabatan', fn ($query) => $query->jabatanRelasi->nama_jabatan ?? '-')
            ->add('full_name', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'capitalize' => false,
                    'code' => $query->kode_pegawai ?? '',
                    'name' => $query->full_name,
                    'item3' => collect($query->userRelasi->roles->pluck('name'))->implode(', '),
                ])->render();
            })
            ->add('email_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'capitalize' => false,
                    'code' => $query->userRelasi->email ?? '',
                    'name' => $query->no_telp ?? '',
                ])->render();
            })
            ->add('created_at_formatted', fn ($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'))
            ->add('golongan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->golonganRelasi->nama_golongan ?? '',
                    'name' => $query->jabatanRelasi->nama_jabatan ?? 'User only',
                ])->render();
            })
            ->add('roles_formatted', function ($query) {
                return collect($query->userRelasi->roles->pluck('name'))->implode(', ');
            })
            ->add('status_formatted', function ($query) {
                if (! $query->userRelasi) {
                    return '<span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gray-800 dark:bg-zinc-800 dark:text-zinc-500">No Account</span>';
                }

                $leaveBadge = $query->userRelasi->currentLeave
                    ? '<p class="mt-1"><span class="inline-flex items-center rounded-lg bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">Sedang Cuti</span></p>'
                    : '';

                if ($query->userRelasi->is_active) {
                    return '
                        <div class="flex flex-col items-start">
                            <span class="inline-flex items-center rounded-lg bg-green-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-green-800 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                            '.$leaveBadge.'
                        </div>
                    ';
                }

                $reason = $query->deactivation_reason ? '<p class="mt-1 text-[10px] text-gray-500 italic dark:text-gray-400">'.ucwords($query->deactivation_reason).'</p>' : '';

                return '
                    <div class="flex flex-col items-start">
                        <span class="inline-flex items-center rounded-lg bg-red-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-red-800 dark:bg-red-900/30 dark:text-red-400">Non-aktif</span>
                        '.$reason.'
                        '.$leaveBadge.'
                    </div>
                ';
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->visibleInExport(false)
                ->bodyAttribute('text-center'),
            Column::make('UserID', 'user_id'),

            Column::make('Status', 'status_formatted'),

            Column::make('Kode Pegawai', 'kode_pegawai')
                ->hidden(),

            Column::make('Fullname', 'full_name'),

            Column::make('Jabatan', 'jabatan')
                ->hidden(),

            Column::make('Golongan', 'golongan_formatted'),

            Column::make('Contact Person', 'email_formatted'),

            Column::make('Roles', 'roles_formatted'),

            Column::make('No Telepon', 'no_telp')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at'),

        ];
    }

    public function filters(): array
    {
        return [
            Filter::boolean('is_active')
                ->label('Aktif', 'Non-aktif'),

            Filter::inputText('kode_pegawai', 'kode_pegawai')
                ->placeholder('Kode Jari'),
            Filter::inputText('full_name', 'full_name')
                ->placeholder('Nama lengkap'),

            Filter::select('golongan_formatted', 'golongan')
                ->dataSource(collect($this->golongan))
                ->optionLabel('nama_golongan')
                ->optionValue('id'),

            Filter::select('jabatan', 'jabatan')
                ->dataSource(collect($this->jabatan))
                ->optionLabel('nama_jabatan')
                ->optionValue('id'),

            Filter::datetimepicker('created_at', 'created_at')
                ->params([
                    'timezone' => 'Asia/Jakarta',
                ]),

            Filter::inputText('no_telp', 'no_telp')
                ->placeholder('No telp'),

            Filter::select('roles_formatted', 'roles.id')
                ->dataSource(collect($this->roles))
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function actions(Pegawai $row): array
    {
        return [];
    }

    public function actionsFromView(Pegawai $row)
    {
        return view(
            'components.dashboard.single-button',
            [
                'data' => [
                    'id' => $row->id,
                    'action' => route('pegawai.detail', $row->id),
                    'label' => 'Detail',
                ],
            ]
        );
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
