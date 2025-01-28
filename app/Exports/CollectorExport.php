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
    protected $status;
    protected $type;

    public function __construct($date, $status, $type)
    {
        $this->date = $date;
        $this->status = $status;
        $this->type = $type;
    }

    public function view(): View
    {
        $collectors = Collector::query()
            ->with('collectTaskRelasi')
            ->whereDate('assign_date', $this->date)
            ->where('status', $this->status)
            ->where('bill_type', $this->type)
            ->get();

        return view('report.collector', [
            'type' => $this->type,
            'items' => $collectors,
            'date' => Carbon::parse($this->date)->locale('id_ID')->isoFormat('dddd, D MMMM Y'),
        ]);
    }
}
