<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        // Base validation
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'jabatan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ];

        // If user intends to change password, require current password and confirmation
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($rules);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->jabatan = $request->input('jabatan');
        $user->phone = $request->input('phone');
        $user->alamat = $request->input('alamat');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->hasFile('profile')) {
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
            $user->profile = $request->file('profile')->store('users', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'accountActivation' => 'accepted',
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile) {
            Storage::disk('public')->delete($user->profile);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
