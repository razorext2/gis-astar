<?php

namespace App\Livewire;

use \App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Spatie\Permission\Models\Role;

final class UserTable extends PowerGridComponent
{
    public string $tableName = 'UserTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
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
        return User::query()
            ->with(['pegawai', 'roles'])
            ->orderBy('name', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'roles' => 'name',
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('kode_pegawai', function ($query) {
                return view('components.dashboard.date-w-name', [
                    'date' => 'UserID: ' . $query->id,
                    'name' => 'Kode jari: ' . $query->kode_pegawai
                ]);
            })
            ->add('name', function ($query) {
                return view('components.dashboard.date-w-name', [
                    'date' => $query->name,
                    'name' => $query->email
                ]);
            })
            ->add('roles_formatted', function ($query) {
                return collect($query->roles->pluck('name'))->implode(', ');
            })
            ->add('email')
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'))
            ->add('is_active')
            ->add('is_active_formatted', function ($query) {
                $html = "<span class='text-white text-xs px-2.5 items-center py-0.5 rounded-xl " . ($query->is_active ? 'bg-green-500' : 'bg-red-500') . "'> " . ($query->is_active ? 'Active' : 'Inactive') . " </span>";

                return $html;
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->bodyAttribute('text-center'),
            Column::make('ID', 'id')->hidden()->searchable(),
            Column::make('Kode pegawai', 'kode_pegawai'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->hidden()
                ->searchable(),

            Column::make('Status', 'is_active_formatted'),

            Column::make('Status', 'is_active')
                ->hidden()
                ->searchable(),

            Column::make('Roles', 'roles_formatted'),

            Column::make('Created at', 'created_at_formatted', 'created_at'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('kode_pegawai', 'kode_pegawai')
                ->placeholder('Kode jari'),
            Filter::inputText('id', 'id')
                ->placeholder('User ID'),
            Filter::inputText('name', 'name')
                ->placeholder('Nama'),
            Filter::boolean('is_active')
                ->label('Aktif', 'Tidak aktif')

        ];
    }

    public function actions(User $row)
    {
        $button = [];

        $button[] = Button::add('edit')
            ->slot('Edit')
            ->id()
            ->class("dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700 me-0.5")
            ->route('users.edit', ['user' => $row->id]);

        if ($row->kode_pegawai) {
            $button[] =
                Button::add('detail')
                    ->slot('Pegawai')
                    ->id()
                    ->class("dark:bg-green-800 dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700 me-0.5")
                    ->route('pegawai.detail', ['pegawai' => $row->pegawai->id]);
        }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
