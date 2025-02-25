<?php

namespace App\Livewire;

use Livewire\Component;

class TableRefresher extends Component
{
    public string $tableName;

    public function refreshTable()
    {
        $this->dispatch("pg:eventRefresh-$this->tableName");
    }

    public function render()
    {
        return view('livewire.table-refresher', ['tableName' => $this->tableName]);
    }
}
