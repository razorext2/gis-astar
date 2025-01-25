<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pegawai;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Yajra\DataTables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:users-list', ['only' => ['index']]);
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Parse the minDate and maxDate from the request after cleaning
            $minDate = $request->input('minDate');
            $maxDate = $request->input('maxDate');

            // Start building the query
            $query = User::get();

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
                    $editUrl = route('users.edit', $data->id);

                    // Inisialisasi variabel untuk tombol aksi
                    $actionButtons = '
                <div class="inline-flex rounded-md shadow-sm" role="group">';

                    // Cek izin edit
                    if (auth()->user()->can('users-edit')) {
                        $actionButtons .= '
                        <a href="' . $editUrl . '"class="mx-1 text-md font-medium rounded-lg focus:z-10">
                            &#9999; <span class="hover:underline" style="color: #057A55"> Edit </span>
                        </a>';
                    }

                    if (auth()->user()->can('users-delete')) {

                        // if ($data->kode_pegawai != null) {
                        //     $id = $data->kode_pegawai;
                        // } else {
                        $id = $data->id;
                        // }
                        // Tambahkan tombol delete
                        $actionButtons .= '
                        <button class="mx-1 group text-md font-medium rounded-lg focus:z-10 delete-btn"
                            data-id="' . $data->id . '" data-modal-target="deleteModal" data-modal-toggle="deleteModal">
                            &#x26D4; <span class="hover:underline" style="color: #E02424;"> Delete </span>
                        </button>';
                    }
                    '</div>';

                    return $actionButtons;
                })
                ->editColumn('name_roles', function ($row) {
                    if (!empty($row->getRoleNames()))
                        foreach ($row->getRoleNames() as $v) {
                            return $row->name . ' <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">' . $v . '</span>';
                        }
                })
                ->editColumn('created_updated_at', function ($row) {
                    return $row->created_at . ' / ' . $row->updated_at;
                })
                ->editColumn('remember_token', function ($row) {
                    return $row->remember_token ?? 'N/A';
                })
                ->addIndexColumn() // This is the DT_RowIndex
                ->rawColumns(['name_roles', 'action'])
                ->make(true);
        } else {
            return view('dashboard.user-manage.users.index');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::pluck('name', 'name')->all();

        return view('dashboard.user-manage.users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('status', 'Berhasil menambah data user');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.user-manage.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('status', 'Berhasil mengubah data user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {

        $user = User::where('id', $id)->first();
        $user->delete();

        return redirect()->route('users.index')
            ->with('status', 'Berhasil menghapus data user');
    }
}
