<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\BeritaImage;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $beritasQuery = Berita::with(['kategori', 'images'])
            ->orderBy('created_at', 'desc');

        if ($q) {
            $beritasQuery->where(function($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhere('deskripsi', 'like', "%{$q}%")
                      ->orWhere('konten', 'like', "%{$q}%");
            });
        }

        $beritas = $beritasQuery->paginate(10)->appends(['q' => $q]);

        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = KategoriBerita::all();
        return view('admin.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create slug from judul
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists and make it unique
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

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
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('berita', $imageName, 'public');

                BeritaImage::create([
                    'berita_id' => $berita->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $berita = Berita::with('images')->findOrFail($id);
        $kategoris = KategoriBerita::all();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_berita,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'konten' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update slug if judul changed
        $slug = $berita->slug;
        if ($berita->judul !== $request->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;

            while (Berita::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        // Update berita
        $berita->update([
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->konten,
        ]);

        // Handle delete existing images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = BeritaImage::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('berita', $imageName, 'public');

                BeritaImage::create([
                    'berita_id' => $berita->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Delete all images
        foreach ($berita->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    // Upload image from CKEditor
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                $image = $request->file('upload');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('ckeditor', $imageName, 'public');
                $url = asset('storage/' . $path);

                // CKEditor 4 memerlukan format ini
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', 'Image uploaded successfully');</script>";

                return response($response);
            } catch (\Exception $e) {
                $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', 'Upload failed: " . $e->getMessage() . "');</script>";
                return response($response);
            }
        }

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '', 'No file uploaded');</script>";
        return response($response);
    }
}
