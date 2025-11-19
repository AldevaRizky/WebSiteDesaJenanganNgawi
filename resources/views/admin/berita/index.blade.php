@extends('layouts.admin')
@section('title', 'Berita Management')

@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Berita</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                Tambah Berita
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

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($beritas as $berita)
                        <tr>
                            <td>{{ $loop->iteration + ($beritas->currentPage() - 1) * $beritas->perPage() }}</td>
                            <td>
                                @if($berita->images->first())
                                    <img src="{{ asset('storage/' . $berita->images->first()->path) }}" 
                                         alt="thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($berita->judul, 50) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit(strip_tags($berita->deskripsi), 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $berita->kategori->nama }}</span>
                            </td>
                            <td>{{ $berita->created_at->format('d M Y') }}</td>
                            <td>
                                {{-- Edit Button --}}
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBeritaModal{{ $berita->id }}">
                                    Edit
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-delete"
                                            data-id="{{ $berita->id }}">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Modal for Each Berita --}}
                        <div class="modal fade" id="editBeritaModal{{ $berita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                <select name="kategori_id" class="form-select" required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($kategoris as $kategori)
                                                        <option value="{{ $kategori->id }}" 
                                                            {{ $berita->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                            {{ $kategori->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="judul" 
                                                       value="{{ $berita->judul }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi Singkat</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $berita->deskripsi }}</textarea>
                                                <small class="text-muted">Ringkasan berita yang akan ditampilkan di list</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Konten Berita</label>
                                                <textarea name="konten" class="tinymce-editor">{{ $berita->konten }}</textarea>
                                            </div>

                                            {{-- Existing Images --}}
                                            @if($berita->images->count() > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Gambar Saat Ini</label>
                                                <div class="d-flex flex-wrap gap-2" id="existingImages{{ $berita->id }}">
                                                    @foreach($berita->images as $image)
                                                    <div class="position-relative image-preview-item" data-image-id="{{ $image->id }}">
                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image">
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-existing-image"
                                                                data-image-id="{{ $image->id }}"
                                                                style="padding: 2px 6px; font-size: 12px;">
                                                            ×
                                                        </button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            <div class="mb-3">
                                                <label class="form-label">Tambah Gambar Baru</label>
                                                <input type="file" class="form-control image-input" 
                                                       name="images[]" multiple accept="image/*" 
                                                       data-preview="imagePreviewEdit{{ $berita->id }}">
                                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB per gambar</small>
                                                
                                                <div id="imagePreviewEdit{{ $berita->id }}" class="mt-3 d-flex flex-wrap gap-2"></div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning me-2">Perbarui</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach

                        @if($beritas->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data berita</td>
                        </tr>
                        @endif
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

{{-- Add Modal --}}
<div class="modal fade" id="addBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        <small class="text-muted">Ringkasan berita yang akan ditampilkan di list</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten Berita</label>
                        <textarea name="konten" id="kontenAdd" class="tinymce-editor"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Gambar (Multiple)</label>
                        <input type="file" class="form-control image-input" name="images[]" 
                               multiple accept="image/*" data-preview="imagePreviewAdd">
                        <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB per gambar</small>
                        
                        <div id="imagePreviewAdd" class="mt-3 d-flex flex-wrap gap-2"></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .image-preview-item {
        position: relative;
        width: 100px;
        height: 100px;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
        border: 2px solid #ddd;
    }
</style>
@endpush

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Initialize TinyMCE for all textareas with class tinymce-editor
    document.addEventListener('DOMContentLoaded', function() {
        
        // Initialize for Add Modal
        tinymce.init({
            selector: '#kontenAdd',
            height: 300,
            plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | link media table | align lineheight | numlist bullist indent outdent | removeformat',
            menubar: false,
            content_style: 'body { font-family:Arial,sans-serif; font-size:14px }',
        });

        // Initialize for Edit Modals when modal is shown
        document.querySelectorAll('[id^="editBeritaModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const textarea = this.querySelector('.tinymce-editor');
                if (textarea && !tinymce.get(textarea.id)) {
                    const uniqueId = 'tinymce_' + Math.random().toString(36).substr(2, 9);
                    textarea.id = uniqueId;
                    
                    tinymce.init({
                        selector: '#' + uniqueId,
                        height: 300,
                        plugins: 'anchor autolink charmap codesample emoticons link lists media searchreplace table visualblocks wordcount',
                        toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | link media table | align lineheight | numlist bullist indent outdent | removeformat',
                        menubar: false,
                        content_style: 'body { font-family:Arial,sans-serif; font-size:14px }',
                    });
                }
            });
        });

    });

    // Image Preview Handler
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.getAttribute('data-preview');
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            
            const files = Array.from(e.target.files);
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'image-preview-item';
                        div.innerHTML = `<img src="${e.target.result}" alt="Preview ${index + 1}">`;
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });

    // Delete Confirmation for Berita
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data berita dan semua gambarnya akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });

    // Delete Existing Image
    document.querySelectorAll('.delete-existing-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            
            Swal.fire({
                title: 'Hapus gambar?',
                text: "Gambar akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/berita/image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            document.querySelector(`[data-image-id="${imageId}"]`).remove();
                            Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus gambar.', 'error');
                    });
                }
            });
        });
    });

    // Re-open modal if validation error
    @if ($errors->any())
        @if(old('_method') == 'PUT')
            // Edit modal - you need to determine which one
        @else
            // Add modal
            var addModal = new bootstrap.Modal(document.getElementById('addBeritaModal'));
            addModal.show();
        @endif
    @endif
</script>
@endpush