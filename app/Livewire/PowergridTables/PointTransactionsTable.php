<?php

/** Goal: Tabel transaksi penukaran poin teknisi, Caller: routes/web.php (technicianpoints.index), Deps: PointTransactions, PowerGrid */

namespace App\Livewire\PowergridTables;

use \App\Models\PointTransactions;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PointTransactionsTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'PointTransactionsTable';
    public bool $deferLoading = true;
    public bool $showFilters = false;

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
            PowerGrid::responsive(),
            PowerGrid::exportable(now()->format('ymdhis') . '-PointTransactionsTable.xlsx')
                ->type(Exportable::TYPE_XLS)
                ->stripTags(true)
        ];
    }

    public function datasource()
    {
        // Ambil transaction_id unik
        $transactionIds = PointTransactions::query()
            ->select('transaction_id')
            ->distinct()
            ->pluck('transaction_id');

        // Ambil data pertama dari tiap transaction_id
        return $transactionIds->map(function ($id) {
            return PointTransactions::with('pegawai')
                ->where('transaction_id', $id)
                ->orderBy('id') // atau orderBy created_at
                ->first();
        });
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('transaction_id')
            ->add('year', fn($query) => $query->year . '-' . $query->quartal)
            ->add('redeemed_by', fn($query) => $query->redeemedby->name)
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::action('Action'),
            Column::make('Transaction id', 'transaction_id')
                ->sortable()
                ->searchable(),

            Column::make('Year', 'year')
                ->sortable()
                ->searchable(),

            Column::make('Redeemed by', 'redeemed_by')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at', 'created_at')
                ->sortable(),


        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('from_date'),
            Filter::datepicker('to_date'),
        ];
    }

    public function actions(PointTransactions $row): array
    {
        return [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->transaction_id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-zinc-200 hover:bg-green-700')
                ->route('technicianpoints.transactionDetail', ['transaction_id' => $row->transaction_id]),
        ];
    }
}

