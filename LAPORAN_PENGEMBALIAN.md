# Fitur Laporan Pengembalian Buku

## Deskripsi
Fitur ini memungkinkan petugas perpustakaan untuk mencatat laporan ketika peminjam mengembalikan buku. Setiap pengembalian buku akan disimpan dalam database dengan detail lengkap seperti tanggal pengembalian, kondisi buku, denda (jika ada), dan keterangan tambahan.

## Komponen yang Ditambahkan

### 1. Migration Database
**File:** `database/migrations/2026_02_01_115521_create_laporan_pengembalian_table.php`

Membuat tabel `laporan_pengembalian` dengan struktur:
- `id` - Primary Key
- `pinjaman_id` - Foreign Key ke tabel pinjaman
- `user_id` - Foreign Key ke tabel users (peminjam)
- `buku_id` - Foreign Key ke tabel buku
- `tanggal_pengembalian` - Tanggal buku dikembalikan
- `denda` - Jumlah denda jika ada (default: 0)
- `keterangan` - Catatan tambahan
- `kondisi_buku` - Status kondisi (baik, rusak, hilang)
- `timestamps` - created_at dan updated_at

### 2. Model
**File:** `app/Models/Laporan.php`

Model untuk mengelola data laporan pengembalian dengan relasi ke:
- Pinjaman
- User
- Buku

### 3. Controller Method
**File:** `app/Http/Controllers/PetugasController.php`

**Method:** `catatPengembalian(Request $request, Pinjaman $pinjaman)`

Fitur:
- Validasi input (tanggal, kondisi buku, denda)
- Membuat record laporan pengembalian
- Update status pinjaman menjadi 'returned'
- Mengembalikan stok buku ke database

### 4. Route
**File:** `routes/web.php`

Route baru:
```php
Route::post('/petugas/catat-pengembalian/{pinjaman}', [PetugasController::class, 'catatPengembalian'])->middleware('petugas')->name('petugas.catat-pengembalian');
```

### 5. View Update
**File:** `resources/views/petugas/dashboard.blade.php`

Penambahan:
- Tab baru "Laporan Pengembalian" untuk menampilkan semua laporan yang telah dicatat
- Tombol "Catat Pengembalian" pada setiap peminjaman yang berstatus 'approved' atau 'paid'
- Modal form untuk input data pengembalian buku
- Tabel laporan dengan kolom:
  - Nama Peminjam
  - Judul Buku
  - Tanggal Pengembalian
  - Kondisi Buku (badge: baik/rusak/hilang)
  - Denda (dalam format Rp)
  - Keterangan

## Cara Penggunaan

### Untuk Petugas:

1. **Membuka Dashboard Petugas**
   - Login sebagai petugas
   - Akses Dashboard Petugas

2. **Mencatat Pengembalian Buku**
   - Di tab "Riwayat Transaksi", lihat semua peminjaman
   - Cari peminjaman dengan status "approved" atau "paid"
   - Klik tombol "Catat Pengembalian"
   - Isi form dengan detail:
     - Tanggal Pengembalian (otomatis isi hari ini)
     - Kondisi Buku (baik/rusak/hilang)
     - Denda (jika ada, default 0)
     - Keterangan (opsional)
   - Klik "Simpan Laporan"

3. **Melihat Laporan Pengembalian**
   - Klik tab "Laporan Pengembalian"
   - Semua laporan pengembalian buku akan ditampilkan
   - Laporan disortir dari yang terbaru

## Data yang Tersimpan

Setiap laporan pengembalian menyimpan:
- Informasi peminjam (nama, ID)
- Informasi buku (judul, ID)
- Tanggal pengembalian
- Kondisi buku saat dikembalikan
- Jumlah denda (jika ada kerusakan atau keterlambatan)
- Catatan tambahan dari petugas
- Timestamp (kapan laporan dibuat/diupdate)

## Status Pinjaman

Ketika laporan pengembalian dicatat:
- Status pinjaman berubah dari 'approved'/'paid' menjadi 'returned'
- Stok buku otomatis bertambah 1

## Fitur Tambahan

- **Validasi Input:** Semua input divalidasi sebelum disimpan
- **Pagination:** Laporan ditampilkan dengan pagination (10 per halaman)
- **Status Badge:** Kondisi buku ditampilkan dengan badge berwarna untuk visual clarity
- **Modal Dialog:** Form pengembalian menggunakan modal untuk UX yang lebih baik

## Database Relationship

```
Laporan
├── belongsTo(Pinjaman)
├── belongsTo(User) - Peminjam
└── belongsTo(Buku)

Pinjaman
└── hasMany(Laporan)

User
└── hasMany(Laporan)

Buku
└── hasMany(Laporan)
```

## Query Contoh

Mendapatkan semua laporan pengembalian dengan informasi lengkap:
```php
$laporan = Laporan::with(['user', 'buku', 'pinjaman'])->latest()->get();
```

Mendapatkan laporan berdasarkan kondisi buku:
```php
$laporanRusak = Laporan::where('kondisi_buku', 'rusak')->get();
```

Mendapatkan total denda dari bulan ini:
```php
$totalDenda = Laporan::whereMonth('created_at', now()->month)->sum('denda');
```

## Testing

Untuk menguji fitur:
1. Login sebagai petugas
2. Buat peminjaman dengan status 'approved'
3. Klik "Catat Pengembalian"
4. Isi form dan simpan
5. Lihat laporan di tab "Laporan Pengembalian"
6. Verifikasi bahwa status pinjaman berubah menjadi 'returned'
