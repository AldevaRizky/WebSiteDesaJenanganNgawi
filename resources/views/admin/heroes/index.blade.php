@extends('layouts.admin')
@section('title', 'Heroes Management')
@section('content')
<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Hero</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHeroModal">Tambah Cover</button>
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($heroes as $hero)
                        <tr>
                            <td>{{ $loop->iteration + ($heroes->currentPage() - 1) * $heroes->perPage() }}</td>
                            <td><img src="{{ Storage::url($hero->cover) }}" alt="Cover" class="img-fluid" style="max-width: 100px;"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editHeroModal{{ $hero->id }}">Edit</button>
                                <form action="{{ route('admin.heroes.destroy', $hero->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $hero->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Hero Modal -->
                        <div class="modal fade" id="editHeroModal{{ $hero->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.heroes.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Cover</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="editHeroCover{{ $hero->id }}" class="form-label">Hero Cover</label>
                                                <input type="file" class="form-control hero-file-input" id="editHeroCover{{ $hero->id }}" name="cover" data-preview="editHeroPreview{{ $hero->id }}">
                                                <div class="mt-2">
                                                    <img id="editHeroPreview{{ $hero->id }}" src="{{ Storage::url($hero->cover) }}" alt="Current cover" class="img-fluid" style="max-width: 300px;" />
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
                {{ $heroes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Hero Modal -->
<div class="modal fade" id="addHeroModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.heroes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Cover</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addHeroCover" class="form-label">Hero Cover</label>
                        <input type="file" class="form-control hero-file-input" id="addHeroCover" name="cover" data-preview="addHeroPreview" required>
                        <div class="mt-2">
                            <img id="addHeroPreview" src="#" alt="Preview" class="img-fluid" style="max-width: 300px; display: none;" />
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Store original src for edit previews so we can revert if needed
    document.querySelectorAll('img[id^="editHeroPreview"]').forEach(function(img){
        img.dataset.originalSrc = img.src || '';
    });

    // Handle file input changes for all hero file inputs
    document.querySelectorAll('.hero-file-input').forEach(function (input) {
        input.addEventListener('change', function (e) {
            var previewId = input.dataset.preview;
            if (!previewId) return;
            var preview = document.getElementById(previewId);
            if (!preview) return;
            var file = input.files && input.files[0];
            if (file) {
                // Show selected file
                preview.src = URL.createObjectURL(file);
                preview.style.display = '';
            } else {
                // No file chosen: for edit previews revert to original, for add hide
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

    // Reset Add modal preview when closed
    var addModal = document.getElementById('addHeroModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addHeroPreview');
            var input = document.getElementById('addHeroCover');
            if (preview) {
                preview.src = '#';
                preview.style.display = 'none';
            }
            if (input) {
                input.value = '';
            }
        });
    }
});
</script>

@endsection
