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

            <div class="d-flex justify-content-center mt-4">
                {{ $umkms->links() }}
            </div>

        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addUmkmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
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
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
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
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" style="width:100%;height:150px;object-fit:cover;">
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
        <div class="modal-dialog">
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
                            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
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
                                        <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded" style="width:100%;height:120px;object-fit:cover;">
                                        <button type="button" class="btn btn-danger btn-sm mt-1 remove-existing-image" data-image-id="{{ $image->id }}" data-umkm-id="{{ $umkm->id }}">Hapus</button>
                                    </div>
                                @empty
                                    <p class="text-muted">Tidak ada gambar</p>
                                @endforelse
                            </div>
                            <div id="deletedImagesContainer{{ $umkm->id }}"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar Baru (multiple)</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    // Handle remove existing images across modals
    document.querySelectorAll('.remove-existing-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            const umkmId = this.getAttribute('data-umkm-id');
            const imageElement = document.getElementById('existing-image-' + imageId + '-umkm-' + umkmId);
            const deletedImagesContainer = document.getElementById('deletedImagesContainer' + umkmId);

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
</script>
@endpush

@endsection
