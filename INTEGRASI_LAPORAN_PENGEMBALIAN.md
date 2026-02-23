# Integrasi Laporan Pengembalian Dari Sisi Peminjam

## Perubahan yang Dilakukan

Ketika peminjam mengembalikan buku melalui halaman **Detail Riwayat Peminjaman**, sistem akan otomatis membuat laporan pengembalian yang tersimpan di database dan dapat dilihat oleh petugas di dashboard petugas.

## File yang Dimodifikasi

### 1. routes/web.php
**Endpoint:** `POST /riwayat-pinjaman/{id}/kembalikan`

**Perubahan:**
- Menambahkan import untuk model `Laporan`
- Menambahkan fungsi untuk membuat record laporan pengembalian
- Mapping kondisi buku dari form peminjam ke status laporan:
  - `sangat_baik` → `baik`
  - `baik` → `baik`
  - `cukup` → `rusak`
  - `kurang` → `rusak`

**Data yang Disimpan:**
```php
Laporan::create([
    'pinjaman_id' => $pinjaman->id,
    'user_id' => $pinjaman->user_id,
    'buku_id' => $pinjaman->buku_id,
    'tanggal_pengembalian' => now()->toDateString(),
    'kondisi_buku' => $kondisiLaporan,
    'denda' => 0,
    'keterangan' => request('catatan'),
]);
```

### 2. resources/views/detail_riwayat_pinjaman.blade.php
**Perubahan:**
- Mengubah label "Catatan (Opsional)" menjadi "Alasan/Catatan Pengembalian (Opsional)"
- Mengubah placeholder dari "Contoh: Halaman 45 sobek, dll..." menjadi "Contoh: Halaman 45 sobek, buku tidak seru, dll..."
- Ini memberikan kejelasan kepada peminjam bahwa mereka bisa memberikan alasan mengapa mengembalikan buku (rusak, tidak seru, dll)

## Flow Pengembalian Buku

```
1. Peminjam membuka halaman Detail Riwayat Peminjaman
   ↓
2. Peminjam klik "Kembalikan Buku"
   ↓
3. Modal terbuka dengan form:
   - Kondisi Buku (sangat baik, baik, cukup, kurang)
   - Alasan/Catatan Pengembalian
   ↓
4. Peminjam submit form
   ↓
5. Sistem melakukan:
   a. Validasi status pinjaman (harus approved atau paid)
   b. Update status pinjaman menjadi 'returned'
   c. Kembalikan stok buku +1
   d. BARU: Buat laporan pengembalian di tabel laporan_pengembalian
   ↓
6. Laporan tersimpan dan bisa dilihat petugas di dashboard
```

## Data yang Tersimpan di Laporan

Ketika peminjam mengembalikan buku:
- **Peminjam:** Nama dan ID peminjam
- **Buku:** Judul dan ID buku
- **Tanggal Pengembalian:** Hari saat peminjam melakukan pengembalian
- **Kondisi Buku:** 
  - `baik` jika peminjam memilih "Sangat Baik" atau "Baik"
  - `rusak` jika peminjam memilih "Cukup" atau "Kurang"
- **Denda:** Default 0 (petugas bisa menambahkan denda jika ada)
- **Keterangan:** Alasan pengembalian dari peminjam

## Akses Laporan

Petugas dapat melihat laporan pengembalian di:
- Dashboard Petugas → Tab "Laporan Pengembalian"
- Laporan ditampilkan dalam tabel dengan semua detail:
  - Nama Peminjam
  - Judul Buku
  - Tanggal Pengembalian
  - Kondisi Buku (dengan badge berwarna)
  - Denda
  - Keterangan/Alasan Pengembalian

## Keuntungan Integrasi Ini

1. **Otomatis:** Laporan dibuat secara otomatis tanpa perlu petugas mencatat ulang
2. **Akurat:** Data langsung dari peminjam tentang kondisi buku
3. **Audit Trail:** Semua pengembalian tercatat dengan detail lengkap
4. **Manajemen Stok:** Stok buku otomatis terupdate
5. **Transparansi:** Petugas tahu kapan dan bagaimana kondisi buku yang dikembalikan
