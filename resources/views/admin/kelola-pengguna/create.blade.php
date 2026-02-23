<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Admin</title>
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
            <a href="{{ route('admin.kelola-pengguna.index') }}" class="active"> Kelola Pengguna</a>
            <a href="{{ route('admin.kelola-buku.index') }}"> Kelola Buku</a>
            <hr>
        </nav>
         <div class="user-action">
            <div class="profile-menu" id="profileToggle">
                <div class="profile-info">
                    <span id="userName">{{ auth()->user()->name }}</span>
                    <small>Administrator</small>
                </div>
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <div class="avatar">A</div>
                @endif
                <div class="dropdown-content" id="profileDropdown">
                    <form action="/logout" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" onclick="return confirm('Anda ingin keluar?')" style="background: none; border: none; color: inherit; cursor: pointer;">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="form-container">
            <h2>Tambah Pengguna</h2>
            <form action="{{ route('admin.kelola-pengguna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kelola-pengguna.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </main>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>