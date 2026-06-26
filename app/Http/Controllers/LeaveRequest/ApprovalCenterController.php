<?php

namespace App\Http\Controllers\LeaveRequest;

/** Goal: Handle approval center routing with policy enforcement, Caller: routes/features/leave-request.php, Deps: LeaveRequest, LeaveRequestPolicy */

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest\LeaveRequest;

class ApprovalCenterController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', LeaveRequest::class);

        return view('dashboard.leave-request.approval-center.index');
    }

    public function show($id)
    {
        $request = LeaveRequest::with([
            'user.pegawai.jabatanRelasi.supervisors',
            'user.pegawai.jabatanRelasi.placementRelasi.hrds',
            'user.pegawai.jabatanRelasi.placementRelasi.managements',
        ])->findOrFail($id);

        $this->authorize('view', $request);

        return view('dashboard.leave-request.approval-center.show', compact('id'));
    }
}
