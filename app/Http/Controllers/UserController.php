<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function create()
    {
        return view('dashboard.user-manage.users.add');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user-manage.users.edit', compact('user'));
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
