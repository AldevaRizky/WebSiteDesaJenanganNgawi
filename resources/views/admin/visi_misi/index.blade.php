@extends('layouts.admin')
@section('title', 'Visi dan Misi')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Visi dan Misi</h4>
            @if(!$visiMisi)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisiMisiModal">Tambah Data</button>
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

            @if ($visiMisi)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Visi</th>
                                <td>{!! $visiMisi->visi !!}</td>
                            </tr>
                            <tr>
                                <th>Misi</th>
                                <td>{!! $visiMisi->misi !!}</td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td>{!! $visiMisi->tujuan !!}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editVisiMisiModal">Edit</button>
                                    <form action="{{ route('admin.visi_misi.destroy', $visiMisi->id) }}" method="POST" class="d-inline delete-form">
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
                <p>Belum ada data visi dan misi yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addVisiMisiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.visi_misi.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Visi dan Misi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi</label>
                        <textarea class="form-control" id="visi" name="visi" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi</label>
                        <textarea class="form-control" id="misi" name="misi" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <textarea class="form-control" id="tujuan" name="tujuan" rows="10"></textarea>
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
@if ($visiMisi)
<div class="modal fade" id="editVisiMisiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.visi_misi.update', $visiMisi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Visi dan Misi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_visi" class="form-label">Visi</label>
                        <textarea class="form-control" id="edit_visi" name="visi" rows="10">{{ $visiMisi->visi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_misi" class="form-label">Misi</label>
                        <textarea class="form-control" id="edit_misi" name="misi" rows="10">{{ $visiMisi->misi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tujuan" class="form-label">Tujuan</label>
                        <textarea class="form-control" id="edit_tujuan" name="tujuan" rows="10">{{ $visiMisi->tujuan }}</textarea>
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

    var addVisiCKEditor, addMisiCKEditor, addTujuanCKEditor;
    var editVisiCKEditor, editMisiCKEditor, editTujuanCKEditor;

    // CKEditor configuration
    var ckConfig = {
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
    };

    // Add Modal CKEditor initialization
    var addModal = document.getElementById('addVisiMisiModal');
    if (addModal) {
        addModal.addEventListener('shown.bs.modal', function () {
            if (!addVisiCKEditor) {
                addVisiCKEditor = CKEDITOR.replace('visi', ckConfig);
            }
            if (!addMisiCKEditor) {
                addMisiCKEditor = CKEDITOR.replace('misi', ckConfig);
            }
            if (!addTujuanCKEditor) {
                addTujuanCKEditor = CKEDITOR.replace('tujuan', ckConfig);
            }
        });

        addModal.addEventListener('hidden.bs.modal', function () {
            // Destroy CKEditor instances
            if (addVisiCKEditor) {
                addVisiCKEditor.destroy();
                addVisiCKEditor = null;
            }
            if (addMisiCKEditor) {
                addMisiCKEditor.destroy();
                addMisiCKEditor = null;
            }
            if (addTujuanCKEditor) {
                addTujuanCKEditor.destroy();
                addTujuanCKEditor = null;
            }
        });
    }

    // Edit Modal CKEditor initialization
    var editModal = document.getElementById('editVisiMisiModal');
    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function () {
            if (!editVisiCKEditor) {
                editVisiCKEditor = CKEDITOR.replace('edit_visi', ckConfig);
            }
            if (!editMisiCKEditor) {
                editMisiCKEditor = CKEDITOR.replace('edit_misi', ckConfig);
            }
            if (!editTujuanCKEditor) {
                editTujuanCKEditor = CKEDITOR.replace('edit_tujuan', ckConfig);
            }
        });

        editModal.addEventListener('hidden.bs.modal', function () {
            // Destroy CKEditor instances
            if (editVisiCKEditor) {
                editVisiCKEditor.destroy();
                editVisiCKEditor = null;
            }
            if (editMisiCKEditor) {
                editMisiCKEditor.destroy();
                editMisiCKEditor = null;
            }
            if (editTujuanCKEditor) {
                editTujuanCKEditor.destroy();
                editTujuanCKEditor = null;
            }
        });
    }
});
</script>

@endsection
