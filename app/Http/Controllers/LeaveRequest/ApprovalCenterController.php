<?php

namespace App\Http\Controllers\LeaveRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovalCenterController extends Controller
{
    public function index()
    {
        return view('dashboard.leave-request.approval-center.index');
    }

    public function show($id)
    {
        return view('dashboard.leave-request.approval-center.show', compact('id'));
    }
}
