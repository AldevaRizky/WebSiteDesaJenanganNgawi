<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\BeritaImage;
use App\Models\KategoriBerita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('kategori','images')->orderByDesc('created_at')->get();
        $kategoris = KategoriBerita::orderBy('nama')->get();
        return view('admin.berita.index', compact('beritas','kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $slug = Str::slug($request->judul);
        $count = Berita::where('slug','like',"$slug%")->count();
        if ($count) $slug .= '-'.($count+1);

        $berita = Berita::create([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('public/berita');
                BeritaImage::create(['berita_id' => $berita->id, 'path' => $path]);
            }
        }

        return redirect()->route('admin.beritas.index')->with('success','Berita berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $berita = Berita::findOrFail($id);

        $berita->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('public/berita');
                BeritaImage::create(['berita_id' => $berita->id, 'path' => $path]);
            }
        }

        return redirect()->route('admin.beritas.index')->with('success','Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        // delete images files
        foreach ($berita->images as $img) {
            Storage::delete($img->path);
        }
        $berita->delete();

        return redirect()->route('admin.beritas.index')->with('success','Berita berhasil dihapus');
    }
}
