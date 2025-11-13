<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Footer;

class FooterController extends Controller
{
    public function index()
    {
        // Ambil data footer (hanya satu data)
        $footer = Footer::first();

        return view('admin.footer.index', compact('footer'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'lokasi' => 'nullable|string',
            'link_ig' => 'nullable|url',
            'link_fb' => 'nullable|url',
            'link_wa' => 'nullable|url',
            'link_youtube' => 'nullable|url',
        ]);

        // Cek apakah data sudah ada
        if (Footer::exists()) {
            return redirect()->route('admin.footer.index')->withErrors('Data footer sudah ada. Anda hanya dapat mengedit data.');
        }

        // Buat data baru
        Footer::create($request->only([
            'nama', 'deskripsi', 'alamat', 'telepon', 'email', 'lokasi',
            'link_ig', 'link_fb', 'link_wa', 'link_youtube',
        ]));

        return redirect()->route('admin.footer.index')->with('success', 'Data footer berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'lokasi' => 'nullable|string',
            'link_ig' => 'nullable|url',
            'link_fb' => 'nullable|url',
            'link_wa' => 'nullable|url',
            'link_youtube' => 'nullable|url',
        ]);

        $footer = Footer::findOrFail($id);

        // Update data
        $footer->update($request->only([
            'nama', 'deskripsi', 'alamat', 'telepon', 'email', 'lokasi',
            'link_ig', 'link_fb', 'link_wa', 'link_youtube',
        ]));

        return redirect()->route('admin.footer.index')->with('success', 'Data footer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->delete();

        return redirect()->route('admin.footer.index')->with('success', 'Data footer berhasil dihapus!');
    }
}
