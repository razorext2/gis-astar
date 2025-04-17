<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Pegawai;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class AttendanceInTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'AttendanceTable';
    public bool $deferLoading = true;
    public bool $showFilters = true;
    public $pegawai;

    public function setUp(): array
    {
        $this->showCheckBox();

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
            PowerGrid::responsive(),
            PowerGrid::exportable(fileName: 'absensi-masuk')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
                ->onQueue('absensiMasuk')
                ->onConnection('redis')
        ];
    }

    public function datasource(): Builder
    {
        $data = Attendance::query()
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
            ->add('kode_pegawai', function ($query) {
                $pegawai = $query->pegawaiRelasi;
                if ($pegawai) {
                    $url = route('pegawai.timeline', $pegawai->kode_pegawai);
                    return '<a target="_blank" class="underline hover:text-blue-600 transition-colors duration-500" href="' . $url . '">' . e($pegawai->full_name) . '</a>';
                }
                return '-';
            })
            ->add('jenis')
            ->add('status')
            ->add('longitude', fn($query) => $query->longitude ?? '-')
            ->add('latitude', fn($query) => $query->latitude ?? '-')
            ->add('jam_masuk', fn($query) => Carbon::parse($query->jam_masuk)->locale('id')->isoFormat('YYYY-MM-DD HH:mm:ss'))
            ->add('photoURL', fn($query) => Blade::render('components.table-component.image-column', ['data' => $query]))
            ->add('created_at')
            ->add('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),

            Column::make('#', 'photoURL')
                ->sortable()
                ->searchable(),

            Column::make('Kode pegawai', 'kode_pegawai')
                ->sortable()
                ->searchable(),

            Column::make('Jenis', 'jenis')
                ->sortable()
                ->searchable(),

            Column::make('Jam masuk', 'jam_masuk'),

            Column::make('Longitude', 'longitude')
                ->sortable()
                ->searchable(),

            Column::make('Latitude', 'latitude')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
            Filter::select('kode_pegawai', 'kode_pegawai')
                ->dataSource($this->pegawai)
                ->optionLabel('full_name')
                ->optionValue('kode_pegawai'),
        ];
    }
}
