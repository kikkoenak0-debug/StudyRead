<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    @include('components.petugas-sidebar')

    <main class="main-content">
        <div class="form-container">
            <h2>Edit Buku</h2>
            <form action="{{ route('petugas.kelola-buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required>
                </div>
                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" placeholder="Contoh: Gramedia">
                </div>
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="date" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ? \Carbon\Carbon::parse($buku->tahun_terbit)->format('Y-m-d') : '') }}" placeholder="Contoh: 2021">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}" required>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tersedia">Jumlah Tersedia</label>
                    <input type="number" id="tersedia" name="tersedia" value="{{ old('tersedia', $buku->tersedia) }}" required min="0">
                </div>
                <div class="form-group">
                    <label for="sinopsis">Sinopsis</label>
                    <textarea id="sinopsis" name="sinopsis" rows="4" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Buku</label>
                    @if($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="Foto Buku" style="max-width: 100px; margin-bottom: 10px;">
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <small>Jika tidak diubah, biarkan kosong.</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('petugas.kelola-buku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </main>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>