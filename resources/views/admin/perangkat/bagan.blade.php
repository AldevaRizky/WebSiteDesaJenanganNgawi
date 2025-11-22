@extends('layouts.admin')
@section('title', 'Bagan Perangkat Desa')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Bagan Perangkat Desa</h4>
            <div>
                <a href="{{ route('admin.perangkat.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({ icon: 'success', title: 'Sukses', text: "{{ session('success') }}" });
                </script>
            @endif

            @if($bagan)
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <img src="{{ Storage::url($bagan->gambar) }}" class="card-img-top" style="object-fit:cover; height:420px;" alt="{{ $bagan->nama }}">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $bagan->nama ?? '—' }}</div>
                                    <div class="text-muted small">Diunggah: {{ $bagan->created_at->format('d M Y') }}</div>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editBaganModal">Edit</button>
                                    <!-- Delete Form (SweetAlert will handle confirmation) -->
                                    <form action="{{ route('admin.perangkat.bagan.destroy', $bagan->id) }}" method="POST" class="delete-bagan-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-delete-bagan">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editBaganModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.perangkat.bagan.update', $bagan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Bagan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Bagan</label>
                                        <input type="file" name="gambar" class="form-control hero-file-input" data-preview="editBaganPreview">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Caption / Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $bagan->nama) }}">
                                    </div>
                                    <div class="mb-3">
                                        <div class="mt-2">
                                            <img id="editBaganPreview" src="{{ Storage::url($bagan->gambar) }}" alt="Current" class="img-fluid" style="max-width: 100%;" />
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

            @else
                <div class="row">
                    <div class="col-md-8">
                        <div class="card p-4">
                            <h5 class="mb-3">Belum ada gambar bagan</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBaganModal">Unggah Bagan</button>
                        </div>
                    </div>
                </div>

                <!-- Add Modal -->
                <div class="modal fade" id="addBaganModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.perangkat.bagan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Unggah Bagan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Bagan <span class="text-danger">*</span></label>
                                        <input type="file" name="gambar" class="form-control hero-file-input" data-preview="addBaganPreview" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Caption / Nama</label>
                                        <input type="text" name="nama" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <div class="mt-2">
                                            <img id="addBaganPreview" src="#" alt="Preview" class="img-fluid" style="display:none; max-width:100%;" />
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
            @endif

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Store original src for edit preview
    var editPreview = document.getElementById('editBaganPreview');
    if (editPreview) editPreview.dataset.originalSrc = editPreview.src || '';

    document.querySelectorAll('.hero-file-input').forEach(function (input) {
        input.addEventListener('change', function (e) {
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

    // Reset Add modal preview when closed
    var addModal = document.getElementById('addBaganModal');
    if (addModal) {
        addModal.addEventListener('hidden.bs.modal', function () {
            var preview = document.getElementById('addBaganPreview');
            var input = document.querySelector('input[name="gambar"]');
            if (preview) { preview.src = '#'; preview.style.display = 'none'; }
            if (input) { input.value = ''; }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // SweetAlert delete for bagan
    document.querySelectorAll('.btn-delete-bagan').forEach(btn => {
        btn.addEventListener('click', function(e){
            const form = this.closest('form');
            if (!form) return;
            Swal.fire({
                title: 'Hapus Bagan?',
                text: 'Bagan akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
