<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::paginate(10); // Adjust pagination as needed
        return view('admin.logos.index', compact('logos'));
    }

    public function store(Request $request)
    {
        // Check if the maximum limit of 3 logos is reached
        if (Logo::count() >= 3) {
            return redirect()->route('admin.logos.index')->with('error', 'Gagal menambahkan: Maksimum 3 logo diperbolehkan.');
        }

        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $logoPath = $request->file('logo')->store('public/logos');

        Logo::create(['logo' => $logoPath]);

    return redirect()->route('admin.logos.index')->with('success', 'Logo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $logo = Logo::findOrFail($id);

        if ($request->hasFile('logo')) {
            Storage::delete($logo->logo);
            $logo->logo = $request->file('logo')->store('public/logos');
        }

        $logo->save();

    return redirect()->route('admin.logos.index')->with('success', 'Logo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $logo = Logo::findOrFail($id);
        Storage::delete($logo->logo);
        $logo->delete();

    return redirect()->route('admin.logos.index')->with('success', 'Logo deleted successfully!');
    }
}
