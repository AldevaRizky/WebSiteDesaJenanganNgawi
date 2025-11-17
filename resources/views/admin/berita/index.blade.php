@extends('layouts.admin')
@section('title','Berita Management')
@section('content')

<div class="container mt-6">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Berita</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeritaModal">
                Tambah Berita
            </button>
        </div>

        <div class="card-body">

            {{-- Alert Success --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}"
                    });
                </script>
            @endif

            {{-- Error Validation --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($beritas as $berita)
                        <tr>
                            <td>{{ $loop->iteration + ($beritas->currentPage()-1) * $beritas->perPage() }}</td>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ $berita->kategori->nama ?? '-' }}</td>
                            <td>{{ Str::limit($berita->deskripsi, 40) }}</td>

                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($berita->images as $image)
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($image->path) }}"
                                                 style="width:70px;height:70px;object-fit:cover;border-radius:5px;">
                                            <form action="{{ route('admin.berita_images.destroy', $image->id) }}"
                                                  method="POST"
                                                  class="position-absolute top-0 end-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Hapus gambar ini?')"
                                                        class="btn btn-sm btn-danger py-0 px-1"
                                                        style="font-size:10px;">
                                                    X
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBeritaModal{{ $berita->id }}">
                                    Edit
                                </button>

                                <form action="{{ route('admin.beritas.destroy', $berita->id) }}"
                                      class="d-inline"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>

                        {{-- EDIT MODAL --}}
                        <div class="modal fade" id="editBeritaModal{{ $berita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('admin.beritas.update',$berita->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" name="judul"
                                                           class="form-control"
                                                           value="{{ $berita->judul }}" required>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select name="kategori_id" class="form-control" required>
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach($kategoris as $kategori)
                                                            <option value="{{ $kategori->id }}"
                                                                @if($kategori->id == $berita->kategori_id) selected @endif>
                                                                {{ $kategori->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="3">{{ $berita->deskripsi }}</textarea>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Konten</label>
                                                    <textarea name="konten" class="form-control" rows="5">{{ $berita->konten }}</textarea>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Tambah Gambar</label>
                                                    <input type="file" name="images[]" class="form-control" multiple>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Gambar Saat Ini</label>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($berita->images as $image)
                                                            <img src="{{ Storage::url($image->path) }}"
                                                                 style="width:80px;height:80px;object-fit:cover;border-radius:5px;">
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-warning" type="submit">Perbarui</button>
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $beritas->links() }}
            </div>

        </div>
    </div>

</div>


{{-- ADD MODAL --}}
<div class="modal fade" id="addBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('admin.beritas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Konten</label>
                            <textarea name="konten" class="form-control" rows="5"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Gambar (Multiple)</label>
                            <input type="file" name="images[]" class="form-control" multiple>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>

        </form>

    </div>
</div>

@endsection
