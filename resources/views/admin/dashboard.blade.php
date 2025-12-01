@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="fw-bold mb-1">Dashboard</h4>
      <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-primary p-2 rounded mb-2">
                <i class='bx bx-news bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_berita'] }}</h3>
              <p class="mb-0 text-muted">Total Berita</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-success p-2 rounded mb-2">
                <i class='bx bx-store bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_umkm'] }}</h3>
              <p class="mb-0 text-muted">Total UMKM</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-warning p-2 rounded mb-2">
                <i class='bx bx-user-check bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_perangkat'] }}</h3>
              <p class="mb-0 text-muted">Perangkat Desa</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-danger p-2 rounded mb-2">
                <i class='bx bx-envelope bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_pesan'] }}</h3>
              <p class="mb-0 text-muted">Total Pesan</p>
              @if($stats['pesan_unread'] > 0)
                <small class="text-danger fw-bold">{{ $stats['pesan_unread'] }} pesan baru</small>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Additional Statistics Cards -->
  <div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-info p-2 rounded mb-2">
                <i class='bx bx-health bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_stunting'] }}</h3>
              <p class="mb-0 text-muted">Data Stunting</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-dark p-2 rounded mb-2">
                <i class='bx bx-video bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stats['total_videos'] }}</h3>
              <p class="mb-0 text-muted">Video YouTube</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-success p-2 rounded mb-2">
                <i class='bx bx-check-circle bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stuntingStats['normal'] }}</h3>
              <p class="mb-0 text-muted">Gizi Normal</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <span class="badge bg-label-warning p-2 rounded mb-2">
                <i class='bx bx-error-circle bx-sm'></i>
              </span>
              <h3 class="mb-1 mt-2">{{ $stuntingStats['stunting'] + $stuntingStats['severely_stunting'] }}</h3>
              <p class="mb-0 text-muted">Stunting Total</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Data Penduduk & Charts -->
  <div class="row g-4 mb-4">
    <div class="col-xl-6 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Quick Stats</h5>
          <i class='bx bx-stats bx-sm text-muted'></i>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <li class="mb-3 d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary"><i class='bx bx-user'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Total Users</h6>
                  <small class="text-muted">Admin & Staff</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">{{ $stats['total_users'] }}</h6>
                </div>
              </div>
            </li>
            <li class="mb-3 d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-success"><i class='bx bx-trending-up'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Berita Bulan Ini</h6>
                  <small class="text-muted">{{ now()->format('F Y') }}</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">{{ \App\Models\Berita::whereMonth('created_at', now()->month)->count() }}</h6>
                </div>
              </div>
            </li>
            <li class="mb-3 d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-calendar-check'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">Pesan Minggu Ini</h6>
                  <small class="text-muted">7 hari terakhir</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                  <h6 class="mb-0">{{ $stats['pesan_unread'] }}</h6>
                </div>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-info"><i class='bx bx-calendar-event'></i></span>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-0">{{ now()->isoFormat('dddd') }}</h6>
                  <small class="text-muted">{{ now()->isoFormat('D MMMM Y') }}</small>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    @if($dataPenduduk)
    <div class="col-xl-6 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Data Penduduk</h5>
          <i class='bx bx-group bx-sm text-muted'></i>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Total Penduduk</span>
              <span class="fw-bold">{{ number_format($dataPenduduk->total_penduduk) }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-primary" style="width: 100%"></div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Kepala Keluarga</span>
              <span class="fw-bold">{{ number_format($dataPenduduk->kepala_keluarga) }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-success" style="width: {{ ($dataPenduduk->kepala_keluarga / $dataPenduduk->total_penduduk) * 100 }}%"></div>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Laki-laki</span>
              <span class="fw-bold">{{ number_format($dataPenduduk->laki_laki) }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-info" style="width: {{ ($dataPenduduk->laki_laki / $dataPenduduk->total_penduduk) * 100 }}%"></div>
            </div>
          </div>
          <div>
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted">Perempuan</span>
              <span class="fw-bold">{{ number_format($dataPenduduk->perempuan) }}</span>
            </div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-warning" style="width: {{ ($dataPenduduk->perempuan / $dataPenduduk->total_penduduk) * 100 }}%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>

  <!-- Charts Row -->
  <div class="row g-4 mb-4">
    <div class="col-xl-6 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Berita per Kategori</h5>
          <i class='bx bx-bar-chart-alt-2 bx-sm text-muted'></i>
        </div>
        <div class="card-body">
          <canvas id="beritaKategoriChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Status Gizi Anak</h5>
          <i class='bx bx-pie-chart-alt-2 bx-sm text-muted'></i>
        </div>
        <div class="card-body">
          <canvas id="stuntingChart" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activity -->
  <div class="row g-4 mb-4">
    <div class="col-xl-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Data Stunting Terbaru</h5>
          <a href="{{ route('admin.data_stunting.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
          @if($recentStunting->count() > 0)
            <ul class="list-unstyled mb-0">
              @foreach($recentStunting as $stunting)
              <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded-circle bg-label-{{ $stunting->status_color }}">
                      <i class='bx bx-child'></i>
                    </span>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $stunting->nama_anak }}</h6>
                    <small class="text-muted d-block mb-1">
                      <span class="badge bg-{{ $stunting->status_color }}">{{ $stunting->status_label }}</span>
                    </small>
                    <small class="text-muted">TB: {{ $stunting->tinggi_badan_cm }} cm | BB: {{ $stunting->berat_badan }} kg</small>
                    <br>
                    <small class="text-muted">{{ $stunting->tanggal_pengukuran->format('d M Y') }}</small>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          @else
            <div class="text-center py-4">
              <i class='bx bx-health bx-lg text-muted mb-2'></i>
              <p class="text-muted mb-0">Belum ada data stunting</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Video Terbaru</h5>
          <a href="{{ route('admin.videos.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
          @if($recentVideos->count() > 0)
            <ul class="list-unstyled mb-0">
              @foreach($recentVideos as $video)
              <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-dark">
                      <i class='bx bx-video'></i>
                    </span>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ Str::limit($video->judul, 40) }}</h6>
                    <small class="text-muted d-block mb-1">
                      <a href="{{ $video->link_youtube }}" target="_blank" class="text-primary">
                        <i class='bx bx-link-external'></i> Lihat Video
                      </a>
                    </small>
                    <small class="text-muted">{{ $video->created_at->diffForHumans() }}</small>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          @else
            <div class="text-center py-4">
              <i class='bx bx-video-off bx-lg text-muted mb-2'></i>
              <p class="text-muted mb-0">Belum ada video</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Berita Terbaru</h5>
          <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
          @if($recentBerita->count() > 0)
            <ul class="list-unstyled mb-0">
              @foreach($recentBerita as $berita)
              <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                  @if($berita->images->first())
                    <img src="{{ asset('storage/'.$berita->images->first()->path) }}" alt="{{ $berita->judul }}" class="rounded me-3" style="width:60px;height:60px;object-fit:cover;">
                  @else
                    <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                      <i class='bx bx-image text-muted'></i>
                    </div>
                  @endif
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ Str::limit($berita->judul, 50) }}</h6>
                    <small class="text-muted d-block mb-1">
                      <span class="badge bg-label-primary">{{ $berita->kategori->nama ?? 'Uncategorized' }}</span>
                    </small>
                    <small class="text-muted">{{ $berita->created_at->diffForHumans() }}</small>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          @else
            <div class="text-center py-4">
              <i class='bx bx-news bx-lg text-muted mb-2'></i>
              <p class="text-muted mb-0">Belum ada berita</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Messages Section -->
  <div class="row g-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Pesan Terbaru</h5>
          <a href="{{ route('admin.pesans.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
          @if($recentPesan->count() > 0)
            <ul class="list-unstyled mb-0">
              @foreach($recentPesan as $pesan)
              <li class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div class="d-flex align-items-start">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded-circle bg-label-info">{{ substr($pesan->nama, 0, 1) }}</span>
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $pesan->nama }}</h6>
                    <small class="text-muted d-block mb-1">{{ $pesan->email }}</small>
                    <p class="mb-1 small">{{ Str::limit($pesan->message, 80) }}</p>
                    <small class="text-muted">{{ $pesan->created_at->diffForHumans() }}</small>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          @else
            <div class="text-center py-4">
              <i class='bx bx-envelope bx-lg text-muted mb-2'></i>
              <p class="text-muted mb-0">Belum ada pesan</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Berita per Kategori Chart (Doughnut)
    const beritaKategoriCtx = document.getElementById('beritaKategoriChart');
    if (beritaKategoriCtx) {
        const beritaData = {!! json_encode($beritaPerKategori) !!};

        new Chart(beritaKategoriCtx, {
            type: 'doughnut',
            data: {
                labels: beritaData.map(item => item.nama),
                datasets: [{
                    data: beritaData.map(item => item.total),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    }

    // Stunting Status Chart (Pie)
    const stuntingCtx = document.getElementById('stuntingChart');
    if (stuntingCtx) {
        const stuntingData = {!! json_encode($stuntingStats) !!};

        new Chart(stuntingCtx, {
            type: 'pie',
            data: {
                labels: ['Normal', 'Stunting', 'Stunting Berat', 'Tinggi'],
                datasets: [{
                    data: [
                        stuntingData.normal,
                        stuntingData.stunting,
                        stuntingData.severely_stunting,
                        stuntingData.tinggi
                    ],
                    backgroundColor: [
                        'rgba(40, 199, 111, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(234, 84, 85, 0.8)',
                        'rgba(3, 169, 244, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
