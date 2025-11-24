@extends('layouts.landing')

@section('title', 'Website Desa Jenangan | Berita')

@section('content')
    <div class="bg-gray-100">
        <div class="relative bg-cover bg-center h-64"
        style="background-image: url('{{ $heroBanner && $heroBanner->image ? Storage::url($heroBanner->image) : asset('assets/img/hero-default.jpg') }}');
                background-size: cover;
                background-repeat: no-repeat;
                width: 100%;
                height: 300px;
                margin: 0 auto;">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <h1 class="text-white text-3xl md:text-5xl font-bold">Berita Terbaru</h1>
        </div>
    </div>

    <div class="container mx-auto">
        <h2 class="text-4xl font-bold text-gray-800 text-center mt-8 mb-6">Berita Terbaru</h2>
        <div class="w-16 h-1 bg-blue-500 mx-auto mb-8"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 md:px-16 mb-10">
            @forelse($berita as $item)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300 flex flex-col h-full">
                @if($item->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->images->first()->path) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('assets/img/default-news.jpg') }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-xs text-blue-500 font-semibold mb-2 inline-block px-3 py-1 border-2 border-blue-500 rounded-full self-start break-words">{{ $item->kategori->nama ?? 'Umum' }}</span>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3 text-center line-clamp-2 min-h-[3.5rem] break-words overflow-hidden">{{ $item->judul }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow break-words overflow-hidden">{{ $item->deskripsi }}</p>
                    <div class="flex justify-between items-center mt-auto gap-2">
                        <a href="{{ route('landing.detail-berita', $item->slug) }}" class="text-blue-500 font-bold hover:underline text-sm">Read More &gt;&gt;</a>
                        <span class="text-gray-400 text-xs whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($berita->hasPages())
        <div class="flex justify-center mb-10">
            {{ $berita->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
