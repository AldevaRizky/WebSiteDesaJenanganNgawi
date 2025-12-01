@extends('layouts.landing')

@section('title', 'Desa Jenangan | Visi dan Misi')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen">
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
                    <h1 class="text-white text-3xl md:text-5xl font-bold">Visi dan Misi</h1>
                    <p class="text-white/80 mt-2">Desa Jenangan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    @if($visiMisi)
    <div class="container mx-auto px-4 py-16">
        <!-- Visi Section -->
        <div class="mb-16" data-aos="fade-up" data-aos-duration="1000">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl bg-gradient-to-br from-blue-500 to-blue-700 p-1">
                <div class="bg-white rounded-2xl p-8 md:p-12">
                    <div class="flex items-start mb-8">
                        <div class="relative">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-2xl w-20 h-20 flex items-center justify-center mr-6 shadow-lg transform hover:scale-110 transition-transform duration-300">
                                <i class='bx bx-bulb text-4xl'></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full w-8 h-8 flex items-center justify-center">01</div>
                        </div>
                        <div>
                            <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-2">VISI</h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-700 rounded-full"></div>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed text-lg md:text-xl" style="text-align: justify;">
                            {!! $visiMisi->visi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Misi Section -->
        <div class="mb-16" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl bg-gradient-to-br from-green-500 to-green-700 p-1">
                <div class="bg-white rounded-2xl p-8 md:p-12">
                    <div class="flex items-start mb-8">
                        <div class="relative">
                            <div class="bg-gradient-to-br from-green-500 to-green-700 text-white rounded-2xl w-20 h-20 flex items-center justify-center mr-6 shadow-lg transform hover:scale-110 transition-transform duration-300">
                                <i class='bx bx-target-lock text-4xl'></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold rounded-full w-8 h-8 flex items-center justify-center">02</div>
                        </div>
                        <div>
                            <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent mb-2">MISI</h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-700 rounded-full"></div>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed text-lg md:text-xl" style="text-align: justify;">
                            {!! $visiMisi->misi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tujuan Section -->
        <div class="mb-16" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="relative overflow-hidden rounded-2xl shadow-2xl bg-gradient-to-br from-orange-500 to-orange-700 p-1">
                <div class="bg-white rounded-2xl p-8 md:p-12">
                    <div class="flex items-start mb-8">
                        <div class="relative">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-700 text-white rounded-2xl w-20 h-20 flex items-center justify-center mr-6 shadow-lg transform hover:scale-110 transition-transform duration-300">
                                <i class='bx bx-flag text-4xl'></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full w-8 h-8 flex items-center justify-center">03</div>
                        </div>
                        <div>
                            <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent mb-2">TUJUAN</h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-700 rounded-full"></div>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <div class="text-gray-700 leading-relaxed text-lg md:text-xl" style="text-align: justify;">
                            {!! $visiMisi->tujuan !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="bg-white rounded-2xl shadow-xl p-12">
            <div class="bg-gray-100 rounded-full w-32 h-32 flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-clipboard text-gray-400 text-7xl'></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Data</h3>
            <p class="text-gray-500 text-lg">Informasi visi dan misi belum tersedia saat ini.</p>
        </div>
    </div>
    @endif
</div>
@endsection
