<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pesan;
use App\Models\PerangkatDesa;
use App\Models\Umkm;
use App\Models\User;
use App\Models\DataPenduduk;
use App\Models\DataStunting;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics cards
        $stats = [
            'total_berita' => Berita::count(),
            'total_umkm' => Umkm::count(),
            'total_perangkat' => PerangkatDesa::count(),
            'total_pesan' => Pesan::count(),
            'pesan_unread' => Pesan::whereDate('created_at', '>=', now()->subDays(7))->count(),
            'total_users' => User::count(),
            'total_stunting' => DataStunting::count(),
            'total_videos' => Video::count(),
        ];

        // Data penduduk
        $dataPenduduk = DataPenduduk::first();

        // Recent berita (last 5)
        $recentBerita = Berita::with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent messages (last 5)
        $recentPesan = Pesan::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Berita per kategori for chart
        $beritaPerKategori = Berita::select('kategori_berita.nama', DB::raw('count(*) as total'))
            ->join('kategori_berita', 'beritas.kategori_id', '=', 'kategori_berita.id')
            ->groupBy('kategori_berita.nama')
            ->get();

        // Monthly berita trend (last 6 months)
        $monthlyBerita = Berita::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Data Stunting statistics
        $stuntingStats = [
            'total' => DataStunting::count(),
            'normal' => DataStunting::where('status_stunting', 'normal')->count(),
            'stunting' => DataStunting::where('status_stunting', 'stunting')->count(),
            'severely_stunting' => DataStunting::where('status_stunting', 'severely_stunting')->count(),
            'tinggi' => DataStunting::where('status_stunting', 'tinggi')->count(),
        ];

        // Recent stunting data
        $recentStunting = DataStunting::orderBy('tanggal_pengukuran', 'desc')
            ->limit(5)
            ->get();

        // Recent videos
        $recentVideos = Video::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'dataPenduduk',
            'recentBerita',
            'recentPesan',
            'beritaPerKategori',
            'monthlyBerita',
            'stuntingStats',
            'recentStunting',
            'recentVideos'
        ));
    }
}
