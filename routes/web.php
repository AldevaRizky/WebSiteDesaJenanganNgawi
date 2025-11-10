<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Static data for landing page (so it works without DB)
    $heroes = [
        (object)['cover' => 'assets/img/hero1.jpg'],
        (object)['cover' => 'assets/img/hero2.jpg'],
    ];

    $logos = [
        (object)['logo' => 'assets/img/logo1.png'],
        (object)['logo' => 'assets/img/logo2.png'],
        (object)['logo' => 'assets/img/logo3.png'],
    ];

    $dataSekolah = (object)[
        'siswa' => 1200,
        'guru' => 75,
        'prestasi' => 45,
    ];

    $berita = [
        (object)['id' => 1, 'gambar' => 'assets/img/news1.jpg', 'judul' => 'Pengumuman Peringkat Sekolah', 'deskripsi' => 'Sekolah kita meraih peringkat terbaik dalam kompetisi regional.'],
        (object)['id' => 2, 'gambar' => 'assets/img/news2.jpg', 'judul' => 'Kegiatan Bakti Sosial', 'deskripsi' => 'Siswa-siswi mengikuti kegiatan bakti sosial di lingkungan sekitar.'],
        (object)['id' => 3, 'gambar' => 'assets/img/news3.jpg', 'judul' => 'Festival Seni', 'deskripsi' => 'Pameran dan pentas seni memperlihatkan talenta siswa.'],
    ];

    $ekstrakurikuler = [
        (object)['gambar' => 'assets/img/ex1.png', 'nama' => 'Pramuka'],
        (object)['gambar' => 'assets/img/ex2.png', 'nama' => 'Basket'],
        (object)['gambar' => 'assets/img/ex3.png', 'nama' => 'Seni Tari'],
        (object)['gambar' => 'assets/img/ex4.png', 'nama' => 'Sains Club'],
    ];

    return view('landing.index', compact('heroes', 'logos', 'dataSekolah', 'berita', 'ekstrakurikuler'));
})->name('landing.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes with auth middleware
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Heroes CRUD routes
    Route::resource('heroes', \App\Http\Controllers\Admin\HeroController::class)->except(['show', 'create', 'edit']);
    // Hero Banner routes
    Route::resource('hero_banner', \App\Http\Controllers\Admin\HeroBannerController::class)->except(['show', 'create', 'edit']);
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
