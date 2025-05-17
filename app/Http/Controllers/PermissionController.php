<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions-list', ['only' => 'index']);
        $this->middleware('permission:permissions-create', ['only' => 'create']);
        $this->middleware('permission:permissions-edit', ['only' => 'edit']);
    }

    public function index()
    {
        return view('dashboard.user-manage.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user-manage.permissions.add');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.user-manage.permissions.edit', ['id' => $id]);
    }
}
