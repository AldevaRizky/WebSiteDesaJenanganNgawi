@extends('layouts.admin')
@section('title', 'Hero Banner')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Hero Banner</h4>
            @if(!$heroBanner)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHeroBannerModal">Tambah Data</button>
            @endif
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: "{{ session('success') }}",
                    });
                </script>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($heroBanner)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Gambar</th>
                                <td><img src="{{ Storage::url($heroBanner->image) }}" alt="Hero Banner Image" class="img-fluid" style="max-width: 200px;"></td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editHeroBannerModal">Edit</button>
                                    <form action="{{ route('hero_banner.destroy', $heroBanner->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p>Belum ada Hero Banner yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addHeroBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('hero_banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Hero Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="addHeroBannerImage" class="form-label">Gambar</label>
                            <input type="file" class="form-control hero-file-input" id="addHeroBannerImage" name="image" data-preview="addHeroBannerPreview" required accept="image/*">
                            <div class="mt-2">
                                <img id="addHeroBannerPreview" src="#" alt="Preview" class="img-fluid" style="max-width: 300px; display: none;" />
                            </div>
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

<!-- Modal Edit -->
@if ($heroBanner)
<div class="modal fade" id="editHeroBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('hero_banner.update', $heroBanner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hero Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editHeroBannerImage" class="form-label">Gambar</label>
                        <input type="file" class="form-control hero-file-input" id="editHeroBannerImage" name="image" data-preview="editHeroBannerPreview" accept="image/*">
                        <div class="mt-2">
                            <img id="editHeroBannerPreview" src="{{ Storage::url($heroBanner->image) }}" alt="Current Image" class="img-fluid" style="max-width: 300px;" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning me-2">Perbarui</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Save original src for edit preview
    var editPreview = document.getElementById('editHeroBannerPreview');
    if (editPreview) {
        editPreview.dataset.originalSrc = editPreview.src || '';
    }

    document.querySelectorAll('.hero-file-input').forEach(function (input) {
        input.addEventListener('change', function () {
            var previewId = input.dataset.preview;
            if (!previewId) return;
            var preview = document.getElementById(previewId);
            if (!preview) return;
            var file = input.files && input.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = '';
            } else {
                // revert for edit, hide for add
                if (preview.dataset.originalSrc) {
                    preview.src = preview.dataset.originalSrc;
                    preview.style.display = preview.dataset.originalSrc ? '' : 'none';
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            }
        });
    });

    // Reset add modal when closed
    var addModal = document.getElementById('addHeroBannerModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addHeroBannerPreview');
            var input = document.getElementById('addHeroBannerImage');
            if (preview) {
                preview.src = '#';
                preview.style.display = 'none';
            }
            if (input) input.value = '';
        });
    }
});
</script>

@endsection
