@extends('layouts.admin')
@section('title', 'Heroes Management')
@section('content')
<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Management Hero</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHeroModal">Tambah Cover</button>
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($heroes as $hero)
                        <tr>
                            <td>{{ $loop->iteration + ($heroes->currentPage() - 1) * $heroes->perPage() }}</td>
                            <td><img src="{{ Storage::url($hero->cover) }}" alt="Cover" class="img-fluid" style="max-width: 100px;"></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editHeroModal{{ $hero->id }}">Edit</button>
                                <form action="{{ route('admin.heroes.destroy', $hero->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $hero->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Hero Modal -->
                        <div class="modal fade" id="editHeroModal{{ $hero->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.heroes.update', $hero->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Cover</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="editHeroCover{{ $hero->id }}" class="form-label">Hero Cover</label>
                                                <input type="file" class="form-control" id="editHeroCover{{ $hero->id }}" name="cover">
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
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-5">
                {{ $heroes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Hero Modal -->
<div class="modal fade" id="addHeroModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.heroes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Cover</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addHeroCover" class="form-label">Hero Cover</label>
                        <input type="file" class="form-control" id="addHeroCover" name="cover" required>
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

@endsection
