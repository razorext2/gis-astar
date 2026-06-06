<?php

/** Goal: Handle user profile view, update, and deactivation, Caller: routes/web.php, Deps: ProfileUpdateRequest, Pegawai, PegawaiChangesHistory, User */

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pegawai;
use App\Models\PegawaiChangesHistory;
use App\Models\User;
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
        ];

        if ($request->user()->kode_pegawai) {
            $rules = array_merge($rules, [
                'nick_name' => ['required', 'string', 'max:255'],
                'nik_pegawai' => ['required', 'string', 'max:255'],
                'no_telp' => ['required', 'string', 'max:255'],
                'tgl_lahir' => ['required', 'date'],
                'gender' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:255'],
            ]);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::route('profile.edit')->with('status', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $user = $request->user();
            $pegawai = $user->pegawai;

            if ($pegawai) {
                $alasanLog = 'Pembaruan data profil oleh user';

                if ($pegawai->full_name != $request->name) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'full_name',
                        'old_value' => $pegawai->full_name,
                        'new_value' => $request->name,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                if ($pegawai->nick_name != $request->nick_name) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'nick_name',
                        'old_value' => $pegawai->nick_name,
                        'new_value' => $request->nick_name,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                if ($pegawai->nik_pegawai != $request->nik_pegawai) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'nik_pegawai',
                        'old_value' => $pegawai->nik_pegawai,
                        'new_value' => $request->nik_pegawai,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                if ($pegawai->no_telp != $request->no_telp) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'no_telp',
                        'old_value' => $pegawai->no_telp,
                        'new_value' => $request->no_telp,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                $oldTgl = $pegawai->tgl_lahir ? (is_string($pegawai->tgl_lahir) ? $pegawai->tgl_lahir : $pegawai->tgl_lahir->format('Y-m-d')) : null;
                $newTgl = $request->tgl_lahir;
                if ($oldTgl != $newTgl) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'tgl_lahir',
                        'old_value' => $oldTgl,
                        'new_value' => $newTgl,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                if ($pegawai->gender != $request->gender) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'gender',
                        'old_value' => $pegawai->gender,
                        'new_value' => $request->gender,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }

                if ($pegawai->alamat != $request->alamat) {
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $pegawai->id,
                        'field_name' => 'alamat',
                        'old_value' => $pegawai->alamat,
                        'new_value' => $request->alamat,
                        'alasan' => $alasanLog,
                        'changed_by' => $user->id,
                    ]);
                }
            }

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
            'deactivation_reason' => 'Akun dihapus oleh user pada '.now()->toDateTimeString().'. Hubungi admin untuk mengaktifkan.',
            'deleted_by' => $user->id,
            'deactivation_at' => now(),
            'deleted_at' => now(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
