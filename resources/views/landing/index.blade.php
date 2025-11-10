@extends('layouts.landing')

@section('title', 'Sekolah Berprestasi')

@section('content')
        <!-- Hero Section -->
        <header class="hero relative">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="text-3xl md:text-6xl font-bold mb-4">Selamat Datang di</h1>
                <span class="text-5xl text-blue-400 font-bold">Sekolah <span class="text-blue-600">Berprestasi</span></span>
                <p class="text-lg md:text-2xl mt-4">Membangun Generasi Cerdas dan Berkarakter</p>
            </div>
            <div id="hero-images" class="hero-images absolute top-0 left-0 w-full h-full">
                @foreach ($heroes as $hero)
                    <div class="hero-image" style="background-image: url('{{ asset($hero->cover) }}');"></div>
                @endforeach
            </div>
        </header>

        <!-- Logo Section -->
        <section id="logo-section" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 bg-white py-6 px-12 rounded-3xl shadow-lg flex items-center justify-around space-x-6 w-[90%] max-w-4xl">
            @foreach($logos as $logo)
                <img src="{{ asset($logo->logo) }}" alt="Logo" class="h-16 md:h-20 hover:scale-110 transition-transform duration-300 ease-in-out">
            @endforeach
        </section>

        <!-- School Data Section -->
        <section id="data-sekolah" class="py-12 mt-0 bg-blue-50 text-center" style="background-size: 100% 150%; background-position: center;">
            <h2 class="text-4xl md:text-4xl font-bold text-gray-800 mt-20 mb-6">DATA SEKOLAH</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-12"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-16">
                <!-- Siswa -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/2940/2940653.png" alt="Siswa" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataSekolah->siswa ?? 'N/A' }}</p>
                    <p class="text-gray-600">Siswa</p>
                </div>
                <!-- Guru -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/3429/3429433.png" alt="Guru" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataSekolah->guru ?? 'N/A' }}</p>
                    <p class="text-gray-600">Guru</p>
                </div>
                <!-- Prestasi -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/13059/13059602.png" alt="Prestasi" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataSekolah->prestasi ?? 'N/A' }}</p>
                    <p class="text-gray-600">Prestasi</p>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section id="berita-terbaru" class="py-12 mt-13 bg-gray-100 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">BERITA TERBARU</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-8"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-16">

                <!-- Loop untuk menampilkan berita -->
                @foreach($berita as $item)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                    <!-- Gambar berita -->
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <!-- Judul berita -->
                        <h3 class="font-semibold text-lg text-gray-800 mb-3">{{ $item->judul }}</h3>
                        <!-- Deskripsi berita -->
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->deskripsi, 100) }}</p>
                        <!-- Link ke detail berita -->
                        {{-- <a href="{{ route('landing.detail-berita', $item->id) }}" class="text-blue-500 font-bold hover:underline">Read More &gt;&gt;</a> --}}
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Button "Lebih Banyak" -->
            <div class="mt-8">
                {{-- <a href="{{ route('landing.berita') }}" class="bg-blue-500 text-white font-bold py-2 px-8 rounded-md hover:bg-blue-600 transition duration-300">
                    LEBIH BANYAK
                </a> --}}
            </div>
        </section>

        <!-- Extrakurikuler Section -->
        <section id="ekstrakurikuler" class="py-12 bg-blue-50 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mt-6 mb-6">EKSTRAKURIKULER</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-12"></div>

            <!-- Grid Container -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-6 md:px-16 mb-10">
                <!-- Loop untuk menampilkan data ekstrakurikuler -->
                @foreach($ekstrakurikuler as $item)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6 hover:scale-105 transition-transform duration-300">
                    <!-- Gambar ekstrakurikuler -->
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}" class="w-20 h-20 mx-auto mb-4 object-contain">
                    <!-- Nama ekstrakurikuler -->
                    <h3 class="font-semibold text-lg text-blue-600">{{ $item->nama }}</h3>
                </div>
                @endforeach
            </div>

            <!-- Button "Lebih Banyak" -->
            <div class="mt-8">
                {{-- <a href="{{ route('landing.ekstrakurikuler') }}" class="bg-blue-500 text-white font-bold py-2 px-8 rounded-md hover:bg-blue-600 transition duration-300">
                    LEBIH BANYAK
                </a> --}}
            </div>
        </section>

        <div id="contact" class="container mx-auto px-4 py-12">
            <!-- Section Title -->
            <h2 class="text-4xl font-bold text-gray-800 mt-6 mb-6 text-center">CONTACT</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-12"></div>

            <!-- Contact Section -->
            <div class="flex flex-col lg:flex-row items-center bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Left Section (Contact Form) -->
                <div class="w-full lg:w-1/2 p-8">
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800">Hubungi Kami</h3>
                    {{-- <form action="{{ route('pesan.store') }}" method="POST" class="space-y-6"> --}}
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-600">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600">E-mail</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan email Anda" required>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-600">Pesan</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan pesan Anda" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-600 transition duration-300">Kirim</button>
                    </form>
                </div>

                <!-- Right Section (Image) -->
                <img src="{{ asset('assets/img/illustrations/3.png') }}"
                style="width: 45%; height: auto;"
                class="object-cover">

                </div>
            </div>
        </div>
        @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
        @endif
@endsection
