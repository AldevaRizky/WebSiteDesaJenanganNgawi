<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BaganImage;

class BaganController extends Controller
{
    /**
     * Show the single bagan (if exists) and controls to upload/update.
     */
    public function index()
    {
        // only one bagan allowed — fetch the most recent or null
        $bagan = BaganImage::orderBy('created_at', 'desc')->first();
        return view('admin.perangkat.bagan', compact('bagan'));
    }

    /**
     * Store a new bagan. If one exists, replace it.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            'nama' => 'nullable|string|max:255',
        ]);

        // delete existing bagan(s) to enforce single-photo rule
        $existing = BaganImage::all();
        foreach ($existing as $ex) {
            if ($ex->gambar) Storage::delete($ex->gambar);
            $ex->delete();
        }

        $path = $request->file('gambar')->store('public/bagan');

        BaganImage::create([
            'gambar' => $path,
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.perangkat.bagan')->with('success', 'Bagan berhasil diunggah!');
    }

    /**
     * Update existing bagan (replace image or update caption)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:204800',
            'nama' => 'nullable|string|max:255',
        ]);

        $bagan = BaganImage::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($bagan->gambar) Storage::delete($bagan->gambar);
            $bagan->gambar = $request->file('gambar')->store('public/bagan');
        }

        $bagan->nama = $request->nama;
        $bagan->save();

        return redirect()->route('admin.perangkat.bagan')->with('success', 'Bagan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bagan = BaganImage::findOrFail($id);
        if ($bagan->gambar) Storage::delete($bagan->gambar);
        $bagan->delete();
        return redirect()->route('admin.perangkat.bagan')->with('success', 'Bagan berhasil dihapus!');
    }
}
