@extends('layouts.landing')

@section('title', 'UMKM Desa Jenangan')

@section('content')
<!-- Hero Banner -->
<section class="relative h-64 bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-center">
    @if($heroBanner && $heroBanner->image)
    <div class="absolute inset-0">
        <img src="{{ Storage::url($heroBanner->image) }}" alt="Hero Banner" class="w-full h-full object-cover opacity-30">
    </div>
    @endif
    <div class="relative z-10 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">UMKM DESA JENANGAN</h1>
        <p class="text-lg md:text-xl">Produk Unggulan dari Desa Jenangan</p>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-6 md:px-16">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('landing.index') }}" class="hover:text-blue-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-blue-500 font-semibold">UMKM</span>
        </nav>
    </div>
</div>

<!-- UMKM Grid Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 md:px-16">
        @if($umkm->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($umkm as $item)
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
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $umkm->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <i class='bx bx-store' style="font-size: 100px; color: #cbd5e1;"></i>
            <h3 class="text-gray-500 text-2xl font-semibold mt-6">Belum Ada Data UMKM</h3>
            <p class="text-gray-400 mt-3">Data UMKM akan ditampilkan di sini ketika sudah tersedia.</p>
            <a href="{{ route('landing.index') }}" class="inline-block mt-6 bg-blue-500 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-600 transition duration-300">
                Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
