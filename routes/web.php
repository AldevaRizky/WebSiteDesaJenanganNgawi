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
    // Logos CRUD routes
    Route::resource('logos', \App\Http\Controllers\Admin\LogoController::class)->except(['show', 'create', 'edit']);
    // Data Penduduk CRUD routes
    Route::resource('data_penduduk', \App\Http\Controllers\Admin\DataPendudukController::class)->except(['show', 'create', 'edit']);
    // Sejarah Desa CRUD routes
    Route::resource('sejarah_desa', \App\Http\Controllers\Admin\SejarahDesaController::class)->except(['show', 'create', 'edit']);
    // Sambutan Kepala Desa CRUD routes
    Route::resource('sambutan_kepala_desa', \App\Http\Controllers\Admin\SambutanKepalaDesaController::class)->except(['show', 'create', 'edit']);
    // Visi & Misi CRUD routes
    Route::resource('visi_misi', \App\Http\Controllers\Admin\VisiMisiController::class)->except(['show', 'create', 'edit']);
    // Footer CRUD routes
    Route::resource('footer', \App\Http\Controllers\Admin\FooterController::class)->except(['show', 'create', 'edit']);
    // Kategori Berita CRUD
    Route::resource('kategori_berita', \App\Http\Controllers\Admin\KategoriBeritaController::class)->except(['show', 'create', 'edit']);
    // UMKM CRUD routes
    Route::resource('umkm', \App\Http\Controllers\Admin\UmkmController::class);
    // Perangkat Desa CRUD + bagan
    // register bagan routes (single-photo CRUD) before resource to avoid conflict with {perangkat} show route
    Route::get('perangkat/bagan', [\App\Http\Controllers\Admin\BaganController::class, 'index'])->name('perangkat.bagan');
    Route::post('perangkat/bagan', [\App\Http\Controllers\Admin\BaganController::class, 'store'])->name('perangkat.bagan.store');
    Route::put('perangkat/bagan/{id}', [\App\Http\Controllers\Admin\BaganController::class, 'update'])->name('perangkat.bagan.update');
    Route::delete('perangkat/bagan/{id}', [\App\Http\Controllers\Admin\BaganController::class, 'destroy'])->name('perangkat.bagan.destroy');
    Route::resource('perangkat', \App\Http\Controllers\Admin\PerangkatDesaController::class);
    // Pesan (messages) admin view
    Route::resource('pesans', \App\Http\Controllers\Admin\PesanController::class)->only(['index', 'destroy']);
    // Users admin CRUD
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
    // Berita CRUD
    Route::resource('berita', \App\Http\Controllers\Admin\BeritaController::class);
    // CKEditor image upload
    Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\BeritaController::class, 'uploadImage'])->name('ckeditor.upload');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
