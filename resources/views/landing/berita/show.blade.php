@extends('layouts.landing')

@section('title', $berita->judul . ' - Website Desa Jenangan')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Hero Banner -->
    <div class="relative bg-cover bg-center h-64"
    style="background-image: url('{{ $heroBanner && $heroBanner->image ? Storage::url($heroBanner->image) : asset('assets/img/hero-default.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            height: 300px;">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-white text-3xl md:text-5xl font-bold text-center px-4">Detail Berita</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6">
                <a href="{{ route('landing.index') }}" class="text-blue-500 hover:underline">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('landing.berita') }}" class="text-blue-500 hover:underline">Berita</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ Str::limit($berita->judul, 50) }}</span>
            </nav>

            <!-- Main Content -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Featured Image -->
                @if($berita->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $berita->images->first()->path) }}" alt="{{ $berita->judul }}" class="w-full h-96 object-cover">
                @endif

                <div class="p-8">
                    <!-- Category & Date -->
                    <div class="flex items-center justify-between mb-4 text-sm">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full">{{ $berita->kategori->nama ?? 'Umum' }}</span>
                        <span class="text-gray-500">{{ $berita->created_at->format('d F Y') }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $berita->judul }}</h1>

                    <!-- Description -->
                    @if($berita->deskripsi)
                    <p class="text-gray-600 text-lg mb-6 italic border-l-4 border-blue-500 pl-4">{{ $berita->deskripsi }}</p>
                    @endif

                    <!-- Content from CKEditor -->
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        {!! $berita->konten !!}
                    </div>

                    <!-- Image Gallery (if multiple images) -->
                    @if($berita->images->count() > 1)
                    <div class="mt-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Galeri Foto</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($berita->images->skip(1) as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Gallery Image" class="w-full h-48 object-cover rounded-lg shadow hover:scale-105 transition-transform duration-300 cursor-pointer">
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Back Button -->
                    <div class="mt-8 pt-6 border-t">
                        <a href="{{ route('landing.berita') }}" class="inline-flex items-center text-blue-500 hover:text-blue-700 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Berita
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related News (Optional) -->
            @if($relatedBerita->count() > 0)
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBerita as $related)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300">
                        @if($related->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $related->images->first()->path) }}" alt="{{ $related->judul }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">{{ Str::limit($related->judul, 60) }}</h4>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($related->deskripsi, 80) }}</p>
                            <a href="{{ route('landing.detail-berita', $related->slug) }}" class="text-blue-500 text-sm font-bold hover:underline">Baca Selengkapnya &gt;&gt;</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add custom styles for CKEditor content -->
<style>
    .prose img {
        max-width: 100%;
        height: auto;
        margin: 1.5rem auto;
        border-radius: 0.5rem;
    }
    .prose p {
        margin-bottom: 1rem;
        line-height: 1.8;
    }
    .prose h2 {
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1f2937;
    }
    .prose h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #374151;
    }
    .prose ul, .prose ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .prose li {
        margin-bottom: 0.5rem;
    }
    .prose a {
        color: #3b82f6;
        text-decoration: underline;
    }
    .prose blockquote {
        border-left: 4px solid #3b82f6;
        padding-left: 1rem;
        font-style: italic;
        color: #6b7280;
        margin: 1.5rem 0;
    }
    .prose table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }
    .prose th, .prose td {
        border: 1px solid #e5e7eb;
        padding: 0.75rem;
        text-align: left;
    }
    .prose th {
        background-color: #f3f4f6;
        font-weight: 600;
    }
</style>
@endsection
