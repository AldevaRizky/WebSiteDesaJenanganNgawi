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
                                <td>{{ $visiMisi->visi }}</td>
                            </tr>
                            <tr>
                                <th>Misi</th>
                                <td>{!! nl2br(e($visiMisi->misi)) !!}</td>
                            </tr>
                            <tr>
                                <th>Tujuan</th>
                                <td>{!! nl2br(e($visiMisi->tujuan)) !!}</td>
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
    <div class="modal-dialog">
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
                        <input type="text" class="form-control" id="visi" name="visi" required>
                    </div>
                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi</label>
                        <textarea class="form-control" id="misi" name="misi" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <textarea class="form-control" id="tujuan" name="tujuan" rows="4" required></textarea>
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
    <div class="modal-dialog">
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
                        <label for="visi_edit" class="form-label">Visi</label>
                        <input type="text" class="form-control" id="visi_edit" name="visi" value="{{ $visiMisi->visi }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="misi_edit" class="form-label">Misi</label>
                        <textarea class="form-control" id="misi_edit" name="misi" rows="4" required>{{ $visiMisi->misi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan_edit" class="form-label">Tujuan</label>
                        <textarea class="form-control" id="tujuan_edit" name="tujuan" rows="4" required>{{ $visiMisi->tujuan }}</textarea>
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

@endsection
