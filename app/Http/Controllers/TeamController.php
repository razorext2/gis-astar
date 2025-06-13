<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return view('dashboard.technician.teams.index');
    }

    public function create()
    {
        return view('dashboard.technician.teams.create');
    }

    public function edit($team_code)
    {
        return view('dashboard.technician.teams.edit', compact('team_code'));
    }
}
