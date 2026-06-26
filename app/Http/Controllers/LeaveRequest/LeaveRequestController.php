<?php

namespace App\Http\Controllers\LeaveRequest;

/** Goal: Handle routing or streaming of Leave Request PDFs, Caller: web.php, Deps: LeaveRequest, Pdf */

use App\Http\Controllers\Controller;

class LeaveRequestController extends Controller
{
    public function index()
    {
        return view('dashboard.leave-request.index');
    }

    public function create()
    {
        return view('dashboard.leave-request.create');
    }

    public function edit(\App\Models\LeaveRequest\LeaveRequest $my_request)
    {
        $this->authorize('view', $my_request);

        return view('dashboard.leave-request.edit');
    }

    public function show(\App\Models\LeaveRequest\LeaveRequest $my_request)
    {
        $this->authorize('view', $my_request);

        return view('dashboard.leave-request.show');
    }

    public function borrow()
    {
        return view('dashboard.leave-request.borrow');
    }

    public function streamPdf(\App\Models\LeaveRequest\LeaveRequest $request)
    {
        $this->authorize('view', $request);

        $request->load([
            'user.pegawai.jabatanRelasi.divisionRelasi',
            'user.pegawai.jabatanRelasi.placementRelasi',
            'user.pegawai.jabatanRelasi.supervisors',
            'user.signature',
            'leaveType',
            'backupPerson',
            'histories.actedByUser.signature',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf.leave-request', [
            'data' => $request,
        ])->setPaper([0, 0, 612, 936], 'portrait');

        $fileName = 'Form_Cuti_'.\Illuminate\Support\Str::slug($request->user->name).'_'.\Carbon\Carbon::parse($request->start_date)->format('d-m-Y').'.pdf';

        return $pdf->stream($fileName);
    }
}
