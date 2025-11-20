<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pegawai;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $data = Pegawai::with('jabatanRelasi', 'golonganRelasi')
            ->where('kode_pegawai', Auth::user()->kode_pegawai)
            ->first();

        return view('dashboard.profile.me', compact('data'));
    }

    public function edit(Request $request): View
    {
        return view('dashboard.profile.edit', [
            'user' => $request->user(),
            'data' => $request->user()->pegawai,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'nick_name' => ['required', 'string', 'max:255'],
            'nik_pegawai' => ['required', 'string', 'max:255'],
            'no_telp' => ['required', 'string', 'max:255'],
            'tgl_lahir' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Redirect::route('profile.edit')->with('status', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            // update data pegawai
            if ($request->user()->kode_pegawai) {
                Pegawai::where('kode_pegawai', $request->user()->kode_pegawai)->update([
                    'full_name' => $request->name,
                    'nick_name' => $request->nick_name,
                    'nik_pegawai' => $request->nik_pegawai,
                    'no_telp' => $request->no_telp,
                    'tgl_lahir' => $request->tgl_lahir,
                    'gender' => $request->gender,
                    'alamat' => $request->alamat,
                ]);
            }

            // update data user
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            \App\Models\User::where('id', $request->user()->id)->update([
                'name' => $request->name,
            ]);

            DB::commit();

            return Redirect::route('profile.edit')->with('status', 'Data profil berhasil diperbaharui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::route('profile.edit')->with('status', $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $user->update([
            'deleted_by' => $user->id,
            'deleted_at' => now(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
