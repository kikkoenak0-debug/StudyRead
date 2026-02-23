<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Admin</title>
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
    <nav class="navbar">
        <div class="logo-area">
            <h2>StudyRead</h2>
        </div>
        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
            <a href="{{ route('admin.kelola-pengguna.index') }}"> Kelola Pengguna</a>
            <a href="{{ route('buku.index') }}" class="active"> Buku</a>
            <hr>
        </nav>
    </nav>

    <main class="main-content">
        <div class="form-container">
            <h2>Tambah Buku Baru</h2>
            <form action="{{ route('buku.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}" required>
                </div>
                <div class="form-group">
                    <label for="tersedia">Jumlah Tersedia</label>
                    <input type="number" id="tersedia" name="tersedia" value="{{ old('tersedia') }}" required min="0">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Buku</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </main>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>