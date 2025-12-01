@extends('layouts.landing')

@section('title', 'Infografis Data Penduduk - Website Desa Jenangan')

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
                <h1 class="text-white text-3xl md:text-5xl font-bold">Infografis Data Penduduk</h1>
                <p class="text-white/80 mt-2">Visualisasi Data Kependudukan Desa Jenangan</p>
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
            <span class="text-blue-500 font-semibold">Infografis</span>
        </nav>
    </div>
</div>

@if($data)
<!-- Statistics Cards Section -->
<section class="py-12 bg-gradient-to-b from-blue-50 to-white">
    <div class="container mx-auto px-6 md:px-16">
        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Penduduk -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-group text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">Total</p>
                        <p class="text-3xl font-bold">{{ number_format($data['total_penduduk']) }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Total Penduduk</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <!-- Kepala Keluarga -->
            <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-home-heart text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">KK</p>
                        <p class="text-3xl font-bold">{{ number_format($data['kepala_keluarga']) }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Kepala Keluarga</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ ($data['kepala_keluarga'] / $data['total_penduduk']) * 100 }}%"></div>
                </div>
            </div>

            <!-- Laki-laki -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-male text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">{{ $data['persentase_laki'] }}%</p>
                        <p class="text-3xl font-bold">{{ number_format($data['laki_laki']) }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Laki-laki</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ $data['persentase_laki'] }}%"></div>
                </div>
            </div>

            <!-- Perempuan -->
            <div class="bg-gradient-to-br from-pink-500 to-pink-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-female text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">{{ $data['persentase_perempuan'] }}%</p>
                        <p class="text-3xl font-bold">{{ number_format($data['perempuan']) }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Perempuan</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ $data['persentase_perempuan'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Gender Ratio Visualization -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Pie Chart Representation -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Rasio Jenis Kelamin</h3>
                <div class="flex items-center justify-center mb-6">
                    <div class="relative" style="width: 250px; height: 250px;">
                        <!-- Manual Pie Chart using conic-gradient -->
                        <div class="w-full h-full rounded-full" style="background: conic-gradient(
                            from 0deg,
                            #a855f7 0deg {{ $data['persentase_laki'] * 3.6 }}deg,
                            #ec4899 {{ $data['persentase_laki'] * 3.6 }}deg 360deg
                        );"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-white rounded-full w-32 h-32 flex items-center justify-center shadow-lg">
                                <div class="text-center">
                                    <p class="text-3xl font-bold text-gray-800">{{ $data['total_penduduk'] }}</p>
                                    <p class="text-xs text-gray-600">Jiwa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Laki-laki</span>
                        </div>
                        <span class="font-bold text-purple-700">{{ $data['persentase_laki'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-pink-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Perempuan</span>
                        </div>
                        <span class="font-bold text-pink-700">{{ $data['persentase_perempuan'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Bar Chart Representation -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Perbandingan Populasi</h3>
                <div class="space-y-6">
                    <!-- Laki-laki Bar -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i class='bx bx-male text-2xl text-purple-500 mr-2'></i>
                                <span class="font-semibold text-gray-700">Laki-laki</span>
                            </div>
                            <span class="font-bold text-purple-700">{{ number_format($data['laki_laki']) }}</span>
                        </div>
                        <div class="relative h-12 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full transition-all duration-1000 ease-out flex items-center justify-end px-4" style="width: {{ $data['persentase_laki'] }}%">
                                <span class="text-white font-bold text-sm">{{ $data['persentase_laki'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Perempuan Bar -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i class='bx bx-female text-2xl text-pink-500 mr-2'></i>
                                <span class="font-semibold text-gray-700">Perempuan</span>
                            </div>
                            <span class="font-bold text-pink-700">{{ number_format($data['perempuan']) }}</span>
                        </div>
                        <div class="relative h-12 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full transition-all duration-1000 ease-out flex items-center justify-end px-4" style="width: {{ $data['persentase_perempuan'] }}%">
                                <span class="text-white font-bold text-sm">{{ $data['persentase_perempuan'] }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Bar -->
                    <div class="pt-4 border-t-2 border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i class='bx bx-group text-2xl text-blue-500 mr-2'></i>
                                <span class="font-semibold text-gray-700">Total Penduduk</span>
                            </div>
                            <span class="font-bold text-blue-700">{{ number_format($data['total_penduduk']) }}</span>
                        </div>
                        <div class="relative h-12 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-end px-4" style="width: 100%">
                                <span class="text-white font-bold text-sm">100%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Rata-rata Anggota Keluarga -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border-t-4 border-orange-500">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 rounded-full p-3 mr-4">
                        <i class='bx bx-group text-3xl text-orange-500'></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Rata-rata</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['rata_anggota_keluarga'] }}</p>
                    </div>
                </div>
                <p class="text-gray-700 font-semibold">Anggota per Keluarga</p>
                <p class="text-gray-500 text-sm mt-2">Rata-rata jumlah anggota dalam satu keluarga</p>
            </div>

            <!-- Sex Ratio -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border-t-4 border-indigo-500">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-full p-3 mr-4">
                        <i class='bx bx-bar-chart-alt text-3xl text-indigo-500'></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Sex Ratio</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['laki_laki'] > 0 ? round(($data['laki_laki'] / $data['perempuan']) * 100, 1) : 0 }}</p>
                    </div>
                </div>
                <p class="text-gray-700 font-semibold">Rasio Jenis Kelamin</p>
                <p class="text-gray-500 text-sm mt-2">Perbandingan laki-laki per 100 perempuan</p>
            </div>

            <!-- Density Info -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border-t-4 border-teal-500">
                <div class="flex items-center mb-4">
                    <div class="bg-teal-100 rounded-full p-3 mr-4">
                        <i class='bx bx-home-smile text-3xl text-teal-500'></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total KK</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($data['kepala_keluarga']) }}</p>
                    </div>
                </div>
                <p class="text-gray-700 font-semibold">Kepala Keluarga</p>
                <p class="text-gray-500 text-sm mt-2">Jumlah kepala keluarga di desa</p>
            </div>
        </div>

        <!-- Visual Representation with Icons -->
        <div class="mt-12 bg-white rounded-2xl shadow-xl p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Visualisasi Penduduk</h3>
            <p class="text-gray-600 text-center mb-8">Setiap ikon mewakili persentase dari total penduduk</p>
            <div class="flex flex-wrap justify-center gap-2">
                @for($i = 0; $i < 50; $i++)
                    @if($i < ($data['persentase_laki'] / 2))
                        <i class='bx bx-male text-3xl text-purple-500' title="Laki-laki"></i>
                    @else
                        <i class='bx bx-female text-3xl text-pink-500' title="Perempuan"></i>
                    @endif
                @endfor
            </div>
            <div class="flex justify-center gap-8 mt-6">
                <div class="flex items-center">
                    <i class='bx bx-male text-2xl text-purple-500 mr-2'></i>
                    <span class="text-gray-700">= {{ $data['persentase_laki'] }}% Laki-laki</span>
                </div>
                <div class="flex items-center">
                    <i class='bx bx-female text-2xl text-pink-500 mr-2'></i>
                    <span class="text-gray-700">= {{ $data['persentase_perempuan'] }}% Perempuan</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Data Stunting Section -->
@if($stuntingStats)
<section class="py-12 bg-white">
    <div class="container mx-auto px-6 md:px-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Data Stunting Anak</h2>
            <div class="w-16 h-1 bg-red-500 mx-auto mb-4"></div>
            <p class="text-gray-600">Monitoring Status Gizi dan Pertumbuhan Anak</p>
        </div>

        <!-- Stunting Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Anak -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-child text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">Total</p>
                        <p class="text-3xl font-bold">{{ $stuntingStats['total'] }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Total Anak</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <!-- Normal -->
            <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-check-circle text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">{{ $stuntingStats['persentase_normal'] }}%</p>
                        <p class="text-3xl font-bold">{{ $stuntingStats['normal'] }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Status Normal</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ $stuntingStats['persentase_normal'] }}%"></div>
                </div>
            </div>

            <!-- Stunting -->
            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-error-circle text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">{{ $stuntingStats['persentase_stunting'] }}%</p>
                        <p class="text-3xl font-bold">{{ $stuntingStats['stunting'] }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Stunting</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ $stuntingStats['persentase_stunting'] }}%"></div>
                </div>
            </div>

            <!-- Stunting Berat -->
            <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class='bx bx-x-circle text-4xl'></i>
                    </div>
                    <div class="text-right">
                        <p class="text-white/80 text-sm font-medium">{{ $stuntingStats['persentase_severely_stunting'] }}%</p>
                        <p class="text-3xl font-bold">{{ $stuntingStats['severely_stunting'] }}</p>
                    </div>
                </div>
                <p class="text-white/90 font-semibold">Stunting Berat</p>
                <div class="mt-2 h-1 bg-white/30 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full" style="width: {{ $stuntingStats['persentase_severely_stunting'] }}%"></div>
                </div>
            </div>
        </div>

        <!-- Stunting Chart Visualization -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Donut Chart -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Distribusi Status Gizi</h3>
                <div class="flex items-center justify-center mb-6">
                    <div class="relative" style="width: 250px; height: 250px;">
                        @php
                            $normalDeg = $stuntingStats['persentase_normal'] * 3.6;
                            $stuntingDeg = $stuntingStats['persentase_stunting'] * 3.6;
                            $severelyDeg = $stuntingStats['persentase_severely_stunting'] * 3.6;
                            $tinggiDeg = $stuntingStats['persentase_tinggi'] * 3.6;

                            $start1 = 0;
                            $end1 = $normalDeg;
                            $start2 = $end1;
                            $end2 = $start2 + $stuntingDeg;
                            $start3 = $end2;
                            $end3 = $start3 + $severelyDeg;
                            $start4 = $end3;
                            $end4 = 360;
                        @endphp
                        <div class="w-full h-full rounded-full" style="background: conic-gradient(
                            from 0deg,
                            #10b981 {{ $start1 }}deg {{ $end1 }}deg,
                            #f59e0b {{ $start2 }}deg {{ $end2 }}deg,
                            #ef4444 {{ $start3 }}deg {{ $end3 }}deg,
                            #3b82f6 {{ $start4 }}deg {{ $end4 }}deg
                        );"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-white rounded-full w-32 h-32 flex items-center justify-center shadow-lg">
                                <div class="text-center">
                                    <p class="text-3xl font-bold text-gray-800">{{ $stuntingStats['total'] }}</p>
                                    <p class="text-xs text-gray-600">Anak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Normal</span>
                        </div>
                        <span class="font-bold text-green-700">{{ $stuntingStats['persentase_normal'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Stunting</span>
                        </div>
                        <span class="font-bold text-yellow-700">{{ $stuntingStats['persentase_stunting'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Stunting Berat</span>
                        </div>
                        <span class="font-bold text-red-700">{{ $stuntingStats['persentase_severely_stunting'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                            <span class="font-semibold text-gray-700">Tinggi</span>
                        </div>
                        <span class="font-bold text-blue-700">{{ $stuntingStats['persentase_tinggi'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Average Measurements -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Rata-rata Pengukuran</h3>
                <div class="space-y-6">
                    <!-- Tinggi Badan -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i class='bx bx-ruler text-2xl text-blue-500 mr-2'></i>
                                <span class="font-semibold text-gray-700">Tinggi Badan</span>
                            </div>
                            <span class="font-bold text-blue-700">{{ $stuntingStats['rata_tinggi_badan'] }} cm</span>
                        </div>
                        <div class="relative h-8 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-end px-4" style="width: {{ min(($stuntingStats['rata_tinggi_badan'] / 120) * 100, 100) }}%">
                                <span class="text-white font-bold text-xs">{{ $stuntingStats['rata_tinggi_badan'] }} cm</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Rata-rata tinggi badan anak</p>
                    </div>

                    <!-- Berat Badan -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i class='bx bx-dumbbell text-2xl text-green-500 mr-2'></i>
                                <span class="font-semibold text-gray-700">Berat Badan</span>
                            </div>
                            <span class="font-bold text-green-700">{{ $stuntingStats['rata_berat_badan'] }} kg</span>
                        </div>
                        <div class="relative h-8 bg-gray-200 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-end px-4" style="width: {{ min(($stuntingStats['rata_berat_badan'] / 25) * 100, 100) }}%">
                                <span class="text-white font-bold text-xs">{{ $stuntingStats['rata_berat_badan'] }} kg</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Rata-rata berat badan anak</p>
                    </div>

                    <!-- Info Cards -->
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border-l-4 border-purple-500">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-trending-up text-2xl text-purple-600 mr-2'></i>
                                <p class="text-xs text-gray-600">Total Data</p>
                            </div>
                            <p class="text-2xl font-bold text-purple-700">{{ $stuntingStats['total'] }}</p>
                            <p class="text-xs text-gray-600 mt-1">Pengukuran</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-4 border-l-4 border-indigo-500">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-heart text-2xl text-indigo-600 mr-2'></i>
                                <p class="text-xs text-gray-600">Tinggi</p>
                            </div>
                            <p class="text-2xl font-bold text-indigo-700">{{ $stuntingStats['tinggi'] }}</p>
                            <p class="text-xs text-gray-600 mt-1">Anak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Info -->
        <div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-3xl text-orange-500 mr-4 mt-1'></i>
                <div>
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Tentang Stunting</h4>
                    <p class="text-gray-700 mb-2">Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis, terutama pada 1.000 hari pertama kehidupan.</p>
                    <p class="text-gray-700">Data ini penting untuk memantau status gizi anak dan melakukan intervensi dini untuk mencegah stunting.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@else
<!-- No Data Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6 md:px-16">
        <div class="text-center">
            <i class='bx bx-data' style="font-size: 100px; color: #cbd5e1;"></i>
            <h3 class="text-gray-500 text-2xl font-semibold mt-6">Belum Ada Data</h3>
            <p class="text-gray-400 mt-3">Data infografis penduduk akan ditampilkan di sini ketika sudah tersedia.</p>
            <a href="{{ route('landing.index') }}" class="inline-block mt-6 bg-blue-500 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-600 transition duration-300">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>
@endif

@endsection
