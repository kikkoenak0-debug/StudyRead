<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - StudyRead</title>
    <link rel="stylesheet" href="{{ asset(path: 'css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
     
     <style>
        :root{
            --bg:#f6f8fb;
            --primary:#1976d2;
            --muted:#6b7280;
            --card:#ffffff;
            --accent:#ffb300;
        }
       

        .main-content{padding:18px 22px 60px}
        .search-container{display:flex;align-items:center;gap:8px;background:var(--card);padding:6px;border-radius:999px;box-shadow:0 4px 18px rgba(16,24,40,0.04);width:100%;max-width:520px}
        .search-container input{flex:1;border:0;outline:none;padding:8px 10px;border-radius:999px;background:transparent}
        .search-container button{background:transparent;border:0;font-size:16px;cursor:pointer}
        .search-container.focused{box-shadow:0 8px 28px rgba(25,118,210,0.08);transform:translateY(-1px)}

        .welcome-section{background:linear-gradient(135deg,#e3f2fd 0%,#bbdefb 100%);padding:30px;border-radius:12px;margin-bottom:28px;box-shadow:0 6px 20px rgba(16,24,40,0.03);animation:float 6s ease-in-out infinite}
        @keyframes float{0%{transform:translateY(0)}50%{transform:translateY(-6px)}100%{transform:translateY(0)}}

        .label{margin:6px 0 12px;font-size:1.05rem;color:var(--muted)}
        .book-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px;margin-top:10px}
        .book-item{background:var(--card);border-radius:10px;padding:14px;box-shadow:0 6px 18px rgba(16,24,40,0.04);text-align:center;cursor:pointer;transform:translateY(12px);opacity:0;transition:transform .6s cubic-bezier(.2,.9,.2,1),opacity .6s ease,box-shadow .15s ease}
        .book-item.in-view{transform:none;opacity:1}
        .book-item:hover{box-shadow:0 12px 30px rgba(16,24,40,0.08);transform:translateY(-6px) scale(1.02)}
        .book-item .cover{width:110px;height:160px;margin-bottom:10px;object-fit:cover;border-radius:6px}
        .book-item h4{margin:8px 0;font-size:1.05rem;color:#111827}
        .book-item p{color:var(--muted);font-size:0.92rem}

        .btn-bayar{background-color:green;color:white;padding:10px 15px;text-decoration:none;border-radius:8px;display:inline-block;margin-top:10px}

        /* small helpers */
        .btn-favorit{transition:transform .15s ease}
         html,body{height:100%;margin:0;font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:var(--bg); color:#1f2937}
        .navbar{display:flex;align-items:center;justify-content:space-between;padding:14px 22px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff}
        .logo-area h2{margin:0;font-weight:700;color:#ffffff;letter-spacing:0.2px;transition:transform .45s ease}
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
                <input type="text" id="homeSearch" placeholder="Cari buku, penulis, atau kategori...">
                <button id="btnHomeSearch">🔍</button>
            </div>
        </header>

        <section class="welcome-section" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 40px; border-radius: 10px; margin-bottom: 30px;">
            <h1 style="color: #1976d2;">Hai, selamat datang! 👋</h1>
            <p>Tempat di mana informasi seru, fitur keren, dan pengalaman terbaik berkumpul jadi satu.Yuk mulai eksplor dan temukan hal menarik di sini!</p>
        </section>


        <section class="popular-books">
            <h3 class="label">📈 Buku Populer</h3>
            <div class="book-grid">
                @foreach($buku->take(4) as $item)
                <div class="book-item" onclick="window.location.href='{{ route('buku.show', $item->id) }}'">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Cover Buku" class="cover">
                    @else
                        <div class="cover">📚</div>
                    @endif
                    <h4>{{ $item->judul }}</h4>
                </div>
                @endforeach
            </div>
        </section>

        <section class="book-explore">
            <h3 class="label">Rekomendasi Untukmu</h3>
            <div class="book-grid">
                @foreach($buku->skip(4) as $item)
                <div class="book-item" onclick="window.location.href='{{ route('buku.show', $item->id) }}'">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Cover Buku" class="cover">
                    @else
                        <div class="cover">📚</div>
                    @endif
                    <h4>{{ $item->judul }}</h4>
                </div>
                @endforeach
            </div>
        </section>
    </main>



<script src="{{ asset('js/home.js') }}"></script>
<script>


// Additional UI micro-interactions: reveal on scroll, search focus, ESC to close modal
document.addEventListener('DOMContentLoaded', function() {
    const logo = document.querySelector('.logo-area h2');
    if (logo) setTimeout(()=>logo.classList.add('logo-animate'), 120);

    const items = Array.from(document.querySelectorAll('.book-item'));
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const idx = items.indexOf(el);
                setTimeout(() => el.classList.add('in-view'), Math.min(idx * 80, 400));
                obs.unobserve(el);
            }
        });
    }, { threshold: 0.15 });
    items.forEach(i => observer.observe(i));

    const search = document.getElementById('homeSearch');
    search?.addEventListener('focus', () => document.querySelector('.search-container')?.classList.add('focused'));
    search?.addEventListener('blur', () => document.querySelector('.search-container')?.classList.remove('focused'));

    // Close modal with Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modal = document.getElementById('bookModal');
            if (modal && modal.style.display === 'block') modal.style.display = 'none';
        }
    });
});
</script>
</body>
</html>