<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\UmkmImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::with('images')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.umkm.index', compact('umkms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:umkms,nama',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'link_maps' => 'nullable|url',
            'link_wa' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $umkm = Umkm::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'link_maps' => $request->link_maps,
            'link_wa' => $request->link_wa,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('umkm', $imageName, 'public');

                UmkmImage::create([
                    'umkm_id' => $umkm->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::with('images')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:umkms,nama,' . $id,
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'link_maps' => 'nullable|url',
            'link_wa' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $umkm->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'alamat' => $request->alamat,
            'link_maps' => $request->link_maps,
            'link_wa' => $request->link_wa,
        ]);

        // delete selected existing images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $image = UmkmImage::find($imgId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('umkm', $imageName, 'public');

                UmkmImage::create([
                    'umkm_id' => $umkm->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $umkm = Umkm::with('images')->findOrFail($id);

        foreach ($umkm->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dihapus!');
    }
}
