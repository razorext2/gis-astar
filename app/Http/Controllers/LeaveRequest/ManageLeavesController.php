<?php

namespace App\Http\Controllers\LeaveRequest;

/** Goal: Handle manage leaves routing with policy enforcement, Caller: routes/features/leave-request.php, Deps: LeaveRequest, LeaveRequestPolicy */

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest\LeaveRequest;

class ManageLeavesController extends Controller
{
    public function index()
    {
        $this->authorize('manage', LeaveRequest::class);

        return view('dashboard.leave-request.manage');
    }
}
