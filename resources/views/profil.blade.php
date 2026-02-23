<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - StudyRead</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .profile-container {
            max-width: 100%;
            width: 100%;
            margin: 0;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .profile-header h2 {
            color: #1976d2;
            margin-bottom: 20px;
            font-size: 1.8em;
            margin-top: 0;
        }
        .profile-header p {
            color: #666;
            margin: 0;
            font-size: 0.95em;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            object-fit: cover;
            border: 4px solid #1976d2;
        }
        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            border: 4px solid #1976d2;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95em;
        }
        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-logout {
            background: #f44336;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            margin-top: 12px;
        }
        .btn-logout:hover {
            background: #d32f2f;
            transform: translateY(-2px);
        }
        .alert {
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 6px;
            border-left: 4px solid #4caf50;
        }
        .alert-success {
            background: #f1f8e9;
            color: #33691e;
        }
        html,body{height:100%;margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;background:var(--bg);color:#1f2937}
    </style>
</head>
<body>
    @include('components.user-sidebar')

    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" 
                         alt="Foto Profil" 
                         class="profile-avatar">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <h2>Edit Profil</h2>
                <p>Perbarui informasi akun Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background:#ffecec;color:#9b2c2c;padding:12px;border-radius:8px;margin-bottom:16px;">
                    <strong>Ada kesalahan:</strong>
                    <ul style="margin:8px 0 0 16px;padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', auth()->user()->name) }}" 
                           required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', auth()->user()->email) }}" 
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password Baru <span style="color: #999; font-weight: normal;">(Kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan password baru">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation"
                           placeholder="Konfirmasi password baru">
                </div>

                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           placeholder="Masukkan password saat ini jika mengganti password">
                </div>

                <div class="form-group">
                    <label for="foto">Foto Profil</label>
                    <input type="file" 
                           id="foto" 
                           name="foto" 
                           accept="image/*">
                </div>

                <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
            </form>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout" onclick="return confirm('Anda ingin keluar?')">🚪 Logout</button>
            </form>
        </div>
    </div>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>