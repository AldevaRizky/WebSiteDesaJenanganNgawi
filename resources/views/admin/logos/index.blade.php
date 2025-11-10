@extends('layouts.admin')
@section('title', 'Logo Management')
@section('content')
<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Logo</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLogoModal">Tambah Logo</button>
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
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: "{{ session('error') }}",
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logos as $logo)
                        <tr>
                            <td>{{ $loop->iteration + ($logos->currentPage() - 1) * $logos->perPage() }}</td>
                            <td><img src="{{ Storage::url($logo->logo) }}" alt="Logo" class="img-fluid" style="max-width: 100px;"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editLogoModal{{ $logo->id }}">Edit</button>
                                <form action="{{ route('admin.logos.destroy', $logo->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $logo->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Logo Modal -->
                        <div class="modal fade" id="editLogoModal{{ $logo->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.logos.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Logo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="editLogoInput{{ $logo->id }}" class="form-label">Logo</label>
                                                <input type="file" class="form-control logo-file-input" id="editLogoInput{{ $logo->id }}" name="logo" data-preview="editLogoPreview{{ $logo->id }}" accept="image/*">
                                                <div class="mt-2">
                                                    <img id="editLogoPreview{{ $logo->id }}" src="{{ Storage::url($logo->logo) }}" alt="Current Logo" class="img-fluid" style="max-width: 300px;" />
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-5">
                {{ $logos->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Logo Modal -->
<div class="modal fade" id="addLogoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addLogoInput" class="form-label">Logo</label>
                        <input type="file" class="form-control logo-file-input" id="addLogoInput" name="logo" data-preview="addLogoPreview" required accept="image/*">
                        <div class="mt-2">
                            <img id="addLogoPreview" src="#" alt="Preview" class="img-fluid" style="max-width: 300px; display: none;" />
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

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Save original src for each edit preview
    document.querySelectorAll('img[id^="editLogoPreview"]').forEach(function(img){
        img.dataset.originalSrc = img.src || '';
    });

    document.querySelectorAll('.logo-file-input').forEach(function (input) {
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

    var addModal = document.getElementById('addLogoModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addLogoPreview');
            var input = document.getElementById('addLogoInput');
            if (preview) {
                preview.src = '#';
                preview.style.display = 'none';
            }
            if (input) input.value = '';
        });
    }
});
</script>
