<?php

/** Goal: Manage and display employee list, Caller: routes/web.php (pegawai.index), Deps: Pegawai, User */

namespace App\Livewire\PowergridTables;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Spatie\Permission\Models\Role;

final class PegawaiTable extends PowerGridComponent
{
    public string $tableName = 'PegawaiTable';

    public bool $deferLoading = true;

    public bool $showFilters = false;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage(25)
                ->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    public function datasource(): Builder
    {
        return Pegawai::query()
            ->leftJoin('users', 'tb_pegawai.kode_pegawai', '=', 'users.kode_pegawai')
            ->select(['tb_pegawai.*', 'users.is_active', 'users.deactivation_reason'])
            ->with([
                'userRelasi' => fn ($q) => $q->with(['roles', 'currentLeave']),
                'jabatanRelasi',
                'golonganRelasi',
            ])
            ->orderBy('users.is_active', 'desc')
            ->orderBy('full_name', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'jabatanRelasi' => ['nama_jabatan'],
            'golonganRelasi' => ['nama_golongan'],
            'userRelasi' => ['name', 'email', 'kode_pegawai'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('is_active')
            ->add('user_id', fn ($row) => $row->userRelasi?->id ?? '-')
            ->add('jabatan', fn ($row) => $row->jabatanRelasi?->nama_jabatan ?? '-')
            ->add('full_name', function ($row) {
                return view('components.dashboard.name-w-code', [
                    'capitalize' => false,
                    'code' => $row->kode_pegawai ?? '',
                    'name' => $row->full_name,
                    'item3' => $row->userRelasi?->roles?->pluck('name')->implode(', ') ?? '',
                    'is_active' => $row->userRelasi ? (bool) $row->userRelasi->is_active : null,
                ])->render();
            })
            ->add('email_formatted', fn ($row) => view('components.dashboard.name-w-code', [
                'capitalize' => false,
                'code' => $row->userRelasi?->email ?? '',
                'name' => $row->no_telp ?? '',
            ])->render())
            ->add('join_date_formatted', function ($row) {
                if (! $row->userRelasi?->join_date) {
                    return '-';
                }

                return Carbon::parse($row->userRelasi->join_date)->locale('id')->isoFormat('DD MMM YYYY');
            })
            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'))
            ->add('golongan_formatted', fn ($row) => view('components.dashboard.name-w-code', [
                'code' => $row->golonganRelasi?->nama_golongan ?? '',
                'name' => $row->jabatanRelasi?->nama_jabatan ?? 'User only',
            ])->render())
            ->add('roles_formatted', fn ($row) => $row->userRelasi?->roles?->pluck('name')->implode(', ') ?? '')
            ->add('status_formatted', fn ($row) => $this->renderStatusBadge($row));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),

            Column::make('UserID', 'user_id'),
            Column::make('Status', 'status_formatted'),
            Column::make('Kode Pegawai', 'kode_pegawai')->hidden(),
            Column::make('Fullname', 'full_name'),
            Column::make('Jabatan', 'jabatan')->hidden(),
            Column::make('Golongan', 'golongan_formatted'),
            Column::make('Contact Person', 'email_formatted'),
            Column::make('Roles', 'roles_formatted'),
            Column::make('No Telepon', 'no_telp')->hidden(),
            Column::make('Join Date', 'join_date_formatted'),
            Column::make('Created at', 'created_at_formatted', 'created_at'),
        ];
    }

    public function filters(): array
    {
        $golongan = Golongan::select(['id', 'nama_golongan'])->get();
        $jabatan = Jabatan::select(['id', 'nama_jabatan'])->get();
        $roles = Role::select(['id', 'name'])->get();

        return [
            Filter::boolean('is_active', 'users.is_active')
                ->label('Aktif', 'Non-aktif'),

            Filter::inputText('kode_pegawai', 'tb_pegawai.kode_pegawai')
                ->placeholder('Kode Jari'),

            Filter::inputText('full_name', 'tb_pegawai.full_name')
                ->placeholder('Nama lengkap'),

            Filter::select('golongan_formatted', 'tb_pegawai.golongan')
                ->dataSource(collect($golongan))
                ->optionLabel('nama_golongan')
                ->optionValue('id'),

            Filter::select('jabatan', 'tb_pegawai.jabatan')
                ->dataSource(collect($jabatan))
                ->optionLabel('nama_jabatan')
                ->optionValue('id'),

            Filter::datetimepicker('created_at', 'tb_pegawai.created_at')
                ->params(['timezone' => 'Asia/Jakarta']),

            Filter::inputText('no_telp', 'tb_pegawai.no_telp')
                ->placeholder('No telp'),

            Filter::select('roles_formatted', 'role_id')
                ->dataSource(collect($roles))
                ->optionLabel('name')
                ->optionValue('id')
                ->builder(function (Builder $query, $value) {
                    $query->whereExists(function ($sub) use ($value) {
                        $sub->from('model_has_roles')
                            ->whereColumn('model_has_roles.model_id', 'users.id')
                            ->where('model_has_roles.model_type', User::class)
                            ->where('model_has_roles.role_id', $value);
                    });
                }),
        ];
    }

    public function actionsFromView(Pegawai $row): View
    {
        return view('components.dashboard.single-button', [
            'data' => [
                'id' => $row->id,
                'action' => route('pegawai.detail', $row->id),
                'label' => 'Detail',
            ],
        ]);
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }

    private function renderStatusBadge(Pegawai $row): string
    {
        if (! $row->userRelasi) {
            return '<span class="inline-flex items-center rounded-lg bg-gray-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gray-800 dark:bg-zinc-800 dark:text-zinc-500">No Account</span>';
        }

        $leaveBadge = $row->userRelasi->currentLeave
            ? '<p class="mt-1"><span class="inline-flex items-center rounded-lg bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">Sedang Cuti</span></p>'
            : '';

        if ($row->userRelasi->is_active) {
            return '<div class="flex flex-col items-start">
                        <span class="inline-flex items-center rounded-lg bg-green-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-green-800 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                        '.$leaveBadge.'
                    </div>';
        }

        $reason = $row->deactivation_reason
            ? '<p class="mt-1 text-[10px] text-gray-500 italic dark:text-gray-400">'.ucwords($row->deactivation_reason).'</p>'
            : '';

        return '<div class="flex flex-col items-start">
                    <span class="inline-flex items-center rounded-lg bg-red-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-red-800 dark:bg-red-900/30 dark:text-red-400">Non-aktif</span>
                    '.$reason.'
                    '.$leaveBadge.'
                </div>';
    }
}
