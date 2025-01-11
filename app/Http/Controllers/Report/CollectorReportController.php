<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Exports\CollectorExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectorReportController extends Controller
{

    public function export(Request $request)
    {
        $date = $request->get('date');
        $fileName = Str::random(8) . '-laporanKolektor-' . $date . '.xlsx';

        (new CollectorExport($date))
            ->queue('public/export/' . $fileName)
            ->chain([
                new NotifyUserOfCompletedExport(request()->user(), $fileName)
            ]);

        return back()->with('status', 'Export Started!');
    }
}
