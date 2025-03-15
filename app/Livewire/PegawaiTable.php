<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PegawaiTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'PegawaiTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;
    public $golongan;
    public $jabatan;

    public function setUp(): array
    {
        $this->golongan = \App\Models\Golongan::select('id', 'nama_golongan')->get();
        $this->jabatan = \App\Models\Jabatan::select('id', 'nama_jabatan')->get();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage(25)
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(fileName: 'userAccount-' . now()->format('YmdHis'))
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true),
        ];
    }

    public function datasource(): Builder
    {
        return Pegawai::query()
            ->with(['userRelasi', 'userRelasi.roles', 'jabatanRelasi', 'golonganRelasi'])
            ->orderBy('full_name', 'asc');
    }

    public function relationSearch(): array
    {
        return [
            'jabatanRelasi' => [
                'nama_jabatan'
            ],
            'golonganRelasi' => [
                'nama_golongan'
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('user_id', fn($query) => $query->userRelasi->id)
            ->add('full_name', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'capitalize' => false,
                    'code' => $query->kode_pegawai ?? '',
                    'name' => $query->full_name,
                    'item3' => collect($query->userRelasi->roles->pluck('name'))->implode(', ')
                ])->render();
            })
            ->add('email_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'capitalize' => false,
                    'code' => $query->userRelasi->email ?? '',
                    'name' => $query->no_telp ?? ''
                ])->render();
            })
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss'))
            ->add('golongan_formatted', function ($query) {
                return view('components.dashboard.name-w-code', [
                    'code' => $query->golonganRelasi->nama_golongan ?? '',
                    'name' => $query->jabatanRelasi->nama_jabatan ?? 'User only'
                ])->render();
            });
    }

    public function columns(): array
    {
        return [
            Column::action('Action')
                ->visibleInExport(false)
                ->bodyAttribute('text-center'),
            Column::make('UserID', 'user_id'),

            Column::make('Kode Pegawai', 'kode_pegawai')
                ->hidden(),

            Column::make('Fullname', 'full_name'),

            Column::make('Jabatan', 'jabatan')
                ->hidden(),

            Column::make('Golongan', 'golongan_formatted'),

            Column::make('Contact Person', 'email_formatted'),

            Column::make('No Telepon', 'no_telp')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at'),

        ];
    }

    public function filters(): array
    {
        return [

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
                    'label' => 'Detail'
                ]
            ]
        );
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
