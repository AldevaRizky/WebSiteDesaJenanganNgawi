@extends('layouts.admin')
@section('title', 'UMKM Management')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management UMKM</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUmkmModal">
                Tambah UMKM
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
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Alamat</th>
                            <th>Gambar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($umkms as $umkm)
                        <tr>
                            <td>{{ $loop->iteration + ($umkms->currentPage() - 1) * $umkms->perPage() }}</td>
                            <td>{{ $umkm->nama }}</td>
                            <td>{{ Str::limit(strip_tags($umkm->deskripsi ?? '-'), 60) }}</td>
                            <td>{{ Str::limit($umkm->alamat ?? '-', 50) }}</td>
                            <td>
                                @if($umkm->images->count() > 0)
                                    <img src="{{ asset('storage/' . $umkm->images->first()->path) }}"
                                         alt="Image" style="width:60px;height:60px;object-fit:cover;border-radius:4px;">
                                    @if($umkm->images->count() > 1)
                                        <small class="text-muted">+{{ $umkm->images->count() - 1 }} lagi</small>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $umkm->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#viewModal{{ $umkm->id }}">Lihat</button>
                                <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editUmkmModal{{ $umkm->id }}">Edit</button>

                                <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm mb-1 btn-delete" data-id="{{ $umkm->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data UMKM</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $umkms->links() }}
            </div>

        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addUmkmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Maps</label>
                        <input type="url" name="link_maps" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link WhatsApp</label>
                        <input type="text" name="link_wa" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (multiple)</label>
                        <input type="file" name="images[]" class="form-control umkm-image-input" id="addUmkmImages" multiple accept="image/*">
                        {{-- Image Preview for Add Modal --}}
                        <div id="addImagePreview" class="mt-3 row"></div>
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

{{-- Modals per UMKM (view + edit) --}}
@foreach($umkms as $umkm)
    {{-- View Modal --}}
    <div class="modal fade" id="viewModal{{ $umkm->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><strong>Nama:</strong><p>{{ $umkm->nama }}</p></div>
                    <div class="mb-3"><strong>Deskripsi:</strong><p>{!! $umkm->deskripsi ?? '-' !!}</p></div>
                    <div class="mb-3"><strong>Alamat:</strong><p>{{ $umkm->alamat ?? '-' }}</p></div>
                    <div class="mb-3"><strong>Link Maps:</strong><p>{{ $umkm->link_maps ?? '-' }}</p></div>
                    <div class="mb-3"><strong>Link WA:</strong><p>{{ $umkm->link_wa ?? '-' }}</p></div>
                    <div class="mb-3"><strong>Gambar:</strong>
                        <div class="row mt-2">
                            @forelse($umkm->images as $image)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" style="width:100%;height:200px;object-fit:cover;">
                                </div>
                            @empty
                                <p class="text-muted">Tidak ada gambar</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editUmkmModal{{ $umkm->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit UMKM</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $umkm->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi_{{ $umkm->id }}" class="form-control" rows="10">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $umkm->alamat) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Maps</label>
                            <input type="url" name="link_maps" class="form-control" value="{{ old('link_maps', $umkm->link_maps) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link WhatsApp</label>
                            <input type="text" name="link_wa" class="form-control" value="{{ old('link_wa', $umkm->link_wa) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="row" id="existingImages{{ $umkm->id }}">
                                @forelse($umkm->images as $image)
                                    <div class="col-md-3 mb-2" id="existing-image-{{ $image->id }}-umkm-{{ $umkm->id }}">
                                        <div class="image-preview-item">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" style="width:100%;height:200px;object-fit:cover;">
                                            <button type="button" class="remove-image remove-existing-image" title="Hapus gambar" data-image-id="{{ $image->id }}" data-umkm-id="{{ $umkm->id }}">&times;</button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Tidak ada gambar</p>
                                @endforelse
                            </div>
                            <div id="deletedImagesContainer{{ $umkm->id }}"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar Baru (multiple)</label>
                            <input type="file" name="images[]" class="form-control umkm-image-input" id="editUmkmImages{{ $umkm->id }}" multiple accept="image/*">
                            {{-- Image Preview for Edit Modal (new uploads) --}}
                            <div id="imagePreviewEdit{{ $umkm->id }}" class="mt-3 row"></div>
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

@push('styles')
<style>
    .image-preview-item {
        position: relative;
        display: inline-block;
    }
    .image-preview-item img {
        width: 200px;
        height: 200px;
        max-width: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        display: block;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(220,53,69,0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        line-height: 1;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.22.0/full/ckeditor.js"></script>
<script>
    // Disable CKEditor version check warning
    CKEDITOR.config.versionCheck = false;

    var addCKEditor;
    var editCKEditors = {};

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
    var addModal = document.getElementById('addUmkmModal');
    if (addModal) {
        addModal.addEventListener('shown.bs.modal', function () {
            if (!addCKEditor) {
                addCKEditor = CKEDITOR.replace('deskripsi', ckConfig);
            }
        });

        addModal.addEventListener('hidden.bs.modal', function () {
            if (addCKEditor) {
                addCKEditor.destroy();
                addCKEditor = null;
            }
        });
    }

    // Edit Modals CKEditor initialization (dynamic for each UMKM)
    @foreach($umkms as $umkm)
    (function() {
        var editModal = document.getElementById('editUmkmModal{{ $umkm->id }}');
        if (editModal) {
            editModal.addEventListener('shown.bs.modal', function () {
                if (!editCKEditors[{{ $umkm->id }}]) {
                    editCKEditors[{{ $umkm->id }}] = CKEDITOR.replace('edit_deskripsi_{{ $umkm->id }}', ckConfig);
                }
            });

            editModal.addEventListener('hidden.bs.modal', function () {
                if (editCKEditors[{{ $umkm->id }}]) {
                    editCKEditors[{{ $umkm->id }}].destroy();
                    editCKEditors[{{ $umkm->id }}] = null;
                }
            });
        }
    })();
    @endforeach
</script>
<script>
    // Handle remove existing images across modals (existing images stored in DB)
    // Behavior: show confirmation, then append hidden delete_images[] and hide the image element
    document.querySelectorAll('.remove-existing-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const umkmId = this.getAttribute('data-umkm-id');
            const imageElement = document.getElementById('existing-image-' + imageId + '-umkm-' + umkmId);
            const deletedImagesContainer = document.getElementById('deletedImagesContainer' + umkmId);

            if (!deletedImagesContainer) return;

            Swal.fire({
                title: 'Hapus Gambar?',
                text: "Gambar ini akan dihapus saat Anda menyimpan perubahan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_images[]';
                    input.value = imageId;
                    deletedImagesContainer.appendChild(input);
                    imageElement.style.display = 'none';
                    Swal.fire('Ditandai untuk dihapus!', 'Gambar akan dihapus saat Anda menyimpan perubahan.', 'success');
                }
            });
        });
    });

    // Client-side image preview + removable preview items for Add and Edit modals
    (function() {
        const inputs = document.querySelectorAll('.umkm-image-input');
        const selectedFilesMap = new WeakMap();

        inputs.forEach(input => {
            // Determine preview container id
            let previewId = null;
            if (input.id === 'addUmkmImages') {
                previewId = 'addImagePreview';
            } else if (input.id && input.id.startsWith('editUmkmImages')) {
                // input.id like editUmkmImages{ID}
                const suffix = input.id.replace('editUmkmImages', '');
                previewId = 'imagePreviewEdit' + suffix;
            }

            const previewContainer = previewId ? document.getElementById(previewId) : null;
            if (!previewContainer) return;

            selectedFilesMap.set(input, []);

            input.addEventListener('change', function(e) {
                const files = Array.from(e.target.files).filter(f => f && f.type && f.type.startsWith('image/'));
                selectedFilesMap.set(input, files);
                renderPreviews(input, previewContainer);
            });

            function renderPreviews(inputEl, container) {
                const files = selectedFilesMap.get(inputEl) || [];
                container.innerHTML = '';

                files.forEach((file, idx) => {
                    const col = document.createElement('div');
                    col.className = 'col-md-2 mb-2';

                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.onload = function() { URL.revokeObjectURL(this.src); };

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.title = 'Hapus preview';
                    removeBtn.addEventListener('click', function() {
                        const current = selectedFilesMap.get(inputEl) || [];
                        current.splice(idx, 1);
                        selectedFilesMap.set(inputEl, current);
                        updateFileInput(inputEl, current);
                        renderPreviews(inputEl, container);
                    });

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    col.appendChild(previewItem);
                    container.appendChild(col);
                });
            }

            function updateFileInput(inputEl, files) {
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                inputEl.files = dt.files;
            }
        });
    })();
</script>
@endpush


@endsection
