@extends('layouts.landing')

@section('title', $umkm->nama . ' - UMKM Desa Jenangan')

@section('content')
<!-- Hero Banner -->
<div class="bg-gray-100">
    <div class="relative bg-cover bg-center h-64"
        style="background-image: url('{{ $heroBanner && $heroBanner->image ? Storage::url($heroBanner->image) : asset('assets/img/hero-default.jpg') }}');
                background-size: cover;
                background-repeat: no-repeat;
                width: 100%;
                height: 300px;
                margin: 0 auto;">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center px-4">
                <h1 class="text-white text-3xl md:text-5xl font-bold">{{ Str::limit($umkm->nama, 60) }}</h1>
                <p class="text-white/80 mt-2">UMKM Desa Jenangan</p>
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
            <a href="{{ route('landing.umkm') }}" class="hover:text-blue-500">UMKM</a>
            <span class="mx-2">/</span>
            <span class="text-blue-500 font-semibold">{{ Str::limit($umkm->nama, 30) }}</span>
        </nav>
    </div>
</div>

<!-- UMKM Detail Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 md:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Featured Image -->
                @if($umkm->images->isNotEmpty())
                <div class="mb-8 rounded-lg overflow-hidden shadow-2xl">
                    <img src="{{ asset('storage/' . $umkm->images->first()->path) }}" alt="{{ $umkm->nama }}" class="w-full h-96 object-cover">
                </div>
                @endif

                <!-- UMKM Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $umkm->nama }}</h2>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center">
                            <i class='bx bx-info-circle text-blue-500 text-2xl mr-2'></i>
                            Deskripsi
                        </h3>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                            {!! $umkm->deskripsi !!}
                        </div>
                    </div>

                    <!-- Alamat -->
                    @if($umkm->alamat)
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center">
                            <i class='bx bx-map text-blue-500 text-2xl mr-2'></i>
                            Alamat
                        </h3>
                        <p class="text-gray-600">{{ $umkm->alamat }}</p>
                    </div>
                    @endif

                    <!-- Contact Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Hubungi Kami</h3>
                        <div class="flex flex-wrap gap-4">
                            @if($umkm->link_wa)
                            <a href="{{ $umkm->link_wa }}" target="_blank" class="flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors duration-300 shadow-md hover:shadow-lg">
                                <i class='bx bxl-whatsapp text-2xl'></i>
                                <span class="font-semibold">WhatsApp</span>
                            </a>
                            @endif

                            @if($umkm->link_maps)
                            <a href="{{ $umkm->link_maps }}" target="_blank" class="flex items-center gap-2 bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors duration-300 shadow-md hover:shadow-lg">
                                <i class='bx bx-map text-2xl'></i>
                                <span class="font-semibold">Google Maps</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gallery Images -->
                @if($umkm->images->count() > 1)
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class='bx bx-images text-blue-500 text-3xl mr-2'></i>
                        Galeri Foto
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($umkm->images as $image)
                        <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 group">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $umkm->nama }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Back Button -->
                <a href="{{ route('landing.umkm') }}" class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors duration-300 mb-6 text-center">
                    <i class='bx bx-left-arrow-alt text-xl'></i> Kembali ke UMKM
                </a>

                <!-- Related UMKM -->
                @if($relatedUmkm->count() > 0)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200">UMKM Lainnya</h3>
                    <div class="space-y-4">
                        @foreach($relatedUmkm as $related)
                        <a href="{{ route('landing.umkm.show', $related->id) }}" class="block group">
                            <div class="flex gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-300">
                                <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                    @if($related->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $related->images->first()->path) }}" alt="{{ $related->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <img src="{{ asset('assets/img/default-umkm.jpg') }}" alt="{{ $related->nama }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 line-clamp-2 text-sm mb-1 group-hover:text-blue-500 transition-colors">{{ $related->nama }}</h4>
                                    <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit(strip_tags($related->deskripsi), 50) }}</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Section -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 mt-6 text-white">
                    <h3 class="text-xl font-bold mb-3">Bagikan</h3>
                    <p class="text-sm mb-4 opacity-90">Beritahu teman tentang UMKM ini</p>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full transition-colors">
                            <i class='bx bxl-facebook text-xl'></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($umkm->nama) }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full transition-colors">
                            <i class='bx bxl-twitter text-xl'></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($umkm->nama . ' - ' . url()->current()) }}" target="_blank" class="flex items-center justify-center w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full transition-colors">
                            <i class='bx bxl-whatsapp text-xl'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
