<?php

namespace App\DataTables;

use App\Models\Collector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CollectorsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(Request $request): EloquentDataTable
    {
        $query = Collector::with('pegawaiRelasi');

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('actions', function (Collector $data) {
                return view('components.dashboard.action-buttons', [
                    'id' => $data->id,
                    'edit' => ['show' => true, 'url' => route('collect.edit', $data->id)],
                    'show' => ['show' => true, 'url' => route('collect.show', $data->id)],
                    'delete' => ['show' => true]
                ]);
            })
            ->editColumn('kode_pegawai', function ($data) {
                return view('components.dashboard.name-w-code', [
                    'name' => $data->pegawaiRelasi->full_name,
                    'code' => $data->kode_pegawai
                ]);
            })
            ->editColumn('title', function ($data) {
                return view('components.dashboard.title-w-status', [
                    'title' => $data->short_title,
                    'status' => $data->status
                ]);
            })
            ->editColumn('longitude', function ($data) {
                return view('components.dashboard.location-w-coordinate', [
                    'lat' => $data->latitude,
                    'long' => $data->longitude,
                    'location' => $data->location
                ]);
            })
            ->editColumn('created_at', function ($data) {
                return view('components.dashboard.custom-date', [
                    'date' => $data->created_at->locale('id')->isoFormat('D MMMM YYYY'),
                    'time' => $data->created_at->locale('id')->isoFormat('HH:mm:ss')
                ]);
            })
            ->filter(function ($data) use ($request) {
                if ($request->filled("title")) {
                    $data->where('title', "LIKE", "%$request->title%");
                }

                if ($request->filled("kode_pegawai")) {
                    $data->where('kode_pegawai', "LIKE", "%$request->kode_pegawai%");
                }

                if ($request->filled("status")) {
                    $data->where('status', "LIKE", "%$request->status%");
                }

                if ($request->filled("startDate")) {
                    $data->whereBetween('created_at', [$request->startDate, $request->endDate]);
                }
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Collector $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('collectors-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->width(30)
                ->title('No')
                ->addClass('text-center items-center dark:text-white'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(60),
            Column::make('kode_pegawai'),
            Column::make('title'),
            Column::make('longitude'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Collectors_' . date('YmdHis');
    }
}
