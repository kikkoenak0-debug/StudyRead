# Halaman Laporan Pengembalian Buku (Terpisah dari Dashboard)

## Perubahan Struktur

Halaman laporan pengembalian buku telah dipindahkan dari tab di dashboard petugas menjadi halaman terpisah yang dapat diakses langsung.

## File yang Dibuat/Diubah

### 1. View Baru: resources/views/petugas/laporan.blade.php
Halaman dedicated untuk menampilkan semua laporan pengembalian buku dengan fitur:
- **Tabel Laporan** dengan kolom:
  - Nama Peminjam
  - Judul Buku
  - Tanggal Pengembalian
  - Kondisi Buku (badge: Baik/Rusak/Hilang)
  - Denda
  - Keterangan/Alasan Pengembalian

- **Search & Filter**:
  - Search by nama peminjam atau judul buku
  - Filter by kondisi buku (Baik/Rusak/Hilang)

- **Aksi**:
  - Tombol "Detail" untuk melihat detail laporan
  - Tombol "Ubah Denda" untuk menambah/mengubah denda (hanya jika denda = 0)

- **Modal Detail Laporan**: Menampilkan semua informasi laporan secara lengkap
- **Modal Ubah Denda**: Form untuk menambah/mengubah denda

### 2. Controller: app/Http/Controllers/PetugasController.php
**Method Baru:**
- `laporan()` - Menampilkan halaman laporan dengan data semua laporan pengembalian
- `ubahDenda(Request $request, Laporan $laporan)` - Mengubah denda laporan

**Perubahan di Method Existing:**
- `index()` - Dihapus bagian pengambilan data laporan (sebelumnya $laporanPengembalian)

### 3. Routes: routes/web.php
**Route Baru:**
```php
Route::get('/petugas/laporan', [PetugasController::class, 'laporan'])->middleware('petugas')->name('petugas.laporan');
Route::patch('/petugas/laporan/{laporan}/ubah-denda', [PetugasController::class, 'ubahDenda'])->middleware('petugas')->name('petugas.ubah-denda');
```

### 4. View: resources/views/petugas/dashboard.blade.php
**Perubahan:**
- Hapus tab "Laporan Pengembalian"
- Hapus section "Laporan Pengembalian" 
- Tambah link di navbar ke halaman laporan: `<a href="{{ route('petugas.laporan') }}">📋 Laporan Pengembalian</a>`
- Update script `showTab()` untuk hanya menangani 2 tab (Riwayat Transaksi & Konfirmasi Peminjaman)

## Navigasi

**Dashboard Petugas Navbar:**
```
📊 Dashboard | 📚 Kelola Buku | 📋 Laporan Pengembalian
```

Klik "📋 Laporan Pengembalian" untuk membuka halaman laporan.

## Fitur Halaman Laporan

### 1. Search & Filter
- **Search Box**: Cari berdasarkan nama peminjam atau judul buku
- **Filter Kondisi**: Filter laporan berdasarkan kondisi buku (Baik/Rusak/Hilang)
- Filter real-time saat mengetik/memilih

### 2. Tabel Laporan
- Menampilkan semua laporan pengembalian dengan pagination (10 per halaman)
- Status kondisi buku dengan badge berwarna:
  - Hijau (Baik)
  - Kuning (Rusak)
  - Merah (Hilang)
- Denda ditampilkan dalam format Rp

### 3. Aksi per Laporan
- **Tombol Detail**:
  - Membuka modal dengan detail lengkap laporan
  - Menampilkan: Peminjam, Buku, Tanggal, Kondisi, Denda, Keterangan

- **Tombol Ubah Denda** (hanya tampil jika denda = 0):
  - Membuka modal form untuk menambah/mengubah denda
  - Input validasi: minimal 0
  - Redirect ke halaman laporan setelah submit

## Database

### Tabel: laporan_pengembalian
```
- id
- pinjaman_id (FK)
- user_id (FK)
- buku_id (FK)
- tanggal_pengembalian
- kondisi_buku (baik/rusak/hilang)
- denda (integer)
- keterangan (text, nullable)
- created_at
- updated_at
```

## Alur Kerja

1. **Peminjam mengembalikan buku** → Laporan dibuat otomatis
2. **Petugas membuka halaman laporan** → Lihat semua laporan
3. **Petugas search/filter** → Cari laporan yang diperlukan
4. **Petugas klik "Detail"** → Lihat detail lengkap
5. **Petugas klik "Ubah Denda"** (jika perlu) → Tambah/ubah denda
6. **Laporan terupdate** → Denda tersimpan

## URL Halaman

- **Akses Halaman Laporan**: `/petugas/laporan`
- **Update Denda**: `PATCH /petugas/laporan/{laporan}/ubah-denda`

## Testing

1. Login sebagai petugas
2. Klik "📋 Laporan Pengembalian" di navbar
3. Lihat halaman laporan dengan tabel laporan pengembalian
4. Test search dan filter
5. Klik tombol "Detail" untuk melihat modal detail
6. Klik tombol "Ubah Denda" untuk mengubah denda
7. Verifikasi bahwa denda berhasil tersimpan
