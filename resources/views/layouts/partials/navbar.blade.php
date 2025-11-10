<!-- Navigation Bar -->
<nav id="navbar" class="navbar transparent py-5 px-6 flex justify-between items-center text-white">
    <div class="flex items-center">
        <img src="{{ asset('assets/img/logo/83790f2b43f00be.png') }}"
             alt="Logo Sekolah" class="navbar-logo-img w-12 h-12 mr-3">
        <h1 class="navbar-logo text-xl font-bold large">Sekolah Berprestasi</h1>
    </div>

    <!-- Menu List -->
    <ul id="menu" class="hidden md:flex space-x-6 relative">
        <li>
            <a href="{{ route('landing.index') }}"
               class="navbar-text hover:text-blue-400 large {{ Request::is('/') ? 'active' : '' }}">
               Beranda
            </a>
        </li>
        <li class="dropdown">
            <a href="#" id="tentangKami"
               class="navbar-text hover:text-blue-400 large {{ Request::is('tentang-kami*') ? 'active' : '' }}">
               Tentang Kami
            </a>
            <div class="dropdown-menu">
                <a href="#"
                   class="{{ Request::is('tentang-kami/sejarah-sekolah') ? 'active' : '' }}">
                   Sejarah Sekolah
                </a>
                <a href="#"
                   class="{{ Request::is('tentang-kami/sambutan') ? 'active' : '' }}">
                   Sambutan Kepala Sekolah
                </a>
                <a href="#"
                   class="{{ Request::is('tentang-kami/visi-misi') ? 'active' : '' }}">
                   Visi & Misi
                </a>
                <a href="#"
                   class="{{ Request::is('tentang-kami/fasilitas') ? 'active' : '' }}">
                   Fasilitas
                </a>
            </div>
        </li>
        <li>
            <a href="#"
               class="navbar-text hover:text-blue-400 large {{ Request::is('ekstrakurikuler') ? 'active' : '' }}">
               Ekstrakurikuler
            </a>
        </li>
        <li>
            <a href="#"
               class="navbar-text hover:text-blue-400 large {{ Request::is('berita') ? 'active' : '' }}">
               Berita
            </a>
        </li>
        <li>
            <a href="#"
               class="navbar-text hover:text-blue-400 large {{ Request::is('prestasi') ? 'active' : '' }}">
               Prestasi
            </a>
        </li>
        <li>
            <a href="#"
               class="navbar-text hover:text-blue-400 large {{ Request::is('ppdb') ? 'active' : '' }}">
               PPDB
            </a>
        </li>
    </ul>

    <!-- Logic for Login/Logout -->
    <div>
        @if (Auth::check())
            @php
                // Only provide admin dashboard link. Fall back to login route if admin dashboard not available.
                if (Auth::user()->role === 'admin' && \Illuminate\Support\Facades\Route::has('admin.dashboard')) {
                    $redirectRoute = route('admin.dashboard');
                } else {
                    $redirectRoute = route('login');
                }
            @endphp
            <a href="{{ $redirectRoute }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white text-sm hidden md:block">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white text-sm hidden md:block">
                Login
            </a>
        @endif
    </div>

    <!-- Hamburger Button -->
    <button id="hamburger" class="md:hidden flex items-center text-white focus:outline-none">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden flex flex-col bg-gray-800 text-white py-4 px-6 fixed left-0 w-full z-10">
    <a href="{{ route('landing.index') }}"
       class="py-2 border-b border-gray-600 {{ Request::is('/') ? 'active' : '' }}">
       Beranda
    </a>
    <div class="py-2 border-b border-gray-600 relative">
        <a href="#" id="mobileTentangKami"
           class="block {{ Request::is('tentang-kami*') ? 'active' : '' }}">
           Tentang Kami
        </a>
        <div class="dropdown-menu absolute left-0 w-full bg-gray-700 hidden">
            <a href="#"
               class="block px-4 py-2 {{ Request::is('tentang-kami/sejarah-sekolah') ? 'active' : '' }}">
               Sejarah Sekolah
            </a>
            <a href="#"
               class="block px-4 py-2 {{ Request::is('tentang-kami/sambutan') ? 'active' : '' }}">
               Sambutan Kepala Sekolah
            </a>
            <a href="#"
               class="block px-4 py-2 {{ Request::is('tentang-kami/visi-misi') ? 'active' : '' }}">
               Visi & Misi
            </a>
            <a href="#"
               class="block px-4 py-2 {{ Request::is('tentang-kami/fasilitas') ? 'active' : '' }}">
               Fasilitas
            </a>
        </div>
    </div>
     <a href="#"
         class="py-2 border-b border-gray-600 {{ Request::is('ekstrakurikuler') ? 'active' : '' }}">
         Ekstrakurikuler
     </a>
    <a href="#"
       class="py-2 border-b border-gray-600 {{ Request::is('berita') ? 'active' : '' }}">
       Berita
    </a>
    <a href="#"
       class="py-2 border-b border-gray-600 {{ Request::is('prestasi') ? 'active' : '' }}">
       Prestasi
    </a>
    <a href="#"
       class="py-2 border-b border-gray-600 {{ Request::is('ppdb') ? 'active' : '' }}">
       PPDB
    </a>
    @if (Auth::check())
        <a href="{{ $redirectRoute }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white text-sm mt-4 w-full text-center">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white text-sm mt-4 w-full text-center">Login</a>
    @endif
</div>
