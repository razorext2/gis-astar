<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:roles-list', ['index']);
        $this->middleware('permission:roles-create', ['create']);
        $this->middleware('permission:roles-edit', ['edit']);
        $this->middleware('permission:roles-delete', ['destroy']);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $query = Role::find($id);

        if (!$query) {
            return abort(404);
        }

        $query->delete();

        return redirect()->route('roles.index')
            ->with('status', 'Berhasil menghapus data role');
    }
}
