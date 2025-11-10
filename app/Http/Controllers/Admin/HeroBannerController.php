<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        // Ambil data hero banner (hanya satu data)
        $heroBanner = HeroBanner::first();

        return view('admin.hero_banner.index', compact('heroBanner'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        // Cek apakah data sudah ada
        if (HeroBanner::count() > 0) {
            return redirect()->route('admin.hero_banner.index')->withErrors('Hero Banner sudah ada. Anda hanya dapat mengedit data.');
        }

        // Simpan file gambar
        $imagePath = $request->file('image')->store('public/hero_banner');

        // Buat data baru
        HeroBanner::create([
            'image' => $imagePath,
        ]);

    return redirect()->route('admin.hero_banner.index')->with('success', 'Hero Banner berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400',
        ]);

        $heroBanner = HeroBanner::findOrFail($id);

        // Update file gambar jika ada
        if ($request->hasFile('image')) {
            Storage::delete($heroBanner->image);
            $heroBanner->image = $request->file('image')->store('public/hero_banner');
        }

        // Update data lainnya
        $heroBanner->save();

    return redirect()->route('admin.hero_banner.index')->with('success', 'Hero Banner berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $heroBanner = HeroBanner::findOrFail($id);
        Storage::delete($heroBanner->image);
        $heroBanner->delete();

    return redirect()->route('admin.hero_banner.index')->with('success', 'Hero Banner berhasil dihapus!');
    }
}
