@extends('layouts.admin')
@section('title', 'Perangkat Desa')
@section('content')

<div class="container mt-6">
    <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Perangkat Desa</h4>
            <div>
                <a href="{{ route('admin.perangkat.bagan') }}" class="btn btn-outline-primary me-2">Lihat Bagan</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPerangkatModal">Tambah Perangkat</button>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <script>Swal.fire('Sukses', "{{ session('success') }}", 'success');</script>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Parent</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perangkats as $p)
                        <tr>
                            <td>{{ $loop->iteration + ($perangkats->currentPage()-1)*$perangkats->perPage() }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->jabatan ?? '-' }}</td>
                            <td>{{ $p->parent?->nama ?? '-' }}</td>
                            <td>
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPerangkatModal{{ $p->id }}">Edit</button>
                                <form action="{{ route('admin.perangkat.destroy', $p->id) }}" method="POST" class="d-inline delete-perangkat-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-perangkat" data-id="{{ $p->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">{{ $perangkats->links() }}</div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addPerangkatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.perangkat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Perangkat Desa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($all as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->nama }} - {{ $parent->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="gambar" class="form-control perangkat-image-input" id="addPerangkatImage" accept="image/*">
                        <div id="addPerangkatPreview" class="mt-3"></div>
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

{{-- Edit Modals per Perangkat --}}
@foreach($perangkats as $p)
    <div class="modal fade" id="editPerangkatModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.perangkat.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Perangkat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" required value="{{ old('nama', $p->nama) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $p->jabatan) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent</label>
                            <select name="parent_id" class="form-select">
                                <option value="">-- Tidak Ada --</option>
                                @foreach($all->where('id', '!=', $p->id) as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $p->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->nama }} - {{ $parent->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $p->order) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $p->deskripsi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $p->phone) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $p->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="mb-2" id="existingImageContainer{{ $p->id }}">
                                @if($p->gambar)
                                    <div class="image-preview-item">
                                        <img src="{{ asset('storage/' . $p->gambar) }}" id="existingImage{{ $p->id }}" style="width:150px;height:150px;object-fit:cover;border-radius:6px;">
                                        <button type="button" class="remove-image" id="removeExistingImageBtn{{ $p->id }}" title="Hapus gambar">&times;</button>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada gambar</p>
                                @endif
                            </div>
                            <input type="hidden" name="delete_image" id="deleteImageInput{{ $p->id }}" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar</label>
                            <input type="file" name="gambar" class="form-control perangkat-image-input" id="editPerangkatImage{{ $p->id }}" accept="image/*">
                            <div id="editPerangkatPreview{{ $p->id }}" class="mt-3"></div>
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
    .image-preview-item { position: relative; display: inline-block; }
    .image-preview-item img { width:150px; height:150px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6; }
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
<script>
    // SweetAlert delete perangkat
    document.querySelectorAll('.btn-delete-perangkat').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Perangkat?',
                text: 'Data perangkat akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Remove existing image in edit modal (mark for deletion)
    document.querySelectorAll('[id^="removeExistingImageBtn"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.id.replace('removeExistingImageBtn','');
            const imageEl = document.getElementById('existingImage'+id);
            const deletedInput = document.getElementById('deleteImageInput'+id);

            Swal.fire({
                title: 'Hapus Gambar?',
                text: 'Gambar akan dihapus saat Anda menyimpan perubahan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (imageEl) imageEl.style.display = 'none';
                    deletedInput.value = 1;
                    Swal.fire('Ditandai untuk dihapus', 'Gambar akan dihapus saat Anda menyimpan.', 'success');
                }
            });
        });
    });

    // Image preview for add/edit (single file)
    (function(){
        const inputs = document.querySelectorAll('.perangkat-image-input');
        inputs.forEach(input => {
            input.addEventListener('change', function(e){
                const file = e.target.files[0];
                const id = input.id.replace('addPerangkatImage','').replace('editPerangkatImage','');
                let container = null;
                if (input.id === 'addPerangkatImage') container = document.getElementById('addPerangkatPreview');
                else container = document.getElementById('editPerangkatPreview'+id);

                if (!container) return;
                container.innerHTML = '';
                if (file && file.type.startsWith('image/')){
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.width = '150px'; img.style.height = '150px'; img.style.objectFit = 'cover'; img.style.borderRadius='6px'; img.onload = function(){ URL.revokeObjectURL(this.src); };
                    container.appendChild(img);
                }
            });
        });
    })();
</script>
@endpush

@endsection
