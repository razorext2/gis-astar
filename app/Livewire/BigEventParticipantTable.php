<?php

namespace App\Livewire;

use App\Models\BigEventParticipant;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class BigEventParticipantTable extends PowerGridComponent
{
    public string $tableName = 'BigEventParticipantTable';
    public bool $deferLoading = true;
    public bool $showFilters = false;
    public ?string $id;
    protected int $rowNumber = 0;

    public function setUp(): array
    {
        return [
            PowerGrid::header(),
            PowerGrid::responsive(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return BigEventParticipant::query()
            ->where('big_event_id', $this->id)
            ->orderBy('created_at', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id_formatted', fn() => $this->nextRowNumber())
            ->add('big_event_id')
            ->add('user_id')
            ->add('user_id_formatted', fn($query) => $query->userId->name)
            ->add('visitor_api')
            ->add('redirect_to')
            ->add('counter_formatted', function ($query) {
                $count = $query->bigEventVisitor()->count();

                return $count . ' Orang';
            })
            ->add('created_at');
    }

    protected function nextRowNumber(): int
    {
        return ++$this->rowNumber;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id_formatted')
                ->sortable()
                ->searchable(),

            Column::make('Nama Partisipan', 'user_id_formatted'),
            Column::make('Jlh Visitor', 'counter_formatted'),
            Column::make('Visitor API', 'visitor_api')
                ->sortable()
                ->searchable(),

            Column::make('Redirect', 'redirect_to')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('user_id_formatted', 'user_id')
                ->placeholder('Cari partisipan'),
        ];
    }

    public function actions(BigEventParticipant $row)
    {
        return [
            Button::make('detail')
                ->slot('Detail')
                ->id($row->id)
                ->class('dark:bg-green-800 text-sm dark:hover:bg-green-900 dark:text-white dark:border-gray-700 rounded-lg bg-green-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-green-700')
                ->route('event.participant.show', ['event' => $row->bigEventId->id, 'participant' => $row->id]),
            Button::make('delete')
                ->slot('Hapus')
                ->id($row->id)
                ->class('dark:bg-red-800 text-sm dark:hover:bg-red-900 dark:text-white dark:border-gray-700 rounded-lg bg-red-400 px-2 py-1.5 font-semibold text-white border border-gray-200 hover:bg-red-700')
                ->dispatch('participantDelete', ['id' => $row->id])
        ];
    }

    #[On('participantDelete')]
    public function participantDelete($id)
    {
        $participant = BigEventParticipant::findOrFail($id);

        $participant->delete();

        $this->refresh();
    }
}
