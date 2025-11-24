<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'jabatan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $data = $request->only(['name','email','jabatan','phone','alamat']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')->store('users','public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'jabatan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            if ($user->profile) Storage::disk('public')->delete($user->profile);
            $user->profile = $request->file('profile')->store('users','public');
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile) Storage::disk('public')->delete($user->profile);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
