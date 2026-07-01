<?php

/** Goal: Menampilkan tabel manajemen User dengan relasi roles & jabatan, Caller: routes/web.php (users.index), Deps: User, Jabatan, Role */

namespace App\Livewire\PowergridTables;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use Spatie\Permission\Models\Role;

final class UserTable extends PowerGridComponent
{
    public string $tableName = 'UserTable';

    public bool $deferLoading = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
        ];
    }

    /**
     * Hanya join tb_pegawai untuk kebutuhan filter jabatan.
     * Roles dihandle via Eloquent with() + relationSearch (whereHas).
     * Menghindari leftJoin ke model_has_roles yang menyebabkan duplikasi baris
     * per role dan membuat PowerGrid hanya menampilkan 1 data.
     */
    public function datasource(): Builder
    {
        return User::query()
            ->leftJoin('tb_pegawai', 'users.kode_pegawai', '=', 'tb_pegawai.kode_pegawai')
            ->select('users.*')
            ->with(['pegawai.jabatanRelasi', 'roles'])
            ->orderByDesc('users.is_active')
            ->orderBy('users.name', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'roles' => ['name'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('kode_pegawai', fn ($row) => view('components.dashboard.date-w-name', [
                'date' => 'UserID: '.$row->id,
                'name' => 'Kode jari: '.($row->kode_pegawai ?? '-'),
            ]))
            ->add('name', fn ($row) => view('components.dashboard.date-w-name', [
                'date' => $row->name,
                'name' => $row->email,
                'is_active' => (bool) $row->is_active,
            ]))
            ->add('email')
            ->add('roles_formatted', fn ($row) => $row->roles->pluck('name')->implode(', ') ?: '-')
            ->add('jabatan', fn ($row) => $row->pegawai?->jabatanRelasi?->nama_jabatan ?? '-')
            ->add('is_active')
            ->add('is_active_formatted', fn ($row) => view('components.table-component.badge-status', [
                'active' => (bool) $row->is_active,
                'label_active' => 'Active',
                'label_inactive' => 'Inactive',
            ])->render())
            ->add('created_at_formatted', fn ($row) => Carbon::parse($row->created_at)
                ->locale('id')
                ->isoFormat('DD MMM YYYY HH:mm'));
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),

            Column::make('Kode / ID', 'kode_pegawai')
                ->searchable(),

            Column::make('Nama', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->hidden()
                ->searchable(),

            Column::make('Roles', 'roles_formatted'),

            Column::make('Jabatan', 'jabatan'),

            Column::make('Status', 'is_active_formatted', 'is_active')
                ->sortable(),

            Column::make('Dibuat', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        $roles = Role::select(['id', 'name'])->get();
        $jabatans = Jabatan::select(['id', 'nama_jabatan'])->get();

        return [
            Filter::inputText('kode_pegawai', 'users.kode_pegawai')
                ->placeholder('Kode jari'),

            Filter::inputText('id', 'users.id')
                ->placeholder('User ID'),

            Filter::inputText('name', 'users.name')
                ->placeholder('Nama'),

            Filter::boolean('is_active', 'users.is_active')
                ->label('Aktif', 'Tidak aktif'),

            Filter::select('roles_formatted', 'role_id')
                ->dataSource(collect($roles))
                ->optionLabel('name')
                ->optionValue('id')
                ->builder(fn (Builder $query, $value) => $query->whereHas('roles', fn ($q) => $q->where('id', $value))),

            Filter::select('jabatan', 'tb_pegawai.jabatan')
                ->dataSource(collect($jabatans))
                ->optionLabel('nama_jabatan')
                ->optionValue('id'),
        ];
    }

    public function actions(User $row): array
    {
        $buttons = [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('rounded-lg bg-blue-400 px-2 py-1.5 text-xs font-semibold text-white hover:bg-blue-700 dark:bg-blue-800 dark:hover:bg-blue-900 me-0.5')
                ->route('users.edit', ['user' => $row->id]),
        ];

        if ($row->kode_pegawai && $row->pegawai) {
            $buttons[] = Button::add('detail')
                ->slot('Pegawai')
                ->id()
                ->class('rounded-lg bg-green-400 px-2 py-1.5 text-xs font-semibold text-white hover:bg-green-700 dark:bg-green-800 dark:hover:bg-green-900 me-0.5')
                ->route('pegawai.detail', ['pegawai' => $row->pegawai->id]);
        }

        return $buttons;
    }

    public function queryString(): array
    {
        return $this->powerGridQueryString();
    }
}
