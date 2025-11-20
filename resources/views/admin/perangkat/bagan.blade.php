@extends('layouts.admin')
@section('title', 'Bagan Perangkat Desa')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Bagan Perangkat Desa</h4>
            <a href="{{ route('admin.perangkat.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="card-body">
            <p class="text-muted">Bagan ini menampilkan struktur hirarki berdasarkan parent_id.</p>

            <div class="tree-container">
                @if($roots->count())
                    <ul class="tree-root">
                        @foreach($roots as $root)
                            @include('admin.perangkat._node', ['node' => $root])
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Belum ada data perangkat.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Simple tree styles */
.tree-container { display: flex; justify-content: center; }
.tree-root, .tree-root ul { list-style: none; margin: 0; padding: 0; }
.tree-root { display: inline-block; }
.tree-root li { margin: 0 auto; padding: 10px 5px; position: relative; }

/* Connector lines */
.tree-root li::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 16px;
    background: #dee2e6;
}
.children { display: flex; justify-content: center; gap: 24px; margin-top: 18px; padding-left: 0; position: relative; }
.children::before {
    content: '';
    position: absolute;
    top: 8px;
    left: 10%;
    right: 10%;
    height: 2px;
    background: #dee2e6;
}

.node-box { display: flex; flex-direction: row; align-items: center; gap: 12px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05); min-width: 260px; }
.node-box .photo { width: 100px; height: 100px; border-radius: 6px; overflow: hidden; flex-shrink: 0; }
.node-box .photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
.node-box .initials { width: 100px; height: 100px; border-radius: 6px; display:flex; align-items:center; justify-content:center; background:#e9ecef; color:#495057; font-weight:700; font-size:28px; }
.node-box .info { display:flex; flex-direction:column; align-items:flex-start; width:100%; }
.node-box .name { font-weight:700; font-size:1.05rem; padding-bottom:8px; width:100%; }
.node-box .divider { width:100%; height:1px; background:#e9ecef; }
.node-box .jabatan { color: #6c757d; margin-top:8px; }
</style>
@endpush

@endsection
