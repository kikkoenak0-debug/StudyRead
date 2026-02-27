<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Favorit - StudyRead</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .book-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .book-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }
        .book-item .cover {
            width: 100px;
            height: 150px;
            margin: 0 auto 10px;
            object-fit: cover;
            border-radius: 5px;
            display: block;
        }
        .book-item h4 {
            margin: 10px 0 5px;
            font-size: 1em;
            color: #333;
            min-height: 2.4em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .book-item p {
            color: #666;
            font-size: 0.85em;
            margin: 0;
        }
        .category-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }
        .filter-container {
            margin-left: 20px;
        }
        .filter-container select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
         html,body{height:100%;margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:var(--bg); color:#1f2937}
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
            <h1>⭐ Buku Favorit Saya</h1>
        </header>

        <section class="favorites">
            <div class="book-grid">
                @forelse($favorites as $favorit)
                <div class="book-item" onclick="showBookDetail({{ $favorit->buku->id }}, '{{ $favorit->buku->judul }}', '{{ $favorit->buku->penulis }}', '{{ $favorit->buku->kategori }}', '{{ $favorit->buku->isbn }}', {{ $favorit->buku->tersedia }}, '{{ $favorit->buku->foto ? asset('storage/' . $favorit->buku->foto) : '' }}')">
                    @if($favorit->buku->foto)
                        @if($favorit->buku->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($favorit->buku->foto))
                            <img src="{{ asset('storage/' . $favorit->buku->foto) }}" alt="Cover Buku" class="cover">
                        @else
                            <div class="cover" style="display:flex;align-items:center;justify-content:center;">📚</div>
                        @endif
                    @else
                        <div class="cover">📚</div>
                    @endif
                    <h4>{{ $favorit->buku->judul }}</h4>
                    <p>{{ $favorit->buku->penulis }}</p>
                </div>
                @empty
                <p>Belum ada buku favorit.</p>
                @endforelse
            </div>
        </section>
    </main>

    <!-- Modal Detail Buku -->
    <div id="bookModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalBody" style="display: flex; width: 100%;">
                <div id="modalCoverContainer" style="flex: 1; text-align: center; margin-right: 20px;">
                    <img id="modalCover" src="" alt="Cover Buku" style="width: 150px; height: 200px; object-fit: cover; border-radius: 5px;">
                    <div id="modalCoverPlaceholder" style="width: 150px; height: 200px; display: none; align-items: center; justify-content: center; font-size: 50px; border: 1px solid #ddd; border-radius: 5px;">📚</div>
                </div>
                <div id="modalDetails" style="flex: 2;">
                    <h2 id="modalTitle"></h2>
                    <p><strong>Penulis:</strong> <span id="modalPenulis"></span></p>
                    <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                    <p><strong>ISBN:</strong> <span id="modalIsbn"></span></p>
                    <p><strong>Stok Tersedia:</strong> <span id="modalStok"></span></p>
                    <p id="modalSpoiler" style="font-style: italic; color: #666; margin-top: 10px;"></p>
                    <a id="modalBayarBtn" href="" class="btn-bayar">Pinjam</a>
                    <button id="modalFavoritBtn" class="btn-favorit" onclick="toggleFavorit()">⭐ Favorit</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/home.js') }}"></script>
    <script>
        function showBookDetail(id, judul, penulis, kategori, isbn, stok, foto) {
            if (!id) {
                alert('ID buku tidak valid.');
                return;
            }
            document.getElementById('modalTitle').textContent = judul;
            document.getElementById('modalPenulis').textContent = penulis;
            document.getElementById('modalKategori').textContent = kategori;
            document.getElementById('modalIsbn').textContent = isbn;
            document.getElementById('modalStok').textContent = stok;
            const coverImg = document.getElementById('modalCover');
            const placeholder = document.getElementById('modalCoverPlaceholder');
            if (foto) {
                coverImg.src = foto;
                coverImg.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                coverImg.style.display = 'none';
                placeholder.style.display = 'flex';
            }
            const spoilerText = "Buku " + kategori.toLowerCase() + " yang penuh inspirasi dan pengetahuan.";
            document.getElementById('modalSpoiler').textContent = spoilerText;
            document.getElementById('modalBayarBtn').href = '/buku/' + id + '/bayar';
            document.getElementById('bookModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('bookModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('bookModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        function toggleFavorit() {
            const bukuId = document.getElementById('modalTitle').dataset.id; // Assume we set data-id
            fetch('/favorit/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ buku_id: bukuId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.status === 'added' ? 'Ditambahkan ke favorit' : 'Dihapus dari favorit');
            });
        }
    </script>
</body>
</html>