<?php
/** Goal: Display national holidays management page. Caller: Routes, Deps: Holiday model */

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:holiday-list');
    }

    public function index()
    {
        return view('dashboard.system.holiday');
    }
}
