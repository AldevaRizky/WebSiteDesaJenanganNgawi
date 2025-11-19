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
        $beritas = Berita::with(['kategori', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $kategoris = KategoriBerita::orderBy('nama')->get();
        
        return view('admin.berita.index', compact('beritas', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique slug
        $slug = Str::slug($request->judul);
        $count = Berita::where('slug', 'like', "$slug%")->count();
        if ($count) $slug .= '-' . ($count + 1);

        // Create berita
        $berita = Berita::create([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
        ]);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('berita', 'public');
                BeritaImage::create([
                    'berita_id' => $berita->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $berita = Berita::findOrFail($id);

        // Update slug only if title changed
        if ($berita->judul !== $request->judul) {
            $slug = Str::slug($request->judul);
            $count = Berita::where('slug', 'like', "$slug%")
                ->where('id', '!=', $id)
                ->count();
            if ($count) $slug .= '-' . ($count + 1);
            $berita->slug = $slug;
        }

        $berita->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
        ]);

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('berita', 'public');
                BeritaImage::create([
                    'berita_id' => $berita->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Delete all images from storage
        foreach ($berita->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus');
    }

    public function deleteImage($id)
    {
        $image = BeritaImage::findOrFail($id);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}