@extends('layouts.admin')
@section('title', 'Video Management')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Video YouTube</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                Tambah Video
            </button>
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

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Link YouTube</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $video)
                        <tr>
                            <td>{{ $loop->iteration + ($videos->currentPage() - 1) * $videos->perPage() }}</td>
                            <td>{{ $video->judul }}</td>
                            <td>
                                <a href="{{ $video->link_youtube }}" target="_blank" class="text-primary">
                                    <i class="bx bx-link-external me-1"></i>{{ Str::limit($video->link_youtube, 50) }}
                                </a>
                            </td>
                            <td>{{ $video->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $video->id }}">Lihat</button>
                                <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->id }}">Edit</button>

                                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm mb-1 btn-delete" data-id="{{ $video->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data video</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $videos->links() }}
            </div>

        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Kegiatan Posyandu Desa Jenangan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link YouTube <span class="text-danger">*</span></label>
                        <input type="url" name="link_youtube" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                        <small class="text-muted">Masukkan URL lengkap video YouTube</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modals per Video (view + edit) --}}
@foreach($videos as $video)
    {{-- View Modal --}}
    <div class="modal fade" id="viewModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><strong>Judul:</strong><p>{{ $video->judul }}</p></div>
                    <div class="mb-3"><strong>Link YouTube:</strong><p><a href="{{ $video->link_youtube }}" target="_blank" class="text-primary">{{ $video->link_youtube }}</a></p></div>
                    <div class="mb-3"><strong>Tanggal Ditambahkan:</strong><p>{{ $video->created_at->format('d M Y H:i') }}</p></div>
                    @php
                        // Extract YouTube video ID
                        $videoId = null;
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->link_youtube, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <div class="mb-3">
                            <strong>Preview:</strong>
                            <div class="ratio ratio-16x9 mt-2">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Video <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul', $video->judul) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link YouTube <span class="text-danger">*</span></label>
                            <input type="url" name="link_youtube" class="form-control" value="{{ old('link_youtube', $video->link_youtube) }}" placeholder="https://www.youtube.com/watch?v=..." required>
                            <small class="text-muted">Masukkan URL lengkap video YouTube</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    // SweetAlert Delete Confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Video ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
