@extends('layouts.landing')

@section('title', 'SOTK - Website Desa Jenangan')

@section('content')
<!-- Hero Banner -->
<div class="bg-gray-100">
    <div class="relative bg-cover bg-center h-64"
        style="background-image: url('{{ $heroBanner && $heroBanner->image ? Storage::url($heroBanner->image) : asset('assets/img/hero-default.jpg') }}');
                background-size: cover;
                background-repeat: no-repeat;
                width: 100%;
                height: 300px;">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center px-4">
                <h1 class="text-white text-3xl md:text-5xl font-bold">SOTK</h1>
                <p class="text-white/80 mt-2">Struktur Organisasi dan Tata Kerja Desa Jenangan</p>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-6 md:px-16">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('landing.index') }}" class="hover:text-blue-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-blue-500 font-semibold">SOTK</span>
        </nav>
    </div>
</div>

<!-- Bagan Struktur Organisasi Section -->
@if($bagan)
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 md:px-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Bagan Struktur Organisasi</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-4"></div>
            <p class="text-gray-600">{{ $bagan->nama ?? 'Struktur Organisasi Pemerintah Desa Jenangan' }}</p>
        </div>

        <!-- Bagan Image -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <img src="{{ Storage::url($bagan->gambar) }}" alt="{{ $bagan->nama ?? 'Bagan Struktur Organisasi' }}" class="w-full h-auto object-contain">
        </div>
    </div>
</section>
@endif

<!-- Perangkat Desa Section -->
<section class="py-12 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-6 md:px-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Perangkat Desa</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-4"></div>
            <p class="text-gray-600">Daftar Perangkat Desa Jenangan</p>
        </div>

        @if($perangkat->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($perangkat as $item)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <!-- Photo -->
                <div class="relative overflow-hidden" style="height: 280px;">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <i class='bx bx-user text-white text-8xl'></i>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <h3 class="text-white font-bold text-lg">{{ $item->nama }}</h3>
                    </div>
                </div>

                <!-- Info -->
                <div class="p-5">
                    <!-- Jabatan -->
                    <div class="mb-3">
                        <div class="inline-block bg-blue-500 text-white text-sm font-semibold px-4 py-1 rounded-full">
                            {{ $item->jabatan ?? 'Staff' }}
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    @if($item->deskripsi)
                    <div class="text-gray-600 text-sm mb-4 line-clamp-3 prose prose-sm max-w-none">
                        {!! Str::limit(strip_tags($item->deskripsi), 100) !!}
                    </div>
                    @endif

                    <!-- Contact Info -->
                    <div class="space-y-2 pt-4 border-t border-gray-200">
                        @if($item->phone)
                        <div class="flex items-center text-gray-700 text-sm">
                            <i class='bx bx-phone text-blue-500 text-lg mr-2'></i>
                            <span class="break-all">{{ $item->phone }}</span>
                        </div>
                        @endif

                        @if($item->email)
                        <div class="flex items-center text-gray-700 text-sm">
                            <i class='bx bx-envelope text-blue-500 text-lg mr-2'></i>
                            <span class="break-all">{{ $item->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <i class='bx bx-user-circle' style="font-size: 100px; color: #cbd5e1;"></i>
            <h3 class="text-gray-500 text-2xl font-semibold mt-6">Belum Ada Data Perangkat Desa</h3>
            <p class="text-gray-400 mt-3">Data perangkat desa akan ditampilkan di sini ketika sudah tersedia.</p>
            <a href="{{ route('landing.index') }}" class="inline-block mt-6 bg-blue-500 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-600 transition duration-300">
                Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Tata Kerja Section (Optional Information) -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 md:px-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Tata Kerja</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Tugas Pokok -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-1 rounded-2xl shadow-xl">
                <div class="bg-white rounded-2xl p-8 h-full">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl w-16 h-16 flex items-center justify-center mr-4">
                            <i class='bx bx-task text-3xl'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Tugas Pokok</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Melaksanakan urusan pemerintahan, pembangunan, dan pelayanan kemasyarakatan sesuai dengan kewenangan desa.
                    </p>
                </div>
            </div>

            <!-- Fungsi -->
            <div class="bg-gradient-to-br from-green-500 to-green-700 p-1 rounded-2xl shadow-xl">
                <div class="bg-white rounded-2xl p-8 h-full">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-xl w-16 h-16 flex items-center justify-center mr-4">
                            <i class='bx bx-cog text-3xl'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Fungsi</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Menyelenggarakan pemerintahan desa, melaksanakan pembangunan desa, pembinaan kemasyarakatan desa, dan pemberdayaan masyarakat desa.
                    </p>
                </div>
            </div>

            <!-- Wewenang -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-700 p-1 rounded-2xl shadow-xl">
                <div class="bg-white rounded-2xl p-8 h-full">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-700 text-white rounded-xl w-16 h-16 flex items-center justify-center mr-4">
                            <i class='bx bx-shield text-3xl'></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Wewenang</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Mengatur dan mengurus kepentingan masyarakat berdasarkan hak asal usul dan adat istiadat setempat yang diakui dan dihormati.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
