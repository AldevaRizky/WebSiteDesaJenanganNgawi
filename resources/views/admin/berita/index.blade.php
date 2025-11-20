@extends('layouts.admin')
@section('title', 'Berita Management')

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

            {{-- Success Alert --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                    });
                </script>
            @endif

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

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($beritas as $berita)
                        <tr>
                            <td>{{ $loop->iteration + ($beritas->currentPage() - 1) * $beritas->perPage() }}</td>
                            <td>
                                @if($berita->images->first())
                                    <img src="{{ asset('storage/' . $berita->images->first()->path) }}" 
                                         alt="thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ Str::limit($berita->judul, 50) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit(strip_tags($berita->deskripsi), 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $berita->kategori->nama }}</span>
                            </td>
                            <td>{{ $berita->created_at->format('d M Y') }}</td>
                            <td>
                                {{-- Edit Button --}}
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBeritaModal{{ $berita->id }}">
                                    Edit
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-sm btn-delete"
                                            data-id="{{ $berita->id }}">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Edit Modal for Each Berita --}}
                        <div class="modal fade" id="editBeritaModal{{ $berita->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                <select name="kategori_id" class="form-select" required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($kategoris as $kategori)
                                                        <option value="{{ $kategori->id }}" 
                                                            {{ $berita->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                            {{ $kategori->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="judul" 
                                                       value="{{ $berita->judul }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Subjudul</label>
                                                <input type="text" class="form-control" name="subjudul" value="{{ $berita->subjudul ?? '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"></label>Deskripsi Singkat</label>
                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $berita->deskripsi }}</textarea>
                                                <small class="text-muted">Ringkasan berita yang akan ditampilkan di list</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Konten Berita</label>

                                                <div class="card p-2">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <small class="text-muted">Gunakan toolbar editor untuk formatting (bold, italic, link).</small>
                                                        </div>
                                                        <div class="text-muted"><small><span class="editor-char-count">0</span> chars</small></div>
                                                    </div>

                                                    <textarea name="konten" class="tinymce-editor enhanced-editor">{{ $berita->konten }}</textarea>
                                                </div>
                                            </div>

                                            {{-- Existing Images --}}
                                            @if($berita->images->count() > 0)
                                            <div class="mb-3">
                                                <label class="form-label">Gambar Saat Ini</label>
                                                <div class="d-flex flex-wrap gap-2" id="existingImages{{ $berita->id }}">
                                                    @foreach($berita->images as $image)
                                                    <div class="position-relative image-preview-item" data-image-id="{{ $image->id }}">
                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Image">
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-existing-image"
                                                                data-image-id="{{ $image->id }}"
                                                                style="padding: 2px 6px; font-size: 12px;">
                                                            ×
                                                        </button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            <div class="mb-3">
                                                <label class="form-label">Tambah Gambar Baru</label>
                                                <input type="file" class="form-control image-input" 
                                                       name="images[]" multiple accept="image/*" 
                                                       data-preview="imagePreviewEdit{{ $berita->id }}">
                                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB per gambar</small>
                                                
                                                <div id="imagePreviewEdit{{ $berita->id }}" class="mt-3 d-flex flex-wrap gap-2"></div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning me-2">Perbarui</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach

                        @if($beritas->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data berita</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $beritas->links() }}
            </div>

        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addBeritaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subjudul</label>
                        <input type="text" class="form-control" name="subjudul" value="{{ old('subjudul') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        <small class="text-muted">Ringkasan berita yang akan ditampilkan di list</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten Berita</label>

                        <div class="card p-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <small class="text-muted">Masukkan konten berita di sini. Gunakan toolbar untuk <strong>bold</strong>, <em>italic</em> dan <a href="#">link</a>.</small>
                                </div>
                                <div class="text-muted"><small><span class="editor-char-count">0</span> chars</small></div>
                            </div>

                            <textarea name="konten" id="kontenAdd" class="tinymce-editor enhanced-editor"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Gambar (Multiple)</label>
                        <input type="file" class="form-control image-input" name="images[]" 
                               multiple accept="image/*" data-preview="imagePreviewAdd">
                        <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB per gambar</small>
                        
                        <div id="imagePreviewAdd" class="mt-3 d-flex flex-wrap gap-2"></div>
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

@push('styles')
<style>
    .image-preview-item {
        position: relative;
        width: 140px;
        height: 100px;
        border-radius: 6px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e6e6e6;
    }
    .image-preview-item .remove-preview {
        background: rgba(0,0,0,0.6);
        color: #fff;
        border: none;
        line-height: 1;
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* CKEditor 4 Custom Styling - Word-like appearance */
    .cke_chrome {
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
    }
    
    .cke_top {
        background: linear-gradient(to bottom, #f9fafb 0%, #f3f4f6 100%) !important;
        border-bottom: 1px solid #ddd !important;
        padding: 6px 8px !important;
        border-radius: 6px 6px 0 0 !important;
    }
    
    .cke_toolbar {
        margin-bottom: 4px !important;
    }
    
    .cke_button {
        background: transparent !important;
        border: 1px solid transparent !important;
        border-radius: 4px !important;
        margin: 1px !important;
    }
    
    .cke_button:hover {
        background: #e5e7eb !important;
        border-color: #d1d5db !important;
    }
    
    .cke_button_on {
        background: #dbeafe !important;
        border-color: #93c5fd !important;
    }
    
    .cke_button_icon {
        filter: brightness(0.3);
    }
    
    .cke_button:hover .cke_button_icon {
        filter: brightness(0);
    }
    
    .cke_contents {
        border-radius: 0 0 6px 6px !important;
        background: #ffffff !important;
    }
    
    .cke_bottom {
        background: #f9fafb !important;
        border-top: 1px solid #e5e7eb !important;
        padding: 4px 8px !important;
        border-radius: 0 0 6px 6px !important;
    }
    
    /* Content area styling */
    .cke_editable {
        padding: 15px !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        font-size: 14px !important;
        line-height: 1.6 !important;
    }
    
    .cke_editable img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .cke_editable table {
        border-collapse: collapse;
        width: 100%;
    }
    
    .cke_editable table td,
    .cke_editable table th {
        border: 1px solid #ddd;
        padding: 8px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor 4 - From CDN (Full Package with all plugins) -->
<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

<script>
    // CKEditor Configuration
    const ckEditorConfig = {
        // Full toolbar with ALL features (organized like Microsoft Word)
        toolbar: [
            { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
            '/',
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            '/',
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ],
        extraPlugins: 'justify,font,colorbutton,panelbutton,floatpanel,panel,listblock,richcombo,find,selectall,clipboard,wysiwygarea,elementspath',
        filebrowserUploadUrl: '{{ route("admin.ckeditor.upload") }}?_token={{ csrf_token() }}',
        filebrowserUploadMethod: 'form',
        uploadUrl: '{{ route("admin.ckeditor.upload") }}?_token={{ csrf_token() }}',
        height: 400,
        allowedContent: true,
        extraAllowedContent: '*(*);*{*}',
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        font_names: 'Arial/Arial, Helvetica, sans-serif;' +
            'Comic Sans MS/Comic Sans MS, cursive;' +
            'Courier New/Courier New, Courier, monospace;' +
            'Georgia/Georgia, serif;' +
            'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
            'Tahoma/Tahoma, Geneva, sans-serif;' +
            'Times New Roman/Times New Roman, Times, serif;' +
            'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
            'Verdana/Verdana, Geneva, sans-serif',
        fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px',
        pasteFromWordRemoveFontStyles: false,
        pasteFromWordRemoveStyles: false,
        language: 'en',
        contentsCss: ['{{ asset('ckeditor/contents.css') }}']
    };

    // Initialize CKEditor 4 for all enhanced editors
    document.addEventListener('DOMContentLoaded', function() {
        const editorMap = new Map();

        // Function to initialize CKEditor on a textarea
        function initCKEditor(textarea) {
            // Ensure element has an id
            if (!textarea.id) textarea.id = 'editor_' + Math.random().toString(36).substr(2,9);

            // Skip if already initialized
            if (CKEDITOR.instances[textarea.id]) {
                return CKEDITOR.instances[textarea.id];
            }

            const editor = CKEDITOR.replace(textarea.id, ckEditorConfig);
                // Full toolbar with ALL features (organized like Microsoft Word)
                toolbar: [
                    { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                    { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                    { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                    '/',
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
                    { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                    '/',
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                    { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
                ],

                // Extra plugins untuk fitur lengkap
                extraPlugins: 'justify,font,colorbutton,panelbutton,floatpanel,panel,listblock,richcombo,find,selectall,clipboard,wysiwygarea,elementspath',

                // Upload image configuration
                filebrowserUploadUrl: '{{ route("admin.ckeditor.upload") }}?_token={{ csrf_token() }}',
                filebrowserUploadMethod: 'form',

                // Image upload settings
                uploadUrl: '{{ route("admin.ckeditor.upload") }}?_token={{ csrf_token() }}',

                // Height
                height: 400,

                // Remove elements path at bottom
                removePlugins: '',

                // Allow all content
                allowedContent: true,

                // Disable Advanced Content Filter (ACF)
                extraAllowedContent: '*(*);*{*}',

                // Format tags
                format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',

                // Font names
                font_names: 'Arial/Arial, Helvetica, sans-serif;' +
                    'Comic Sans MS/Comic Sans MS, cursive;' +
                    'Courier New/Courier New, Courier, monospace;' +
                    'Georgia/Georgia, serif;' +
                    'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
                    'Tahoma/Tahoma, Geneva, sans-serif;' +
                    'Times New Roman/Times New Roman, Times, serif;' +
                    'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
                    'Verdana/Verdana, Geneva, sans-serif',

                // Font sizes
                fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px',

                // Paste from Word
                pasteFromWordRemoveFontStyles: false,
                pasteFromWordRemoveStyles: false,

            // Store editor instance
            editorMap.set(textarea.id, editor);
            textarea.__ckEditorInstance = editor;

            // Character count update
            const container = textarea.closest('.card');
            const charCountEl = container ? container.querySelector('.editor-char-count') : null;

            if (charCountEl) {
                editor.on('change', function() {
                    const data = editor.getData();
                    const text = data.replace(/<[^>]*>/g, '').trim();
                    charCountEl.textContent = text.length;
                });

                // Initial count
                editor.on('instanceReady', function() {
                    const data = editor.getData();
                    const text = data.replace(/<[^>]*>/g, '').trim();
                    charCountEl.textContent = text.length;
                });
            }

            return editor;
        }

        // Initialize CKEditor for Add modal when modal is shown
        const addModal = document.getElementById('addBeritaModal');
        if (addModal) {
            addModal.addEventListener('shown.bs.modal', function() {
                const textarea = document.querySelector('#kontenAdd');
                if (textarea && !CKEDITOR.instances[textarea.id]) {
                    // Small delay to ensure modal is fully visible
                    setTimeout(function() {
                        initCKEditor(textarea);
                    }, 100);
                }
            });
        }

        // Initialize CKEditor for Edit modals when they are shown
        document.querySelectorAll('[id^="editBeritaModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const textarea = this.querySelector('.enhanced-editor');
                if (textarea) {
                    // Ensure element has ID
                    if (!textarea.id) {
                        textarea.id = 'editor_' + Math.random().toString(36).substr(2,9);
                    }
                    
                    // Destroy existing instance if any
                    if (CKEDITOR.instances[textarea.id]) {
                        CKEDITOR.instances[textarea.id].destroy(true);
                    }
                    
                    // Small delay to ensure modal is fully visible
                    setTimeout(function() {
                        initCKEditor(textarea);
                    }, 100);
                }
            });

            // Destroy editor when modal is hidden to prevent memory leaks
            modal.addEventListener('hidden.bs.modal', function() {
                const textarea = this.querySelector('.enhanced-editor');
                if (textarea && CKEDITOR.instances[textarea.id]) {
                    CKEDITOR.instances[textarea.id].destroy(true);
                }
            });
        });

        // On form submit, update textarea with CKEditor data
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Update all CKEditor instances before submit
                for (const instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
        });
    });

    // Image Preview Handler (robust)
    // Keeps an in-memory array of files per input so we can remove single files and sync input.files.
    (function() {
        const fileStore = new Map(); // input element -> Array<File>

        function ensurePreviewContainer(input) {
            const previewId = input.getAttribute('data-preview');
            let preview = document.getElementById(previewId);
            if (!preview) {
                preview = document.createElement('div');
                preview.id = previewId || ('preview_' + Math.random().toString(36).slice(2,8));
                preview.className = 'mt-3 d-flex flex-wrap gap-2';
                input.parentNode.appendChild(preview);
            }
            return preview;
        }

        function renderPreviews(input) {
            const files = fileStore.get(input) || [];
            const preview = ensurePreviewContainer(input);
            preview.innerHTML = '';

            files.forEach((file, idx) => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item position-relative';
                    div.setAttribute('data-file-index', idx);
                    div.innerHTML = `
                        <img src="${ev.target.result}" alt="Preview ${idx + 1}">
                        <button type="button" class="btn btn-danger btn-sm remove-preview position-absolute top-0 end-0 m-1" style="padding: 2px 6px; font-size: 12px;">×</button>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function syncInputFiles(input) {
            const files = fileStore.get(input) || [];
            try {
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                input.files = dt.files;
            } catch (err) {
                // DataTransfer may not be available in some environments; fallback: cannot fully sync
                // but at least leave the input as-is. (Most modern browsers support DataTransfer.)
                console.warn('DataTransfer not available, cannot fully sync input.files', err);
            }
        }

        // When files are selected
        document.addEventListener('change', function(e) {
            const input = e.target;
            if (!input || !input.classList || !input.classList.contains('image-input')) return;

            const files = Array.from(input.files || []);
            fileStore.set(input, files);
            syncInputFiles(input);
            renderPreviews(input);
        });

        // Delegated remove button handler
        document.addEventListener('click', function(e) {
            const btn = e.target.closest && e.target.closest('.remove-preview');
            if (!btn) return;

            const previewItem = btn.closest('.image-preview-item');
            if (!previewItem) return;

            // find associated preview container and the input it belongs to
            const preview = previewItem.parentNode;
            const previewId = preview.id;
            // find the input that references this previewId
            const input = Array.from(document.querySelectorAll('.image-input')).find(i => i.getAttribute('data-preview') === previewId);
            if (!input) return;

            const idx = Number(previewItem.getAttribute('data-file-index'));
            const files = fileStore.get(input) || [];
            if (isNaN(idx) || idx < 0 || idx >= files.length) return;

            files.splice(idx, 1); // remove the file
            fileStore.set(input, files);
            syncInputFiles(input);
            renderPreviews(input);
        });

        // When a modal is hidden, clear its stored files for the inputs inside it
        document.addEventListener('hidden.bs.modal', function(e) {
            const modal = e.target;
            if (!modal) return;
            const inputs = modal.querySelectorAll('.image-input');
            inputs.forEach(input => {
                fileStore.delete(input);
                // ensure preview cleared
                const previewId = input.getAttribute && input.getAttribute('data-preview');
                const preview = previewId ? document.getElementById(previewId) : null;
                if (preview) preview.innerHTML = '';
                try { input.value = ''; } catch (err) {
                    const newInput = input.cloneNode();
                    input.parentNode.replaceChild(newInput, input);
                }
            });
        }, true);
    })();

    // Delete Confirmation for Berita
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data berita dan semua gambarnya akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });

    // Delete Existing Image
    document.querySelectorAll('.delete-existing-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            
            Swal.fire({
                title: 'Hapus gambar?',
                text: "Gambar akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/berita/image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            document.querySelector(`[data-image-id="${imageId}"]`).remove();
                            Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus gambar.', 'error');
                    });
                }
            });
        });
    });

    // Clear Add modal previews and inputs when modal is hidden so previews don't persist unexpectedly
    var addModalEl = document.getElementById('addBeritaModal');
    if (addModalEl) {
        addModalEl.addEventListener('hidden.bs.modal', function () {
            const input = addModalEl.querySelector('.image-input');
            if (input) {
                try {
                    input.value = '';
                } catch (err) {
                    // some browsers disallow setting value for file input via JS in certain contexts
                    const newInput = input.cloneNode();
                    input.parentNode.replaceChild(newInput, input);
                }

                const previewId = (input.getAttribute && input.getAttribute('data-preview')) || 'imagePreviewAdd';
                const preview = document.getElementById(previewId);
                if (preview) preview.innerHTML = '';
            }
        });
    }

    // Re-open modal if validation error
    @if ($errors->any())
        @if(old('_method') == 'PUT')
            // Edit modal - you need to determine which one
        @else
            // Add modal
            var addModal = new bootstrap.Modal(document.getElementById('addBeritaModal'));
            addModal.show();
        @endif
    @endif
</script>
@endpush