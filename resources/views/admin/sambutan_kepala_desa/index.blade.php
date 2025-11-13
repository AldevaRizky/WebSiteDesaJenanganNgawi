@extends('layouts.admin')
@section('title', 'Sambutan Kepala Desa')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Sambutan Kepala Desa</h4>
            @if(!$sambutan)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSambutanModal">Tambah Data</button>
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

            @if ($sambutan)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $sambutan->judul }}</td>
                            </tr>
                            <tr>
                                <th>Subjudul</th>
                                <td>{{ $sambutan->subjudul }}</td>
                            </tr>
                            <tr>
                                <th>Gambar</th>
                                <td><img src="{{ Storage::url($sambutan->gambar) }}" alt="Gambar" class="img-fluid" style="max-width: 200px;"></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $sambutan->deskripsi }}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSambutanModal">Edit</button>
                                    <form action="{{ route('admin.sambutan_kepala_desa.destroy', $sambutan->id) }}" method="POST" class="d-inline delete-form">
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
                <p>Belum ada data sambutan yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addSambutanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.sambutan_kepala_desa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sambutan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjudul" class="form-label">Subjudul</label>
                        <input type="text" class="form-control" id="subjudul" name="subjudul">
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control sambutan-file-input" id="addSambutanGambar" name="gambar" data-preview="addSambutanPreview" required accept="image/*">
                        <div class="mt-2">
                            <img id="addSambutanPreview" src="#" alt="Preview" class="img-fluid" style="max-width: 300px; display: none;" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
@if ($sambutan)
<div class="modal fade" id="editSambutanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.sambutan_kepala_desa.update', $sambutan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sambutan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $sambutan->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="subjudul" class="form-label">Subjudul</label>
                        <input type="text" class="form-control" id="subjudul" name="subjudul" value="{{ $sambutan->subjudul }}">
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control sambutan-file-input" id="editSambutanGambar" name="gambar" data-preview="editSambutanPreview" accept="image/*">
                        <div class="mt-2">
                            <img id="editSambutanPreview" src="{{ Storage::url($sambutan->gambar) }}" alt="Current Image" class="img-fluid" style="max-width: 300px;" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $sambutan->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning me-2">Perbarui</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editPreview = document.getElementById('editSambutanPreview');
    if (editPreview) editPreview.dataset.originalSrc = editPreview.src || '';

    document.querySelectorAll('.sambutan-file-input').forEach(function (input) {
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

    var addModal = document.getElementById('addSambutanModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addSambutanPreview');
            var input = document.getElementById('addSambutanGambar');
            if (preview) { preview.src = '#'; preview.style.display = 'none'; }
            if (input) input.value = '';
        });
    }
});
</script>

@endsection
