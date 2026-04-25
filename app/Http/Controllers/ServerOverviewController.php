<?php

namespace App\Http\Controllers;

class ServerOverviewController extends Controller
{
    public function index()
    {
        return view('dashboard.system.server-overview');
    }
}
