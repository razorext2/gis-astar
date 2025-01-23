<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectResource;
use App\Jobs\ExportToExcelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CollectorReportController extends Controller
{

    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'reportStatus' => 'required',
        ]);

        if ($validator->fails()) {
            return new CollectResource(false, 'Validasi gagal', $validator->errors()->first());
        }

        $rand = Str::random(8);

        $date = $request->input("date");
        $status = $request->input("status");

        $fileName = "$rand-laporanKolektor-$date.xlsx";
        $userId = request()->user()->id;

        try {
            ExportToExcelJob::dispatch($date, $status, $fileName, $userId)->delay(now()->addSeconds(5));

            return new CollectResource(true, 'Data berhasil di export', 'Proses export sedang berjalan');
        } catch (\Exception $e) {
            Log::error('Export failed for user: ' . $userId . ' - Error: ' . $e->getMessage());
        }
    }
}
