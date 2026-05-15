<?php

namespace App\Http\Controllers\LeaveRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageLeavesController extends Controller
{
    public function index()
    {
        return view('dashboard.leave-request.manage');
    }
}
