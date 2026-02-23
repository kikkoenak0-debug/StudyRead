<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo-area"><h2>StudyRead</h2></div>
        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}"> Dashboard</a>
            <a href="{{ route('admin.kategori.index') }}" class="active"> Kelola Kategori</a>
            <a href="{{ route('admin.kelola-buku.index') }}"> Kelola Buku</a>
            <hr>
        </nav>
        <div class="user-action">
            <div class="profile-menu">
                <div class="profile-info">
                    <span id="userName">{{ auth()->user()->name }}</span>
                    <small>Administrator</small>
                </div>
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" class="avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <div class="avatar">A</div>
                @endif
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container" style="max-width: 600px;">
            <h1>✏️ Edit Kategori</h1>

            @if($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama">📝 Nama Kategori</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" placeholder="Contoh: Fiksi, Non-fiksi, Teknologi" required autofocus>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn">💾 Simpan Perubahan</button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">❌ Batal</a>
                    </div>
                </form>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e0e0e0;">
                
                <div style="background: #f0f7ff; padding: 15px; border-radius: 8px; margin-top: 20px;">
                    <p style="margin: 0; color: #00008B;"><strong>ℹ️ Catatan:</strong> Perubahan nama kategori akan diterapkan ke semua buku yang menggunakan kategori ini.</p>
                    <p style="margin: 10px 0 0 0; font-size: 13px; color: #666;">
                        <a href="{{ route('admin.kelola-buku.index') }}" style="color: #2196f3; text-decoration: none;">Pergi ke Kelola Buku →</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

