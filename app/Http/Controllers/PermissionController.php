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
        $this->middleware('permission:permissions-delete', ['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Parse the minDate and maxDate from the request after cleaning
            $minDate = $request->input('minDate');
            $maxDate = $request->input('maxDate');

            // Start building the query
            $query = Permission::get();

            // Apply date filtering if minDate and maxDate are provided
            if ($minDate) {
                $query = $query->where('created_at', '>=', Carbon::parse($minDate)->startOfDay());
            }
            if ($maxDate) {
                $query = $query->where('created_at', '<=', Carbon::parse($maxDate)->endOfDay());
            }

            // Fetch the filtered data with pagination for DataTables
            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    $editUrl = route('permissions.edit', $data->id);

                    // Inisialisasi variabel untuk tombol aksi
                    $actionButtons = '<div class="inline-flex rounded-md shadow-sm" role="group">';

                    // Cek izin edit
                    if (auth()->user()->can('permissions-edit')) {
                        $actionButtons .= '
                        <a href="' . $editUrl . '"class="mx-1 text-md font-medium rounded-lg focus:z-10">
                            &#9999; <span class="hover:underline" style="color: #057A55"> Edit </span>
                        </a>';
                    }

                    if (auth()->user()->can('permissions-delete')) {
                        // Tambahkan tombol delete
                        $actionButtons .= '
                        <button class="mx-1 group text-md font-medium rounded-lg focus:z-10 delete-btn" data-id="' . $data->id . '" data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                            &#x26D4; <span class="hover:underline" style="color: #E02424;"> Delete </span>
                        </button>';
                    }

                    '</div>';

                    return $actionButtons;
                })
                ->editColumn('created_updated_at', function ($data) {
                    return $data->created_at . ' / ' . $data->updated_at;
                })
                ->addIndexColumn() // This is the DT_RowIndex
                ->rawColumns(['action', 'created_updated_at'])
                ->make(true);
        } else {
            return view('dashboard.user-manage.permissions.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user-manage.permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',        // Harus berupa array
            'name.*' => 'required|string|max:255',  // Setiap elemen array harus string
        ]);

        foreach ($request->name as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }



        return redirect()->route('permissions.index')->with('status', 'Berhasil menambah data role');;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);
        return view('dashboard.user-manage.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('status', 'Berhasil mengubah data permission');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table("permissions")->where('id', $id)->delete();
        return redirect()->route('permissions.index')
            ->with('status', 'Berhasil menghapus data permission');
    }
}
