<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VisiMisi;

class VisiMisiController extends Controller
{
    public function index()
    {
        // Ambil data visi dan misi (hanya satu data)
        $visiMisi = VisiMisi::first();

        return view('admin.visi_misi.index', compact('visiMisi'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'visi' => 'required|string|max:255',
            'misi' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        // Cek apakah data sudah ada
        if (VisiMisi::count() > 0) {
            return redirect()->route('admin.visi_misi.index')->withErrors('Data visi dan misi sudah ada. Anda hanya dapat mengedit data.');
        }

        // Buat data baru
        VisiMisi::create($request->only(['visi', 'misi', 'tujuan']));

        return redirect()->route('admin.visi_misi.index')->with('success', 'Data visi dan misi berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'visi' => 'required|string|max:255',
            'misi' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        $visiMisi = VisiMisi::findOrFail($id);

        // Update data
        $visiMisi->update($request->only(['visi', 'misi', 'tujuan']));

        return redirect()->route('admin.visi_misi.index')->with('success', 'Data visi dan misi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $visiMisi = VisiMisi::findOrFail($id);
        $visiMisi->delete();

        return redirect()->route('admin.visi_misi.index')->with('success', 'Data visi dan misi berhasil dihapus!');
    }
}
