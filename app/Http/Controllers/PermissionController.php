<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions-list', ['index']);
        $this->middleware('permission:permissions-create', ['create']);
        $this->middleware('permission:permissions-edit', ['edit']);
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
