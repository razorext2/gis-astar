<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return view('dashboard.driver.index');
    }

    public function show($id)
    {
        $data = Driver::find($id);
        $user = \App\Models\User::select('id', 'name')->where('id', $data->validate_by)->first();

        return view('dashboard.driver.detail', (['data' => $data, 'user' => $user]));
    }

    public function create(): View
    {
        return view('dashboard.driver.add');
    }

    public function edit($id)
    {
        $data = Driver::with('pegawai')->find($id);

        return view('dashboard.driver.edit', (['data' => $data]));
    }
}
