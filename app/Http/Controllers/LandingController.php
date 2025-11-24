<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\HeroBanner;
use App\Models\Logo;
use App\Models\DataPenduduk;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Pesan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Fetch heroes from database
        $heroes = Hero::all();

        // Fetch logos (max 3)
        $logos = Logo::limit(3)->get();

        // Fetch data penduduk (single row)
        $dataPenduduk = DataPenduduk::first();

        // Fetch latest 6 berita with images and kategori
        $berita = Berita::with(['images', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Fetch UMKM with images (max 8 for grid display)
        $umkm = Umkm::with('images')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('landing.index', compact('heroes', 'logos', 'dataPenduduk', 'berita', 'umkm'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Pesan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('landing.index')->with('success', 'Pesan Anda berhasil dikirim!');
    }

    public function berita()
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch all berita with pagination
        $berita = Berita::with(['images', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('landing.berita.index', compact('berita', 'heroBanner'));
    }

    public function detailBerita($slug)
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch berita by slug
        $berita = Berita::with(['images', 'kategori'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Fetch related news from same category (exclude current berita)
        $relatedBerita = Berita::with(['images', 'kategori'])
            ->where('kategori_id', $berita->kategori_id)
            ->where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('landing.berita.show', compact('berita', 'heroBanner', 'relatedBerita'));
    }
}
