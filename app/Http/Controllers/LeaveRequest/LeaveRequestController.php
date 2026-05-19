<?php

namespace App\Http\Controllers\LeaveRequest;

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

    public function edit()
    {
        return view('dashboard.leave-request.edit');
    }

    public function show()
    {
        return view('dashboard.leave-request.show');
    }

    public function borrow()
    {
        return view('dashboard.leave-request.borrow');
    }

    public function streamPdf(\App\Models\LeaveRequest\LeaveRequest $request)
    {
        $request->load([
            'user.pegawai.jabatanRelasi.divisionRelasi',
            'user.pegawai.jabatanRelasi.placementRelasi',
            'user.pegawai.jabatanRelasi.supervisor',
            'leaveType',
            'backupPerson',
            'histories.actedByUser'
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf.leave-request', [
            'data' => $request,
        ])->setPaper([0, 0, 612, 936], 'portrait');

        return $pdf->stream('leave-request-' . $request->id . '.pdf');
    }
}
