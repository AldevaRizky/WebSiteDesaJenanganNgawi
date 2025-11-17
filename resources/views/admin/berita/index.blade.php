@extends('layouts.admin')
@section('title', 'Berita')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Berita</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeritaModal">Tambah Berita</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>Swal.fire('Sukses','{{ session('success') }}','success')</script>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beritas as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->kategori?->nama }}</td>
                            <td>{{ $b->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBeritaModal{{ $b->id }}">Edit</button>
                                <form action="{{ route('admin.beritas.destroy', $b->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editBeritaModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <form action="{{ route('admin.beritas.update', $b->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text" class="form-control" name="judul" value="{{ $b->judul }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Konten</label>
                                                        <textarea id="konten_edit_{{ $b->id }}" name="konten" class="form-control" rows="10">{{ $b->konten }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kategori</label>
                                                        <select name="kategori_id" class="form-control">
                                                            @foreach($kategoris as $k)
                                                                <option value="{{ $k->id }}" {{ $b->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi singkat</label>
                                                        <textarea name="deskripsi" class="form-control" rows="3">{{ $b->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tambahkan Gambar (bisa pilih beberapa)</label>
                                                        <input type="file" name="images[]" class="form-control berita-multi-file" multiple accept="image/*" data-preview="editPreview{{ $b->id }}">
                                                        <div id="editPreview{{ $b->id }}" class="mt-2 d-flex flex-wrap gap-2">
                                                            @foreach($b->images as $img)
                                                                <div class="position-relative">
                                                                    <img src="{{ Storage::url($img->path) }}" class="img-thumbnail" style="max-width:120px;">
                                                                    <form action="{{ route('admin.berita_images.destroy', $img->id) }}" method="POST" style="position:absolute;top:2px;right:2px;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger">x</button>
                                                                    </form>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Perbarui</button>
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
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.beritas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konten</label>
                                <textarea id="konten" name="konten" class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-control">
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi singkat</label>
                                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar (bisa pilih beberapa)</label>
                                <input type="file" name="images[]" class="form-control berita-multi-file" multiple accept="image/*" data-preview="addPreview">
                                <div id="addPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE CDN and preview script -->
@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({ selector: '#konten', menubar: true, plugins: 'link image lists', toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image' });
        @foreach($beritas as $b)
            tinymce.init({ selector: '#konten_edit_{{ $b->id }}', menubar: true, plugins: 'link image lists', toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image' });
        @endforeach

        document.querySelectorAll('.berita-multi-file').forEach(function(input){
            input.addEventListener('change', function(){
                const previewId = input.dataset.preview;
                const container = document.getElementById(previewId);
                if (!container) return;
                container.innerHTML = '';
                Array.from(input.files).forEach(function(file){
                    const url = URL.createObjectURL(file);
                    const img = document.createElement('img');
                    img.src = url; img.className = 'img-thumbnail'; img.style.maxWidth = '120px'; img.style.marginRight = '8px';
                    container.appendChild(img);
                });
            });
        });
    </script>
@endsection

@endsection
