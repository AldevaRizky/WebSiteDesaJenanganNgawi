@extends('layouts.admin')
@section('title', 'Data Penduduk')
@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Penduduk</h4>
            @if(!$dataPenduduk)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataPendudukModal">Tambah Data</button>
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

            @if ($dataPenduduk)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Total Penduduk</th>
                                <td>{{ $dataPenduduk->total_penduduk }}</td>
                            </tr>
                            <tr>
                                <th>Kepala Keluarga</th>
                                <td>{{ $dataPenduduk->kepala_keluarga }}</td>
                            </tr>
                            <tr>
                                <th>Laki-laki</th>
                                <td>{{ $dataPenduduk->laki_laki }}</td>
                            </tr>
                            <tr>
                                <th>Perempuan</th>
                                <td>{{ $dataPenduduk->perempuan }}</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataPendudukModal">Edit</button>
                                    <form action="{{ route('admin.data_penduduk.destroy', $dataPenduduk->id) }}" method="POST" class="d-inline delete-form">
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
                <p>Belum ada data penduduk yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addDataPendudukModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.data_penduduk.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Penduduk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="total_penduduk" class="form-label">Total Penduduk</label>
                        <input type="number" min="0" class="form-control" id="total_penduduk" name="total_penduduk" required>
                    </div>
                    <div class="mb-3">
                        <label for="kepala_keluarga" class="form-label">Kepala Keluarga</label>
                        <input type="number" min="0" class="form-control" id="kepala_keluarga" name="kepala_keluarga" required>
                    </div>
                    <div class="mb-3">
                        <label for="laki_laki" class="form-label">Laki-laki</label>
                        <input type="number" min="0" class="form-control" id="laki_laki" name="laki_laki" required>
                    </div>
                    <div class="mb-3">
                        <label for="perempuan" class="form-label">Perempuan</label>
                        <input type="number" min="0" class="form-control" id="perempuan" name="perempuan" required>
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
@if ($dataPenduduk)
<div class="modal fade" id="editDataPendudukModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.data_penduduk.update', $dataPenduduk->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Penduduk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_total_penduduk" class="form-label">Total Penduduk</label>
                        <input type="number" min="0" class="form-control" id="edit_total_penduduk" name="total_penduduk" value="{{ $dataPenduduk->total_penduduk }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kepala_keluarga" class="form-label">Kepala Keluarga</label>
                        <input type="number" min="0" class="form-control" id="edit_kepala_keluarga" name="kepala_keluarga" value="{{ $dataPenduduk->kepala_keluarga }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_laki_laki" class="form-label">Laki-laki</label>
                        <input type="number" min="0" class="form-control" id="edit_laki_laki" name="laki_laki" value="{{ $dataPenduduk->laki_laki }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_perempuan" class="form-label">Perempuan</label>
                        <input type="number" min="0" class="form-control" id="edit_perempuan" name="perempuan" value="{{ $dataPenduduk->perempuan }}" required>
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
