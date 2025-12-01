@extends('layouts.landing')

@section('title', 'Desa Jenangan | Sambutan Kepala Desa')

@section('content')
<div class="bg-gray-100">
    <!-- Hero Banner -->
    <div class="relative bg-cover bg-center h-64"
        style="background-image: url('{{ $heroBanner && $heroBanner->image ? Storage::url($heroBanner->image) : 'https://png.pngtree.com/background/20230519/original/pngtree-this-is-a-three-dimensional-image-of-a-campus-building-surrounded-picture-image_2652905.jpg' }}');
               background-size: cover;
               background-repeat: no-repeat;
               width: 100%;
               height: 300px;
               margin: 0 auto;">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-white text-3xl md:text-5xl font-bold">Sambutan Kepala Desa</h1>
        </div>
    </div>

    <!-- Content Section -->
    @if($sambutan)
    <div class="container mx-auto px-4 py-8">
        <!-- Title Section -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">{{ $sambutan->judul }}</h2>
            @if($sambutan->subjudul)
            <p class="text-gray-600 mt-2">{{ $sambutan->subjudul }}</p>
            @endif
        </div>

        <!-- Image and Description Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- Image -->
            <div>
                <img
                    src="{{ Storage::url($sambutan->gambar) }}"
                    alt="Foto Kepala Desa"
                    class="rounded-lg shadow-lg"
                    style="width: 600px; height: 400px; object-fit: cover;"
                >
            </div>

            <!-- Description -->
            <div>
                <div class="prose max-w-none">
                    <div class="text-gray-700 leading-relaxed" style="text-align: justify;">
                        {!! $sambutan->deskripsi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="bg-white rounded-lg shadow-md p-8">
            <i class="fas fa-user-tie text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">Belum Ada Data</h3>
            <p class="text-gray-500">Informasi sambutan kepala desa belum tersedia saat ini.</p>
        </div>
    </div>
    @endif
</div>
@endsection
