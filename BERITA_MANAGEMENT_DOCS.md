# Dokumentasi Management Berita dengan CKEditor

## Fitur yang Telah Dibuat

### 1. Controller (BeritaController.php)
Lokasi: `app/Http/Controllers/Admin/BeritaController.php`

**Fungsi-fungsi:**
- `index()` - Menampilkan daftar semua berita dengan pagination
- `create()` - Menampilkan form tambah berita
- `store()` - Menyimpan berita baru dengan multiple images
- `edit()` - Menampilkan form edit berita
- `update()` - Update berita dan images
- `destroy()` - Hapus berita dan semua images
- `uploadImage()` - Upload gambar dari CKEditor

### 2. Routes
Lokasi: `routes/web.php`

```php
// Berita CRUD
Route::resource('berita', \App\Http\Controllers\Admin\BeritaController::class);
// CKEditor image upload
Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\BeritaController::class, 'uploadImage'])->name('ckeditor.upload');
```

### 3. Views

#### Index (index.blade.php)
- Tabel dengan kolom: #, Judul, Kategori, Deskripsi, Gambar, Tanggal, Aksi
- Button Tambah Berita
- Modal untuk melihat detail berita
- Tombol Edit dan Hapus dengan konfirmasi SweetAlert
- Pagination

#### Create (create.blade.php)
- Form dengan CKEditor untuk konten
- Upload multiple images dengan preview
- Dropdown kategori berita
- Field: Kategori, Judul, Deskripsi, Konten, Gambar

#### Edit (edit.blade.php)
- Form edit dengan data yang sudah ada
- Dapat menghapus gambar existing
- Upload gambar baru (multiple)
- Semua field dapat diupdate

## Fitur CKEditor

### Toolbar yang Tersedia:
1. **Heading** - Heading 1, 2, 3, dll
2. **Bold, Italic, Underline, Strikethrough** - Format teks
3. **Link** - Buat hyperlink
4. **Image Upload** - Upload gambar langsung ke server
5. **Block Quote** - Kutipan
6. **Bulleted & Numbered List** - Daftar
7. **Indent & Outdent** - Indentasi
8. **Table** - Insert tabel
9. **Media Embed** - Embed video (YouTube, dll)
10. **Undo & Redo**
11. **Text Alignment** - Rata kiri, tengah, kanan, justify
12. **Font Size & Font Family** - Ukuran dan jenis font
13. **Font Color & Background Color** - Warna teks dan background

### Upload Image di CKEditor:
- Klik icon "Image Upload" di toolbar
- Pilih gambar dari komputer
- Gambar akan diupload ke `storage/app/public/ckeditor/`
- Otomatis muncul di editor

## Multiple Images Upload

### Fitur:
1. User dapat memilih beberapa gambar sekaligus
2. Preview gambar sebelum upload
3. Dapat menghapus gambar dari preview sebelum submit
4. Pada edit, dapat menghapus gambar existing
5. Gambar disimpan di `storage/app/public/berita/`

## Cara Penggunaan

### 1. Akses Management Berita
URL: `http://your-domain.com/admin/berita`

### 2. Tambah Berita Baru
1. Klik tombol "Tambah Berita"
2. Pilih kategori
3. Masukkan judul berita
4. Masukkan deskripsi singkat (opsional)
5. Tulis konten menggunakan CKEditor:
   - Format teks dengan toolbar
   - Upload gambar dengan klik icon image
   - Tambah tabel, link, dll
6. Upload gambar tambahan (multiple)
7. Klik "Simpan Berita"

### 3. Edit Berita
1. Klik tombol "Edit" pada berita yang ingin diubah
2. Update field yang diperlukan
3. Hapus gambar lama jika perlu (klik X pada gambar)
4. Upload gambar baru jika perlu
5. Klik "Update Berita"

### 4. Hapus Berita
1. Klik tombol "Hapus"
2. Konfirmasi dengan SweetAlert
3. Berita dan semua gambarnya akan terhapus

### 5. Lihat Detail
1. Klik tombol "Lihat"
2. Modal akan menampilkan detail lengkap berita

## Validasi

### Field Required:
- Kategori Berita (required)
- Judul Berita (required)

### Field Optional:
- Deskripsi Singkat
- Konten
- Gambar

### Validasi Gambar:
- Format: JPEG, PNG, JPG, GIF
- Ukuran maksimal: 2MB per file
- Multiple upload diperbolehkan

## Storage

### Lokasi Penyimpanan:
1. **Gambar Berita Multiple**: `storage/app/public/berita/`
2. **Gambar dari CKEditor**: `storage/app/public/ckeditor/`

### Pastikan Storage Link Sudah Dibuat:
```bash
php artisan storage:link
```

## Model & Database

### Table: beritas
- id
- kategori_id (foreign key)
- judul
- slug (auto-generated dari judul)
- deskripsi
- konten (longText untuk CKEditor)
- timestamps

### Table: berita_images
- id
- berita_id (foreign key)
- path
- timestamps

## Tips & Best Practices

1. **Slug Otomatis**: Slug dibuat otomatis dari judul dan dijamin unique
2. **Cascade Delete**: Saat berita dihapus, semua gambarnya ikut terhapus
3. **Storage Management**: Gambar fisik di storage juga dihapus saat data dihapus
4. **Responsive**: Semua view responsive dan mobile-friendly
5. **User Friendly**: Preview gambar sebelum upload
6. **Konfirmasi Delete**: SweetAlert untuk konfirmasi sebelum hapus

## Troubleshooting

### Gambar tidak muncul:
```bash
php artisan storage:link
```

### CKEditor tidak muncul:
Pastikan file ada di: `public/ckeditor/ckeditor.js`

### Upload error:
1. Cek permission folder storage
2. Cek max upload size di php.ini
3. Cek validasi file type dan size

## Dependencies

- Laravel Framework
- CKEditor Classic (sudah include di project)
- Bootstrap 5
- SweetAlert 2
- Font Awesome / Bootstrap Icons

## Security

- CSRF Token protection pada semua form
- File validation untuk upload
- Authorization dengan middleware auth
- XSS protection dengan Laravel sanitization

---
**Dibuat pada**: 20 November 2025
**Versi**: 1.0
