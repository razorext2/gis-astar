<?php

/** Goal: Handle user profile view, update, and deactivation, Caller: routes/web.php, Deps: ProfileUpdateRequest, User */

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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
        return view('dashboard.profile.me');
    }

    public function edit(Request $request): View
    {
        return view('dashboard.profile.edit', [
            'user' => $request->user(),
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

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::route('profile.edit')->with('status', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $user = $request->user();

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            User::where('id', $user->id)->update([
                'name' => $request->name,
                'email' => $request->email,
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

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
