@php use Illuminate\Support\Str; @endphp
@extends('layouts.admin')
@section('title', 'Users Management')
@section('content')
<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Users Management</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({ icon: 'success', title: 'Sukses', text: "{{ session('success') }}" });
                </script>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                @if($u->profile)
                                    <img src="{{ Storage::url($u->profile) }}" alt="profile" style="width:56px;height:56px;object-fit:cover;border-radius:6px;">
                                @else
                                    <div style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;background:#f1f5f9;border-radius:6px;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                @endif
                            </td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->jabatan ?? '-' }}</td>
                            <td>{{ $u->phone ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">Edit</button>
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-user">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.users.update', $u->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $u->name) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ old('email', $u->email) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password (kosongkan jika tidak ingin mengganti)</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $u->jabatan) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $u->phone) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Alamat</label>
                                                <textarea name="alamat" class="form-control">{{ old('alamat', $u->alamat) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Photo</label>
                                                <input type="file" name="profile" class="form-control user-photo-input" data-preview="editUserPreview{{ $u->id }}">
                                                <div class="mt-2"><img id="editUserPreview{{ $u->id }}" src="{{ $u->profile ? Storage::url($u->profile) : '#' }}" style="max-width:200px; display: {{ $u->profile ? '' : 'none' }}"></div>
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">{{ $users->links() }}</div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="profile" class="form-control user-photo-input" data-preview="addUserPreview">
                        <div class="mt-2"><img id="addUserPreview" src="#" style="max-width:200px; display:none"></div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    // preview for add/edit user photo
    document.querySelectorAll('.user-photo-input').forEach(input => {
        input.addEventListener('change', function(){
            const previewId = input.dataset.preview;
            const preview = document.getElementById(previewId);
            if (!preview) return;
            const file = input.files && input.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = '';
            } else {
                preview.src = '#'; preview.style.display = 'none';
            }
        });
    });

    // SweetAlert delete user
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', function(){
            const form = this.closest('form');
            Swal.fire({
                title: 'Hapus User?',
                text: 'User akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endpush

@endsection
