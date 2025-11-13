@extends('layouts.admin')
@section('title', 'Footer')

@section('content')
<div class="container-fluid mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Footer</h4>
            @if(!$footer)
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFooterModal">Tambah Data</button>
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

            @if ($footer)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $footer->nama }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $footer->deskripsi }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $footer->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $footer->telepon }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $footer->email }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>{{ $footer->lokasi }}</td>
                            </tr>
                            <tr>
                                <th>Link IG</th>
                                <td>@if($footer->link_ig)<a href="{{ $footer->link_ig }}" target="_blank">{{ $footer->link_ig }}</a>@endif</td>
                            </tr>
                            <tr>
                                <th>Link FB</th>
                                <td>@if($footer->link_fb)<a href="{{ $footer->link_fb }}" target="_blank">{{ $footer->link_fb }}</a>@endif</td>
                            </tr>
                            <tr>
                                <th>Link WA</th>
                                <td>@if($footer->link_wa)<a href="{{ $footer->link_wa }}" target="_blank">{{ $footer->link_wa }}</a>@endif</td>
                            </tr>
                            <tr>
                                <th>Link YouTube</th>
                                <td>@if($footer->link_youtube)<a href="{{ $footer->link_youtube }}" target="_blank">{{ $footer->link_youtube }}</a>@endif</td>
                            </tr>
                            <tr>
                                <th>Aksi</th>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFooterModal">Edit</button>
                                    <form action="{{ route('admin.footer.destroy', $footer->id) }}" method="POST" class="d-inline delete-form">
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
                <p>Belum ada data footer yang ditambahkan.</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addFooterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.footer.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Footer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <textarea class="form-control" id="lokasi" name="lokasi" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link_ig" class="form-label">Link Instagram</label>
                        <input type="url" class="form-control" id="link_ig" name="link_ig">
                    </div>
                    <div class="mb-3">
                        <label for="link_fb" class="form-label">Link Facebook</label>
                        <input type="url" class="form-control" id="link_fb" name="link_fb">
                    </div>
                    <div class="mb-3">
                        <label for="link_wa" class="form-label">Link WhatsApp</label>
                        <input type="url" class="form-control" id="link_wa" name="link_wa">
                    </div>
                    <div class="mb-3">
                        <label for="link_youtube" class="form-label">Link YouTube</label>
                        <input type="url" class="form-control" id="link_youtube" name="link_youtube">
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
@if ($footer)
<div class="modal fade" id="editFooterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.footer.update', $footer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Footer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_edit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_edit" name="nama" value="{{ $footer->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_edit" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi_edit" name="deskripsi" rows="3" required>{{ $footer->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_edit" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat_edit" name="alamat" rows="3" required>{{ $footer->alamat }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon_edit" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon_edit" name="telepon" value="{{ $footer->telepon }}">
                    </div>
                    <div class="mb-3">
                        <label for="email_edit" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_edit" name="email" value="{{ $footer->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="lokasi_edit" class="form-label">Lokasi</label>
                        <textarea class="form-control" id="lokasi_edit" name="lokasi" rows="2" required>{{ $footer->lokasi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link_ig_edit" class="form-label">Link Instagram</label>
                        <input type="url" class="form-control" id="link_ig_edit" name="link_ig" value="{{ $footer->link_ig }}">
                    </div>
                    <div class="mb-3">
                        <label for="link_fb_edit" class="form-label">Link Facebook</label>
                        <input type="url" class="form-control" id="link_fb_edit" name="link_fb" value="{{ $footer->link_fb }}">
                    </div>
                    <div class="mb-3">
                        <label for="link_wa_edit" class="form-label">Link WhatsApp</label>
                        <input type="url" class="form-control" id="link_wa_edit" name="link_wa" value="{{ $footer->link_wa }}">
                    </div>
                    <div class="mb-3">
                        <label for="link_youtube_edit" class="form-label">Link YouTube</label>
                        <input type="url" class="form-control" id="link_youtube_edit" name="link_youtube" value="{{ $footer->link_youtube }}">
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
