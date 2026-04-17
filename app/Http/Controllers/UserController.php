<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:users-list', ['only' => 'index']);
        $this->middleware('permission:users-create', ['only' => 'create']);
        $this->middleware('permission:users-edit', ['only' => 'edit']);
        $this->middleware('permission:users-delete', ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
        return view('dashboard.user-manage.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('dashboard.user-manage.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->validated();

        if ($request->is_active == 0) {
            $input['deactivation_at'] = now();
            
            // Hapus session jika user dinonaktifkan
            DB::table('sessions')->where('user_id', $user->id)->delete();
        } else {
            $input['deactivation_reason'] = null;
            $input['deactivation_at'] = null;
        }

        if (! empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user->update($input);

        // Sync roles menggunakan spatie method (lebih bersih)
        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')
            ->with('status', 'Berhasil mengubah data user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = User::where('id', $id)->first();

        $user->update([
            'deleted_by' => $request->user()->id,
            'deleted_at' => now(),
        ]);

        $user->delete();

        return redirect()->route('users.index')
            ->with('status', 'Berhasil menghapus data user');
    }
}
