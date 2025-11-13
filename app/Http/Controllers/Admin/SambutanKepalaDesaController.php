<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SambutanKepalaDesa;
use Illuminate\Support\Facades\Storage;

class SambutanKepalaDesaController extends Controller
{
    public function index()
    {
        // Ambil data sambutan kepala desa (hanya satu data)
        $sambutan = SambutanKepalaDesa::first();

        return view('admin.sambutan_kepala_desa.index', compact('sambutan'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'deskripsi' => 'required|string',
        ]);

        // Cek apakah data sudah ada
        if (SambutanKepalaDesa::count() > 0) {
            return redirect()->route('admin.sambutan_kepala_desa.index')->withErrors('Data Sambutan kepala desa sudah tersedia. Anda hanya dapat mengedit data.');
        }

        // Simpan file gambar
        $gambarPath = $request->file('gambar')->store('public/sambutan_kepala_desa');

        // Buat data baru
        SambutanKepalaDesa::create([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $gambarPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.sambutan_kepala_desa.index')->with('success', 'Sambutan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            'deskripsi' => 'required|string',
        ]);

        $sambutan = SambutanKepalaDesa::findOrFail($id);

        // Update file gambar jika ada
        if ($request->hasFile('gambar')) {
            Storage::delete($sambutan->gambar);
            $sambutan->gambar = $request->file('gambar')->store('public/sambutan_kepala_desa');
        }

        // Update data lainnya
        $sambutan->update([
            'judul' => $request->judul,
            'subjudul' => $request->subjudul,
            'gambar' => $sambutan->gambar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.sambutan_kepala_desa.index')->with('success', 'Sambutan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sambutan = SambutanKepalaDesa::findOrFail($id);
        Storage::delete($sambutan->gambar);
        $sambutan->delete();

        return redirect()->route('admin.sambutan_kepala_desa.index')->with('success', 'Sambutan berhasil dihapus!');
    }
}
