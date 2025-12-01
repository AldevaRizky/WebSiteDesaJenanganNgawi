@extends('layouts.admin')
@section('title', 'Data Stunting')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Stunting</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataStuntingModal">
                <i class="bx bx-plus"></i> Tambah Data
            </button>
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Anak</th>
                            <th>Tanggal</th>
                            <th>Umur (Bulan)</th>
                            <th>TB (cm)</th>
                            <th>BB (kg)</th>
                            <th>LK (cm)</th>
                            <th>LL (cm)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataStunting as $data)
                        <tr>
                            <td>{{ $loop->iteration + ($dataStunting->currentPage()-1)*$dataStunting->perPage() }}</td>
                            <td><strong>{{ $data->nama_anak }}</strong></td>
                            <td>{{ $data->tanggal_pengukuran->format('d/m/Y') }}</td>
                            <td>{{ $data->umur_bulan }} bulan</td>
                            <td>{{ $data->tinggi_badan_cm }}</td>
                            <td>{{ $data->berat_badan }}</td>
                            <td>{{ $data->lingkar_kepala ?? '-' }}</td>
                            <td>{{ $data->lingkar_lengan ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $data->status_color }}">{{ $data->status_label }}</span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataStuntingModal{{ $data->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.data_stunting.destroy', $data->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $data->id }}">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $dataStunting->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="addDataStuntingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.data_stunting.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Stunting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_anak" class="form-control" required placeholder="Contoh: Ahmad Rizki">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pengukuran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengukuran" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Umur (Bulan) <span class="text-danger">*</span></label>
                            <input type="number" name="umur_bulan" class="form-control" required min="0" max="60" placeholder="0-60">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Stunting <span class="text-danger">*</span></label>
                            <select name="status_stunting" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="normal">Normal</option>
                                <option value="stunting">Stunting</option>
                                <option value="severely_stunting">Stunting Berat</option>
                                <option value="tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="tinggi_badan_cm" class="form-control" required min="0" max="200" placeholder="Contoh: 85.5">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="berat_badan" class="form-control" required min="0" max="100" placeholder="Contoh: 12.5">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lingkar Kepala (cm)</label>
                            <input type="number" step="0.01" name="lingkar_kepala" class="form-control" min="0" max="100" placeholder="Contoh: 45.5">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lingkar Lengan (cm)</label>
                            <input type="number" step="0.01" name="lingkar_lengan" class="form-control" min="0" max="100" placeholder="Contoh: 13.5">
                        </div>
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

{{-- Modal Edit --}}
@foreach($dataStunting as $data)
<div class="modal fade" id="editDataStuntingModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.data_stunting.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Stunting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_anak" class="form-control" required value="{{ $data->nama_anak }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pengukuran <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengukuran" class="form-control" required value="{{ $data->tanggal_pengukuran->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Umur (Bulan) <span class="text-danger">*</span></label>
                            <input type="number" name="umur_bulan" class="form-control" required min="0" max="60" value="{{ $data->umur_bulan }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Stunting <span class="text-danger">*</span></label>
                            <select name="status_stunting" class="form-select" required>
                                <option value="normal" {{ $data->status_stunting == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="stunting" {{ $data->status_stunting == 'stunting' ? 'selected' : '' }}>Stunting</option>
                                <option value="severely_stunting" {{ $data->status_stunting == 'severely_stunting' ? 'selected' : '' }}>Stunting Berat</option>
                                <option value="tinggi" {{ $data->status_stunting == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="tinggi_badan_cm" class="form-control" required min="0" max="200" value="{{ $data->tinggi_badan_cm }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="berat_badan" class="form-control" required min="0" max="100" value="{{ $data->berat_badan }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lingkar Kepala (cm)</label>
                            <input type="number" step="0.01" name="lingkar_kepala" class="form-control" min="0" max="100" value="{{ $data->lingkar_kepala }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lingkar Lengan (cm)</label>
                            <input type="number" step="0.01" name="lingkar_lengan" class="form-control" min="0" max="100" value="{{ $data->lingkar_lengan }}">
                        </div>
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

@push('scripts')
<script>
    // SweetAlert untuk konfirmasi hapus
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data stunting akan dihapus secara permanen.',
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
</script>
@endpush

@endsection
