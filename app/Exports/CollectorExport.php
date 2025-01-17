<?php

namespace App\Exports;

use App\Models\Collector;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollectorExport implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $collectors = Collector::query()
            ->with('collectTaskRelasi')
            ->whereDate('assign_date', $this->date)
            ->all();

        return view('report.collector', [
            'items' => $collectors,
            'date' => Carbon::parse($this->date)->locale('id_ID')->isoFormat('dddd, D MMMM Y'),
        ]);
    }
}
