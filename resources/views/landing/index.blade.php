@extends('layouts.landing')

@section('title', 'Website Desa Jenangan')

@section('content')
        <!-- Hero Section -->
        <header class="hero relative">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="text-3xl md:text-6xl font-bold mb-4">Selamat Datang</h1>
                <span class="text-5xl text-blue-400 font-bold">Website Desa <span class="text-blue-600">Jenangan</span></span>
                <p class="text-lg md:text-2xl mt-4">Sumber Informasi Terbaru Tentang Pemerintahan di Desa Jenangan</p>
            </div>
            <div id="hero-images" class="hero-images absolute top-0 left-0 w-full h-full">
                @foreach ($heroes as $hero)
                    <div class="hero-image" style="background-image: url('{{ asset('storage/' . str_replace('public/', '', $hero->cover)) }}');"></div>
                @endforeach
            </div>
        </header>

        <!-- Logo Section -->
        <section id="logo-section" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 bg-white py-6 px-12 rounded-3xl shadow-lg flex items-center justify-around space-x-6 w-[90%] max-w-4xl">
            @foreach($logos as $logo)
                <img src="{{ asset('storage/' . str_replace('public/', '', $logo->logo)) }}" alt="Logo" class="h-16 md:h-20 hover:scale-110 transition-transform duration-300 ease-in-out">
            @endforeach
        </section>

        <!-- Data Penduduk Section -->
        <section id="data-penduduk" class="py-12 mt-0 bg-blue-50 text-center" style="background-size: 100% 150%; background-position: center;">
            <h2 class="text-4xl md:text-4xl font-bold text-gray-800 mt-20 mb-6">DATA PENDUDUK</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-12"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-6 md:px-16">
                <!-- Total Penduduk -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/681/681443.png" alt="Total Penduduk" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataPenduduk->total_penduduk ?? 'N/A' }}</p>
                    <p class="text-gray-600">Total Penduduk</p>
                </div>
                <!-- Kepala Keluarga -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/3429/3429433.png" alt="Kepala Keluarga" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataPenduduk->kepala_keluarga ?? 'N/A' }}</p>
                    <p class="text-gray-600">Kepala Keluarga</p>
                </div>
                <!-- Laki-laki -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Laki-laki" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataPenduduk->laki_laki ?? 'N/A' }}</p>
                    <p class="text-gray-600">Laki-laki</p>
                </div>
                <!-- Perempuan -->
                <div class="flex flex-col items-center mb-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135789.png" alt="Perempuan" class="h-12 mb-2">
                    <p class="text-2xl font-bold text-blue-500">{{ $dataPenduduk->perempuan ?? 'N/A' }}</p>
                    <p class="text-gray-600">Perempuan</p>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section id="berita-terbaru" class="py-12 mt-13 bg-gray-100 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">BERITA TERBARU</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-8"></div>

            <!-- Filter Kategori -->
            @if(isset($kategoris))
            <div class="flex flex-wrap justify-center gap-3 px-6 mb-8">
                <a href="{{ route('landing.index') }}#berita-terbaru" class="px-6 py-2 rounded-full font-semibold transition-all duration-300 {{ !request('kategori') ? 'bg-blue-500 text-white shadow-lg' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-blue-500 hover:text-blue-500' }}">
                    Semua
                </a>
                @foreach($kategoris as $kategori)
                <a href="{{ route('landing.index', ['kategori' => $kategori->slug]) }}#berita-terbaru" class="px-6 py-2 rounded-full font-semibold transition-all duration-300 {{ request('kategori') == $kategori->slug ? 'bg-blue-500 text-white shadow-lg' : 'bg-white text-gray-700 border-2 border-gray-300 hover:border-blue-500 hover:text-blue-500' }}">
                    {{ $kategori->nama }}
                </a>
                @endforeach
            </div>
            @endif

            @if($berita->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-16">

                <!-- Loop untuk menampilkan berita -->
                @foreach($berita as $item)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300 flex flex-col h-full">
                    <!-- Gambar berita -->
                    @if($item->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->images->first()->path) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('assets/img/default-news.jpg') }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-xs text-blue-500 font-semibold mb-2 inline-block px-3 py-1 border-2 border-blue-500 rounded-full self-start break-words">{{ $item->kategori->nama ?? 'Umum' }}</span>
                        <!-- Judul berita -->
                        <h3 class="font-semibold text-lg text-gray-800 mb-3 text-center line-clamp-2 min-h-[3.5rem] break-words overflow-hidden">{{ $item->judul }}</h3>
                        <!-- Deskripsi berita -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow break-words overflow-hidden">{{ $item->deskripsi }}</p>
                        <!-- Link ke detail berita -->
                        <a href="{{ route('landing.detail-berita', $item->slug) }}" class="text-blue-500 font-bold hover:underline mt-auto text-sm">Read More &gt;&gt;</a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class='bx bx-news' style="font-size: 80px; color: #cbd5e1;"></i>
                <h4 class="text-gray-500 text-xl font-semibold mt-4">Belum Ada Berita</h4>
                <p class="text-gray-400 mt-2">Berita akan ditampilkan di sini ketika sudah tersedia.</p>
            </div>
            @endif
            <!-- Button "Lebih Banyak" -->
            @if($berita->count() > 0)
            <div class="mt-8">
                <a href="{{ route('landing.berita') }}" class="bg-blue-500 text-white font-bold py-2 px-8 rounded-md hover:bg-blue-600 transition duration-300">
                    LEBIH BANYAK
                </a>
            </div>
            @endif
        </section>

        <!-- UMKM Section -->
        <section id="umkm" class="py-12 bg-blue-50 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mt-6 mb-6">UMKM DESA</h2>
            <div class="w-16 h-1 bg-blue-500 mx-auto mb-12"></div>

            <!-- Grid Container -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-16 mb-10">
                <!-- Loop untuk menampilkan data UMKM -->
                @forelse($umkm as $item)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                    <!-- Gambar UMKM -->
                    <div class="relative overflow-hidden" style="height: 200px;">
                        @if($item->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->images->first()->path) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="{{ asset('assets/img/default-umkm.jpg') }}" alt="{{ $item->nama }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <!-- Nama UMKM -->
                        <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2 min-h-[3.5rem]">{{ $item->nama }}</h3>
                        
                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">{{ $item->deskripsi }}</p>
                        
                        <!-- Alamat -->
                        @if($item->alamat)
                        <div class="flex items-start text-gray-700 text-sm mb-3">
                            <i class='bx bx-map text-blue-500 text-lg mr-2 mt-0.5'></i>
                            <span class="line-clamp-2">{{ $item->alamat }}</span>
                        </div>
                        @endif
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-200">
                            <div class="flex gap-2">
                                @if($item->link_wa)
                                <a href="{{ $item->link_wa }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors duration-300" title="WhatsApp">
                                    <i class='bx bxl-whatsapp text-xl'></i>
                                </a>
                                @endif
                                
                                @if($item->link_maps)
                                <a href="{{ $item->link_maps }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors duration-300" title="Google Maps">
                                    <i class='bx bx-map text-xl'></i>
                                </a>
                                @endif
                            </div>
                            
                            <a href="{{ route('landing.umkm.show', $item->id) }}" class="text-blue-500 font-semibold hover:text-blue-700 text-sm flex items-center gap-1">
                                Detail <i class='bx bx-right-arrow-alt text-lg'></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <i class='bx bx-store' style="font-size: 80px; color: #cbd5e1;"></i>
                    <h4 class="text-gray-500 text-xl font-semibold mt-4">Belum Ada Data UMKM</h4>
                    <p class="text-gray-400 mt-2">Data UMKM akan ditampilkan di sini ketika sudah tersedia.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Button "Lebih Banyak" -->
            @if($umkm->count() > 0)
            <div class="mt-8">
                <a href="{{ route('landing.umkm') }}" class="bg-blue-500 text-white font-bold py-2 px-8 rounded-md hover:bg-blue-600 transition duration-300">
                    LEBIH BANYAK
                </a>
            </div>
            @endif
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
                    <form action="{{ route('landing.contact') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-600">Nama</label>
                            <input type="text" id="nama" name="nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
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
