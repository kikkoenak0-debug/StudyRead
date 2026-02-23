<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - StudyRead</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .about-container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            box-sizing: border-box;
        }
        .about-header {
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
        }
        .about-header h1 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        .about-section {
            margin-bottom: 30px;
            width: 100%;
            text-align: center;
        }
        .about-section h2 {
            color: #333;
            border-bottom: 2px solid #e3f2fd;
            padding-bottom: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
        .about-section p {
            line-height: 1.6;
            color: #555;
            text-align: center;
        }
        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .feature-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .feature-item h3 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        .copyright {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            width: 100%;
        }
         html,body{height:100%;margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:var(--bg); color:#1f2937; overflow-x: hidden;}
        .navbar{display:flex;align-items:center;justify-content:space-between;padding:14px 22px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff}
        .logo-area h2{margin:0;font-weight:700;color:var(--primary);letter-spacing:0.2px;transition:transform .45s ease}
        .logo-animate{transform:translateY(-3px) scale(1.03);}
        .nav-links{display:flex;gap:12px;align-items:center}
        .nav-links a{color:rgba(255,255,255,0.95);text-decoration:none;padding:8px 12px;border-radius:8px;transition:background .18s, color .18s}
        .nav-links a.active, .nav-links a:hover{background:rgba(255,255,255,0.10);color:#ffffff}
        .profile-menu{display:flex;align-items:center;gap:10px;position:relative}
        .avatar{width:40px;height:40px;border-radius:50%;object-fit:cover;background:linear-gradient(135deg,#fff,#eee);display:inline-block}
        .profile-info{display:flex;flex-direction:column;line-height:1}
        .profile-info span{font-weight:600}
        .dropdown-content{position:absolute;right:0;top:56px;background:var(--card);padding:8px;border-radius:8px;box-shadow:0 8px 24px rgba(16,24,40,0.08);display:none}
        .profile-menu:hover .dropdown-content{display:block}
    </style>
</head>
<body>
    @include('components.user-sidebar')

    <main class="main-content">
        <div class="about-container">
            <div class="about-header">
                <h1>Tentang StudyRead</h1>
                <p>Sistem Perpustakaan Modern untuk Semua</p>
            </div>

            <div class="about-section">
                <h2>Apa itu StudyRead?</h2>
                <p>StudyRead adalah platform perpustakaan digital yang dirancang untuk memudahkan akses ke berbagai koleksi buku. Dengan antarmuka yang user-friendly dan fitur-fitur canggih, StudyRead memungkinkan pengguna untuk menjelajahi, meminjam, dan mengelola buku favorit mereka dengan mudah.</p>
            </div>

            <div class="about-section">
                <h2>Fitur Utama</h2>
                <div class="features-list">
                    <div class="feature-item">
                        <h3>📚 Koleksi Buku Lengkap</h3>
                        <p>Akses ribuan judul buku dari berbagai kategori dan genre.</p>
                    </div>
                    <div class="feature-item">
                        <h3>🔍 Pencarian Cepat</h3>
                        <p>Temukan buku yang Anda cari dengan fitur pencarian canggih.</p>
                    </div>
                    <div class="feature-item">
                        <h3>📖 Manajemen Pinjaman</h3>
                        <p>Pantau status pinjaman dan riwayat baca Anda.</p>
                    </div>
                    <div class="feature-item">
                        <h3>👤 Profil Personal</h3>
                        <p>Kelola profil Anda dan sesuaikan pengalaman membaca.</p>
                    </div>
                </div>
            </div>

            <div class="about-section">
                <h2>Misi Kami</h2>
                <p>Kami berkomitmen untuk mendemokratisasi akses pengetahuan dengan menyediakan platform yang inklusif dan mudah digunakan. StudyRead hadir untuk mendukung komunitas pembaca di era digital, memfasilitasi pembelajaran seumur hidup, dan mendorong budaya literasi yang kuat.</p>
            </div>

            <div class="about-section">
                <h2>Kontak Kami</h2>
                <p>Jika Anda memiliki pertanyaan atau saran, jangan ragu untuk menghubungi kami:</p>
                <p><strong>Email:</strong> info@studyread.com</p>
                <p><strong>Telepon:</strong> +62 87887878</p>
                <p><strong>Alamat:</strong> Jl. Indonesia Emas</p>
            </div>

            <div class="copyright">
                <p>&copy; 2026 StudyRead. All rights reserved.</p>
                <p>Dibuat dengan ❤️ untuk komunitas pembaca Indonesia.</p>
            </div>
        </div>
    </main>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>