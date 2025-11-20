<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        $perangkats = PerangkatDesa::with('parent')->orderBy('order')->paginate(15);
        $all = PerangkatDesa::orderBy('order')->get();
        return view('admin.perangkat.index', compact('perangkats', 'all'));
    }

    public function create()
    {
        $parents = PerangkatDesa::orderBy('order')->get();
        return view('admin.perangkat.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:191',
            'jabatan' => 'nullable|string|max:191',
            'deskripsi' => 'nullable|string',
            'parent_id' => 'nullable|exists:perangkat_desas,id',
            'order' => 'nullable|integer',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('perangkat', 'public');
        }

        PerangkatDesa::create($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function edit(PerangkatDesa $perangkat)
    {
        $parents = PerangkatDesa::where('id', '!=', $perangkat->id)->orderBy('order')->get();
        return view('admin.perangkat.edit', compact('perangkat', 'parents'));
    }

    public function update(Request $request, PerangkatDesa $perangkat)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:191',
            'jabatan' => 'nullable|string|max:191',
            'deskripsi' => 'nullable|string',
            'parent_id' => 'nullable|exists:perangkat_desas,id',
            'order' => 'nullable|integer',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:191',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // delete old if exists
            if ($perangkat->gambar && \Storage::disk('public')->exists($perangkat->gambar)) {
                \Storage::disk('public')->delete($perangkat->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('perangkat', 'public');
        }

        // If user marked existing image for deletion (no new upload)
        if ($request->input('delete_image')) {
            if ($perangkat->gambar && \Storage::disk('public')->exists($perangkat->gambar)) {
                \Storage::disk('public')->delete($perangkat->gambar);
            }
            $data['gambar'] = null;
        }

        $perangkat->update($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa diperbarui.');
    }

    public function destroy(PerangkatDesa $perangkat)
    {
        // delete image
        if ($perangkat->gambar && \Storage::disk('public')->exists($perangkat->gambar)) {
            \Storage::disk('public')->delete($perangkat->gambar);
        }

        // reassign children to parent (if any)
        PerangkatDesa::where('parent_id', $perangkat->id)->update(['parent_id' => $perangkat->parent_id]);

        $perangkat->delete();

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa dihapus.');
    }

    /**
     * Display bagan (organizational chart)
     */
    public function bagan()
    {
        $roots = PerangkatDesa::with('children')->whereNull('parent_id')->orderBy('order')->get();
        return view('admin.perangkat.bagan', compact('roots'));
    }
}
