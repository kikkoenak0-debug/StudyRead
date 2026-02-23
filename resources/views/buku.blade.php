<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Ki-Perpus</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 20px;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .book-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .book-item:hover {
            transform: scale(1.05);
        }
        .book-item .cover {
            width: 100px;
            height: 150px;
            margin-bottom: 10px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-item h4 {
            margin: 10px 0;
            font-size: 1.1em;
        }
        .book-item p {
            color: #666;
            font-size: 0.9em;
        }
        .category-group {
            margin-bottom: 40px;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .category-group .category-title {
            font-size: 1.2em;
            margin-bottom: 15px;
            margin-top: 30px;
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .filter-container {
            margin: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            box-sizing: border-box;
        }
        .filter-container label {
            font-weight: 600;
            color: #333;
        }
        .filter-container select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
            cursor: pointer;
        }
        .kategori-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 15px;
            margin-bottom: 40px;
            margin-left: 20px;
            margin-right: 20px;
            padding: 0 20px;
            box-sizing: border-box;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .kategori-btn {
            padding: 8px 16px;
            border: 2px solid #ddd;
            border-radius: 20px;
            background: white;
            color: #333;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.3s;
        }
        .kategori-btn:hover {
            border-color: #667eea;
            color: #667eea;
        }
        .kategori-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        .btn-bayar {
            background-color: green;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
        <header class="top-bar">
            <div class="search-container">
                <input type="text" id="bookSearch" placeholder="Cari buku, penulis, atau kategori...">
                <button id="btnBookSearch">🔍</button>
            </div>
            <div class="filter-container">
              
            </div>
        </header>

        <div class="kategori-buttons">
            <button class="kategori-btn {{ !request('kategori') ? 'active' : '' }}" onclick="filterByKategoriButton('')">Semua</button>
            @foreach($kategori as $kat)
                <button class="kategori-btn {{ request('kategori') == $kat ? 'active' : '' }}" onclick="filterByKategoriButton('{{ $kat }}')">{{ $kat }}</button>
            @endforeach
        </div>

        <section class="category-section">
            <h3 class="category-title" style="margin-top: 0; padding: 0 20px; margin-bottom: 30px;">📚 Daftar Buku</h3>
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
            @forelse($bukuGrouped as $kat => $bukus)
            <div class="category-group">
                <h4 class="category-title">{{ $kat }}</h4>
                <div class="book-grid">
                    @forelse($bukus as $item)
                    <a href="{{ route('buku.show', $item->id) }}" class="book-item" style="text-decoration: none; color: inherit;">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Cover Buku" class="cover">
                        @else
                            <div class="cover">📚</div>
                        @endif
                        <h4>{{ $item->judul }}</h4>
                    </a>
                    @empty
                    <p>Tidak ada buku tersedia di kategori ini.</p>
                    @endforelse
                </div>
            </div>
            @empty
            <p>Tidak ada buku tersedia saat ini.</p>
            @endforelse
        </section>
    </main>

<script src="{{ asset('js/home.js') }}"></script>
<script>
function filterByKategori() {
    const kategori = document.getElementById('kategoriFilter').value;
    const url = new URL(window.location);
    if (kategori) {
        url.searchParams.set('kategori', kategori);
    } else {
        url.searchParams.delete('kategori');
    }
    window.location.href = url.toString();
}

function filterByKategoriButton(kategori) {
    const url = new URL(window.location);
    if (kategori) {
        url.searchParams.set('kategori', kategori);
    } else {
        url.searchParams.delete('kategori');
    }
    window.location.href = url.toString();
}
</script>
</body>
</html>