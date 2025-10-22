<?php

namespace App\Livewire;

use \App\Models\Team;
use \App\Models\Technician;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class TechnicianTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'TechnicianTable';
    public bool $deferLoading = true;
    public bool $showFilters = false;
    public string $status;
    public $teams = [];

    public function setUp(): array
    {
        if (auth()->user()->can('technician-approve')) {
            $this->showCheckBox();
        }

        $this->status = Request::query('status') ?? '';
        $this->teams = Team::all();

        return [
            PowerGrid::header()
                ->showSoftDeletes()
                ->showToggleColumns(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(now()->format('ymdhis') . '-TechnicianTable.xlsx')
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true)
        ];
    }

    public function datasource(): Builder
    {
        $query = Technician::query()
            ->select('tb_technician.*', 'tb_team_members.team_code', 'tb_teams.team_name')
            ->with('pegawai', 'point')
            ->leftJoin('tb_team_members', 'tb_team_members.kode_pegawai', '=', 'tb_technician.kode_pegawai')
            ->leftJoin('tb_teams', 'tb_teams.team_code', '=', 'tb_team_members.team_code')
            ->orderBy('tb_technician.visit_date', 'desc');

        if ($this->status != '') {
            match ($this->status) {
                'unapproved' => $query->where('status', 0),
                'needrevision' => $query->where('status', 2),
                'approved' => $query->where('status', 1),
                'rejected' => $query->where('status', 3),
            };
        }

        if (auth()->user()->can('technician-approve')) {
            if (!auth()->user()->can('technician-all')) {
                $query->where('status', '!=', 4);
            }
        } else {
            $query->where('tb_technician.kode_pegawai', auth()->user()->kode_pegawai);
        }

        return $query;
    }

    public function relationSearch(): array
    {
        return [
            'pegawai' => [
                'kode_pegawai',
                'full_name',
                'no_telp'
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('no_vt')
            ->add('id_permintaan')
            ->add('kode_pegawai')
            ->add('technician_name', fn($query) => $query->pegawai->full_name ?? 'Teknisi belum terdaftar di sistem')
            ->add('customer_contact')
            ->add('weight_type')
            ->add('visit_date')
            ->add('created_at')
            ->add('updated_at')
            ->add('team_code', fn($query) => $query->team_code)
            ->add('no_vt_formatted', function ($query) {
                if ($query->status == 0) {
                    $status = 'Diajukan';
                } elseif ($query->status == 1) {
                    $status = 'Diterima';
                } elseif ($query->status == 2) {
                    $status = 'Butuh revisi';
                } elseif ($query->status == 3) {
                    $status = 'Ditolak';
                } elseif ($query->status == 4) {
                    $status = 'Draft';
                } else {
                    $status = 'Status tidak diketahui';
                }

                return view('components.dashboard.name-w-code', [
                    'code' => $query->id_permintaan,
                    'name' => $query->no_vt,
                    'item3' => $status
                ]);
            })
            ->add('pegawai_info', fn($query) => view('components.dashboard.name-w-code', [
                'code' => $query->kode_pegawai,
                'name' => $query->pegawai->full_name ?? 'Teknisi belum terdaftar di sistem',
                'item3' => $query->team_code
            ]))
            ->add('customer_info', fn($query) => view('components.dashboard.name-w-code', [
                'code' => $query->customer_address,
                'name' => $query->customer_contact,
                'item3' => '+ ' . $query->point?->point . ' Poin'
            ]))
            ->add('tanggal_kunjungan_formatted', fn($query) => view('components.dashboard.title-w-status', [
                'title' => Carbon::parse($query->visit_date)->locale('id')->isoFormat('DD MMM YYYY'),
                'status' => $query->status
            ]))
            ->add('created_at_formatted', fn($query) => Carbon::parse($query->created_at)->locale('id')->isoFormat('HH:mm:ss, DD MMMM YYYY'))
            ->add('updated_at_formatted', fn($query) => Carbon::parse($query->updated_at)->locale('id')->isoFormat('HH:mm:ss, DD MMMM YYYY'))
        ;
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('No VT', 'no_vt_formatted', 'no_vt')
                ->sortable()
                ->searchable()
                ->visibleInExport(false),

            Column::make('Kode Jari', 'kode_pegawai')
                ->hidden(),

            Column::make('Teknisi', 'pegawai_info', 'kode_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Tim', 'team_code', 'team_code')
                ->hidden(true),

            Column::make('Customer', 'customer_info', 'customer_contact')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal Kunjungan', 'tanggal_kunjungan_formatted', 'visit_date')
                ->sortable()
                ->searchable(),

            Column::make('Tipe Timbangan', 'weight_type')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Updated at', 'updated_at_formatted', 'updated_at')
                ->sortable()
        ];
    }

    public function filters(): array
    {
        $filters = [];

        $filters = [
            Filter::inputText('no_vt', 'no_vt')
                ->placeholder('Cari no vt'),
            Filter::inputText('kode_pegawai', 'kode_pegawai')
                ->placeholder('Cari kode jari'),
            Filter::inputText('pegawai_info')
                ->filterRelation('pegawai', 'full_name'),
            Filter::inputText('customer_info')
                ->filterRelation('customer', 'full_name'),
            Filter::inputText('weight_type', 'weight_type')
                ->placeholder('Cari tipe timbangan'),
            Filter::datepicker('tanggal_kunjungan_formatted', 'visit_date')
                ->filterRelation('visit_date', 'visit_date'),
        ];

        if (auth()->user()->can('technician-approve')) {
            $filters[] = Filter::select('team_code', 'tb_team_members.team_code')
                ->dataSource($this->teams)
                ->optionLabel('team_name')
                ->optionValue('team_code');
        }

        return $filters;
    }

    public function actions(Technician $row): array
    {
        $button = [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('technician.show', ['technician' => $row->no_vt]),
        ];

        if ($row->status == 2 || $row->status == 4 || auth()->user()->can('technician-approve')) {
            $button[] = Button::make('edit')
                ->slot('Update')
                ->id($row->id)
                ->class('dark:bg-blue-800 text-sm dark:hover:bg-blue-900 dark:text-white dark:border-gray-700 rounded-lg bg-blue-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-blue-700')
                ->route('technician.create', ['id' => $row->no_vt]);
        }

        return $button;
    }

    public function queryString()
    {
        return $this->powerGridQueryString();
    }
}
