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
}
