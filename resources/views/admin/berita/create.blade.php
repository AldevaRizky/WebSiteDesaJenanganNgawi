@extends('layouts.admin')
@section('title', 'Tambah Berita')
@section('content')

<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Tambah Berita Baru</h4>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            {{-- Validation Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Kategori Berita <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               required
                               placeholder="Masukkan judul berita">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3"
                                  placeholder="Masukkan deskripsi singkat berita (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Deskripsi singkat akan ditampilkan di halaman daftar berita</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Konten Berita</label>
                        <textarea name="konten" 
                                  id="editor" 
                                  class="form-control @error('konten') is-invalid @enderror">{{ old('konten') }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Gunakan toolbar untuk memformat konten dan upload gambar</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Upload Gambar (Multiple)</label>
                        <input type="file" 
                               class="form-control @error('images.*') is-invalid @enderror" 
                               name="images[]" 
                               id="images"
                               accept="image/*"
                               multiple>
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Anda dapat memilih beberapa gambar sekaligus (Format: JPEG, PNG, JPG, GIF. Max: 2MB per file)</small>
                        
                        {{-- Image Preview --}}
                        <div id="imagePreview" class="mt-3 row"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Berita
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('styles')
<style>
    .image-preview-item {
        position: relative;
        display: inline-block;
    }
    .image-preview-item img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ck-editor__editable {
        min-height: 400px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor 4.22 Full version from CDN -->
<script src="https://cdn.ckeditor.com/4.22.0/full/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Disable version check warning
        CKEDITOR.config.versionCheck = false;
        
        // Initialize CKEditor 4
        CKEDITOR.replace('editor', {
            height: 400,
            versionCheck: false, // Disable security warning
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
            filebrowserUploadMethod: 'form',
            filebrowserImageUploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
            uploadUrl: "{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}",
            
            // Toolbar configuration - lengkap dengan bold, italic, dll
            toolbarGroups: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                '/',
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            
            // Remove unused buttons
            removeButtons: 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,PageBreak,Iframe,ShowBlocks,About',
            
            // Allow all content
            allowedContent: true,
            
            // Remove dialog tabs
            removeDialogTabs: 'image:advanced;link:advanced'
        });
        
        console.log('CKEditor initialized successfully');
    });

    // Image preview for multiple images
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        files.forEach((file, index) => {
            if (file && file.type.startsWith('image/')) {
                selectedFiles.push(file);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-2 mb-2';
                    
                    const previewItem = document.createElement('div');
                    previewItem.className = 'image-preview-item';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '×';
                    removeBtn.type = 'button';
                    removeBtn.onclick = function() {
                        const fileIndex = selectedFiles.indexOf(file);
                        if (fileIndex > -1) {
                            selectedFiles.splice(fileIndex, 1);
                        }
                        col.remove();
                        updateFileInput();
                    };
                    
                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    col.appendChild(previewItem);
                    imagePreview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => {
            dt.items.add(file);
        });
        imageInput.files = dt.files;
    }
</script>
@endpush

@endsection
