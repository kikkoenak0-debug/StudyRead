<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <div class="container" style="max-width: 600px; margin: 40px auto; display: flex; flex-direction: column; align-items: center;">
            <h1>➕ Tambah Kategori Baru</h1>

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
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">📝 Nama Kategori</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Fiksi, Non-fiksi, Teknologi" required autofocus>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 30px;">
                        <button type="submit" class="btn">💾 Simpan Kategori</button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">❌ Batal</a>
                    </div>
                </form>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e0e0e0;">
                
                <div style="background: #f0f7ff; padding: 15px; border-radius: 8px; margin-top: 20px;">
                    <p style="margin: 0; color: #00008B;"><strong>💡 Tips:</strong> Setelah menambah kategori, Anda bisa langsung menggunakannya saat menambah atau mengedit buku.</p>
                    <p style="margin: 10px 0 0 0; font-size: 13px; color: #666;">
                        <a href="{{ route('admin.kelola-buku.index') }}" style="color: #2196f3; text-decoration: none;">Pergi ke Kelola Buku →</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

