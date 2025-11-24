<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $query = KategoriBerita::orderBy('nama');
        if ($q) {
            $query->where('nama', 'like', "%{$q}%");
        }

        $kategoris = $query->paginate(10)->appends(['q' => $q]);
        return view('admin.kategori_berita.index', compact('kategoris'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
        ]);

        $slug = Str::slug($request->nama);
        // ensure unique
        $count = KategoriBerita::where('slug', 'like', "$slug%")->count();
        if ($count) $slug .= '-' . ($count + 1);

        KategoriBerita::create(['nama' => $request->nama, 'slug' => $slug]);

        return redirect()->route('admin.kategori_berita.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
        ]);

        $kategori = KategoriBerita::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->slug = Str::slug($request->nama);
        $kategori->save();

        return redirect()->route('admin.kategori_berita.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori_berita.index')->with('success', 'Kategori berhasil dihapus');
    }
}
