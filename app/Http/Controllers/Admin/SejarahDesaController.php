<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SejarahDesa;
use Illuminate\Support\Facades\Storage;

class SejarahDesaController extends Controller
{
    public function index()
    {
        $sejarah = SejarahDesa::first();

        return view('admin.sejarah_desa.index', compact('sejarah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'deskripsi' => 'required|string',
        ]);

        if (SejarahDesa::count() > 0) {
            return redirect()->route('admin.sejarah_desa.index')->withErrors('Sejarah desa sudah ada. Anda hanya dapat mengedit data.');
        }

        $gambarPath = $request->file('gambar')->store('public/sejarah_desa');

        SejarahDesa::create([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.sejarah_desa.index')->with('success', 'Sejarah desa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'deskripsi' => 'required|string',
        ]);

        $sejarah = SejarahDesa::findOrFail($id);

        if ($request->hasFile('gambar')) {
            Storage::delete($sejarah->gambar);
            $sejarah->gambar = $request->file('gambar')->store('public/sejarah_desa');
        }

        $sejarah->update([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $sejarah->gambar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.sejarah_desa.index')->with('success', 'Sejarah desa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sejarah = SejarahDesa::findOrFail($id);
        Storage::delete($sejarah->gambar);
        $sejarah->delete();

        return redirect()->route('admin.sejarah_desa.index')->with('success', 'Sejarah desa berhasil dihapus!');
    }
}
