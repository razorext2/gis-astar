<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Contracts\View\View;

class DriverController extends Controller
{
    public function index()
    {
        return view('dashboard.driver.index');
    }

    public function show($id)
    {
        $data = Driver::with(['validateBy', 'pegawai'])->find($id);

        if (!$data) {
            return abort(404);
        }

        return view('dashboard.driver.detail', (['data' => $data]));
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

    public function assignAddView()
    {
        if (!auth()->user()->can('driver-approve')) {
            abort(403);
        }

        return view('dashboard.driver.assign-add');
    }

    public function assignToView($id)
    {
        if (!auth()->user()->can('driver-approve')) {
            abort(403);
        }

        return view('dashboard.driver.assign-to', ['id' => $id]);
    }

    public function assignUpdate($id)
    {
        $data = Driver::find($id);

        return view('dashboard.driver.assign-update', ['data' => $data]);
    }
}
