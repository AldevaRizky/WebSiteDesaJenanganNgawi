@extends('layouts.admin')
@section('title', 'Sejarah Desa')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Sejarah Desa</h4>
            @if(!$sejarah)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSejarahModal">Tambah Data</button>
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

            @if ($sejarah)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $sejarah->judul }}</td>
                            </tr>
                            <tr>
                                <th>Subjudul</th>
                                <td>{{ $sejarah->subjudul }}</td>
                            </tr>
                            <tr>
                                <th>Gambar</th>
                                <td><img src="{{ Storage::url($sejarah->gambar) }}" alt="Gambar" class="img-fluid" style="max-width: 200px;"></td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{!! $sejarah->deskripsi !!}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSejarahModal">Edit</button>
                                    <form action="{{ route('admin.sejarah_desa.destroy', $sejarah->id) }}" method="POST" class="d-inline delete-form">
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
                <p>Belum ada data sejarah desa yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addSejarahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.sejarah_desa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sejarah Desa</h5>
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
                        <input type="file" class="form-control sejarah-file-input" id="addSejarahGambar" name="gambar" data-preview="addSejarahPreview" required accept="image/*">
                        <div class="mt-2">
                            <img id="addSejarahPreview" src="#" alt="Preview" class="img-fluid" style="max-width: 300px; display: none;" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10"></textarea>
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
@if ($sejarah)
<div class="modal fade" id="editSejarahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.sejarah_desa.update', $sejarah->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sejarah Desa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" value="{{ $sejarah->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_subjudul" class="form-label">Subjudul</label>
                        <input type="text" class="form-control" id="edit_subjudul" name="subjudul" value="{{ $sejarah->subjudul }}">
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control sejarah-file-input" id="editSejarahGambar" name="gambar" data-preview="editSejarahPreview" accept="image/*">
                        <div class="mt-2">
                            <img id="editSejarahPreview" src="{{ Storage::url($sejarah->gambar) }}" alt="Current Image" class="img-fluid" style="max-width: 300px;" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="10">{{ $sejarah->deskripsi }}</textarea>
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

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.22.0/full/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Disable version check warning
    CKEDITOR.config.versionCheck = false;

    var addCKEditor, editCKEditor;

    // Image preview handling
    var editPreview = document.getElementById('editSejarahPreview');
    if (editPreview) editPreview.dataset.originalSrc = editPreview.src || '';

    document.querySelectorAll('.sejarah-file-input').forEach(function (input) {
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

    // Add Modal CKEditor initialization
    var addModal = document.getElementById('addSejarahModal');
    if (addModal) {
        addModal.addEventListener('shown.bs.modal', function () {
            if (!addCKEditor) {
                addCKEditor = CKEDITOR.replace('deskripsi', {
                    height: 300,
                    versionCheck: false,
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    filebrowserImageUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    uploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    toolbar: [
                        { name: 'clipboard', items: ['Undo', 'Redo'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                        { name: 'colors', items: ['TextColor', 'BGColor'] },
                        '/',
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                        { name: 'links', items: ['Link', 'Unlink'] },
                        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
                        { name: 'tools', items: ['Maximize'] }
                    ],
                    allowedContent: true,
                    removeDialogTabs: 'image:advanced;link:advanced'
                });
            }
        });

        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addSejarahPreview');
            var input = document.getElementById('addSejarahGambar');
            if (preview) { preview.src = '#'; preview.style.display = 'none'; }
            if (input) input.value = '';

            // Destroy CKEditor instance
            if (addCKEditor) {
                addCKEditor.destroy();
                addCKEditor = null;
            }
        });
    }

    // Edit Modal CKEditor initialization
    var editModal = document.getElementById('editSejarahModal');
    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function () {
            if (!editCKEditor) {
                editCKEditor = CKEDITOR.replace('edit_deskripsi', {
                    height: 300,
                    versionCheck: false,
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    filebrowserImageUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    uploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
                    toolbar: [
                        { name: 'clipboard', items: ['Undo', 'Redo'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                        { name: 'colors', items: ['TextColor', 'BGColor'] },
                        '/',
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                        { name: 'links', items: ['Link', 'Unlink'] },
                        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
                        { name: 'tools', items: ['Maximize'] }
                    ],
                    allowedContent: true,
                    removeDialogTabs: 'image:advanced;link:advanced'
                });
            }
        });

        editModal.addEventListener('hidden.bs.modal', function () {
            // Destroy CKEditor instance
            if (editCKEditor) {
                editCKEditor.destroy();
                editCKEditor = null;
            }
        });
    }
});
</script>

@endsection
