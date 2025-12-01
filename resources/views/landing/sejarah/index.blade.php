@extends('layouts.landing')

@section('title', 'Desa Jenangan | Sejarah Desa')

@section('content')
<style>
    /* CKEditor Content Styling */
    .ckeditor-content ul {
        list-style-type: disc;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .ckeditor-content ol {
        list-style-type: decimal;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .ckeditor-content li {
        margin-bottom: 0.5rem;
    }
    .ckeditor-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .ckeditor-content table td,
    .ckeditor-content table th {
        border: 1px solid #ddd;
        padding: 0.5rem;
    }
    .ckeditor-content table th {
        background-color: #f3f4f6;
        font-weight: bold;
    }
    .ckeditor-content p {
        margin-bottom: 1rem;
    }
    .ckeditor-content h1, .ckeditor-content h2, .ckeditor-content h3,
    .ckeditor-content h4, .ckeditor-content h5, .ckeditor-content h6 {
        font-weight: bold;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .ckeditor-content h1 { font-size: 2rem; }
    .ckeditor-content h2 { font-size: 1.75rem; }
    .ckeditor-content h3 { font-size: 1.5rem; }
    .ckeditor-content h4 { font-size: 1.25rem; }
    .ckeditor-content strong { font-weight: bold; }
    .ckeditor-content em { font-style: italic; }
    .ckeditor-content u { text-decoration: underline; }
    .ckeditor-content a {
        color: #3b82f6;
        text-decoration: underline;
    }
    .ckeditor-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    .ckeditor-content blockquote {
        border-left: 4px solid #d1d5db;
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #6b7280;
    }
</style>
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
            <h1 class="text-white text-3xl md:text-5xl font-bold">Sejarah Desa</h1>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-6 md:px-16">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('landing.index') }}" class="hover:text-blue-500">Home</a>
                <span class="mx-2">/</span>
                <span class="text-blue-500 font-semibold">Sejarah Desa</span>
            </nav>
        </div>
    </div>

    <!-- Content Section -->
    @if($sejarah)
    <div class="container mx-auto px-4 py-8">
        <!-- Title Section -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">{{ $sejarah->judul }}</h2>
            @if($sejarah->subjudul)
            <p class="text-gray-600 mt-2">{{ $sejarah->subjudul }}</p>
            @endif
        </div>

        <!-- Image and Description Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Image -->
            <div>
                <img src="{{ Storage::url($sejarah->gambar) }}"
                     alt="{{ $sejarah->judul }}"
                     class="rounded-lg shadow-lg w-full h-auto object-cover">
            </div>

            <!-- Description -->
            <div>
                <div class="prose max-w-none ckeditor-content">
                    <div class="text-gray-700 leading-relaxed" style="text-align: justify;">
                        {!! $sejarah->deskripsi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="bg-white rounded-lg shadow-md p-8">
            <i class="fas fa-info-circle text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">Belum Ada Data</h3>
            <p class="text-gray-500">Informasi sejarah desa belum tersedia saat ini.</p>
        </div>
    </div>
    @endif
</div>
@endsection
