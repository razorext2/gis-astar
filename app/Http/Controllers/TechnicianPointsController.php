<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicianPointsController extends Controller
{
    public function index()
    {
        return view('dashboard.technicianpoints.index');
    }

    public function redeem()
    {
        return view('dashboard.technicianpoints.redeem');
    }
}
