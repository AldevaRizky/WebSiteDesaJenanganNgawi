@extends('layouts.admin')
@section('title', 'Edit Perangkat Desa')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Edit Perangkat Desa</h4>
            <a href="{{ route('admin.perangkat.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('admin.perangkat.update', $perangkat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required value="{{ old('nama', $perangkat->nama) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $perangkat->jabatan) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $perangkat->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->nama }} - {{ $parent->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $perangkat->order) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $perangkat->deskripsi) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $perangkat->phone) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $perangkat->email) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Gambar Saat Ini</label>
                        <div class="mb-2">
                            @if($perangkat->gambar)
                                <img src="{{ asset('storage/' . $perangkat->gambar) }}" alt="" style="width:150px;height:150px;object-fit:cover;border-radius:6px;">
                            @else
                                <p class="text-muted">Tidak ada gambar</p>
                            @endif
                        </div>
                        <label class="form-label">Ganti Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.perangkat.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
