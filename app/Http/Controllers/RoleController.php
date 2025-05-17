<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:roles-list', ['only' => 'index']);
        $this->middleware('permission:roles-create', ['only' => 'create']);
        $this->middleware('permission:roles-edit', ['only' => 'edit']);
    }

    public function index()
    {
        return view('dashboard.user-manage.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user-manage.roles.add');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.user-manage.roles.edit', compact('id'));
    }
}
