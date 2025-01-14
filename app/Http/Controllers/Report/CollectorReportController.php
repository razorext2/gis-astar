<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Jobs\ExportToExcelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CollectorReportController extends Controller
{

    public function export(Request $request)
    {
        $rand = Str::random(8);
        $date = $request->get('date');
        $fileName = "$rand-laporanKolektor-$date.xlsx";
        $userId = request()->user()->id;

        try {
            ExportToExcelJob::dispatch($date, $fileName, $userId)->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            Log::error('Export failed for user: ' . $userId . ' - Error: ' . $e->getMessage());
        }
    }
}
