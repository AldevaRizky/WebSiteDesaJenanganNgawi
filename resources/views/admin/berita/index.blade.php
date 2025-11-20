@extends('layouts.admin')
@section('title', 'Berita Management')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Berita</h4>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                Tambah Berita
            </a>
        </div>

        <div class="card-body">

            {{-- Success Alert --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                    });
                </script>
            @endif

            {{-- Validation Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($beritas as $berita)
                        <tr>
                            <td>{{ $loop->iteration + ($beritas->currentPage() - 1) * $beritas->perPage() }}</td>
                            <td>{{ $berita->judul }}</td>
                            <td>
                                <span class="badge bg-info">{{ $berita->kategori->nama ?? '-' }}</span>
                            </td>
                            <td>{{ Str::limit($berita->deskripsi ?? '-', 50) }}</td>
                            <td>
                                @if($berita->images->count() > 0)
                                    <img src="{{ asset('storage/' . $berita->images->first()->path) }}" 
                                         alt="Image" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @if($berita->images->count() > 1)
                                        <small class="text-muted">+{{ $berita->images->count() - 1 }} lagi</small>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $berita->created_at->format('d M Y') }}</td>
                            <td>

                                {{-- View Detail Button --}}
                                <button class="btn btn-info btn-sm mb-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewModal{{ $berita->id }}">
                                    <i class="bi bi-eye"></i> Lihat
                                </button>

                                {{-- Edit --}}
                                <a href="{{ route('admin.berita.edit', $berita->id) }}" 
                                   class="btn btn-warning btn-sm mb-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-sm mb-1 btn-delete"
                                            data-id="{{ $berita->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>

                        {{-- View Modal --}}
                        <div class="modal fade" id="viewModal{{ $berita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Berita</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <strong>Judul:</strong>
                                            <p>{{ $berita->judul }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Kategori:</strong>
                                            <p>{{ $berita->kategori->nama ?? '-' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Deskripsi:</strong>
                                            <p>{{ $berita->deskripsi ?? '-' }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Konten:</strong>
                                            <div class="border p-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                                                {!! $berita->konten ?? '-' !!}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Gambar:</strong>
                                            <div class="row mt-2">
                                                @forelse($berita->images as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/' . $image->path) }}" 
                                                             alt="Image" 
                                                             class="img-fluid rounded"
                                                             style="width: 100%; height: 150px; object-fit: cover;">
                                                    </div>
                                                @empty
                                                    <p class="text-muted">Tidak ada gambar</p>
                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Tanggal Dibuat:</strong>
                                            <p>{{ $berita->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data berita</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $beritas->links() }}
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Delete confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data berita ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection
