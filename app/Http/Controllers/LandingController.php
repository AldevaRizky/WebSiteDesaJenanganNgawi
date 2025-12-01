<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\HeroBanner;
use App\Models\Logo;
use App\Models\DataPenduduk;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Umkm;
use App\Models\Pesan;
use App\Models\SejarahDesa;
use App\Models\SambutanKepalaDesa;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Fetch heroes from database
        $heroes = Hero::all();

        // Fetch logos (max 3)
        $logos = Logo::limit(3)->get();

        // Fetch data penduduk (single row)
        $dataPenduduk = DataPenduduk::first();

        // Fetch all kategoris for filter
        $kategoris = KategoriBerita::orderBy('nama', 'asc')->get();

        // Build query for berita
        $query = Berita::with(['images', 'kategori']);

        // Filter by kategori if provided
        if ($request->has('kategori') && $request->kategori) {
            $kategori = KategoriBerita::where('slug', $request->kategori)->first();
            if ($kategori) {
                $query->where('kategori_id', $kategori->id);
            }
        }

        // Fetch latest 3 berita with images and kategori
        $berita = $query->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Fetch UMKM with images (max 3 for grid display)
        $umkm = Umkm::with('images')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('landing.index', compact('heroes', 'logos', 'dataPenduduk', 'berita', 'umkm', 'kategoris'));
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

    public function berita(Request $request)
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch all kategoris for filter
        $kategoris = KategoriBerita::orderBy('nama', 'asc')->get();

        // Build query for berita
        $query = Berita::with(['images', 'kategori']);

        // Filter by kategori if provided
        if ($request->has('kategori') && $request->kategori) {
            $kategori = KategoriBerita::where('slug', $request->kategori)->first();
            if ($kategori) {
                $query->where('kategori_id', $kategori->id);
            }
        }

        // Fetch berita with pagination
        $berita = $query->orderBy('created_at', 'desc')->paginate(12);

        // Append kategori to pagination links
        $berita->appends(['kategori' => $request->kategori]);

        return view('landing.berita.index', compact('berita', 'heroBanner', 'kategoris'));
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

    public function umkm()
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch all UMKM with pagination
        $umkm = Umkm::with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('landing.umkm.index', compact('umkm', 'heroBanner'));
    }

    public function detailUmkm($id)
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch UMKM by ID
        $umkm = Umkm::with('images')->findOrFail($id);

        // Fetch related UMKM (exclude current)
        $relatedUmkm = Umkm::with('images')
            ->where('id', '!=', $umkm->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('landing.umkm.show', compact('umkm', 'heroBanner', 'relatedUmkm'));
    }

    public function sejarah()
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch sejarah desa
        $sejarah = SejarahDesa::first();

        return view('landing.sejarah.index', compact('sejarah', 'heroBanner'));
    }

    public function sambutan()
    {
        // Fetch hero banner for header
        $heroBanner = HeroBanner::first();

        // Fetch sambutan kepala desa
        $sambutan = SambutanKepalaDesa::first();

        return view('landing.sambutan.index', compact('sambutan', 'heroBanner'));
    }
}
