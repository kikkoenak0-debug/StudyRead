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
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .book-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .book-item .cover {
            font-size: 3em;
            margin-bottom: 10px;
        }
        .book-item h4 {
            margin: 10px 0;
            font-size: 1.1em;
        }
        .book-item p {
            color: #666;
            font-size: 0.9em;
        }
        .category-section {
            margin-bottom: 40px;
        }
        .category-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .category-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border: 2px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
        }
        .category-card:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            border-color: #2196F3;
        }
        .category-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .category-card h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }
        .category-card p {
            color: #666;
            margin-bottom: 10px;
        }
        .category-count {
            color: #2196F3;
            font-weight: bold;
        }
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
        </header>

        <section class="category-section" style="background: #f9f9f9; padding: 40px; margin: -20px -20px 40px -20px;">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="font-size: 2.5em; margin-bottom: 10px;">Kategori Buku</h2>
                <p style="font-size: 1.2em; color: #666;">Jelajahi berbagai koleksi buku sesuai minat Anda</p>
            </div>
            
            @php
            $categories = [
                ['icon' => '📖', 'title' => 'Fiksi & Sastra', 'description' => 'Novel, cerpen, puisi, dan karya sastra lainnya', 'count' => '2,500+ buku'],
                ['icon' => '💼', 'title' => 'Bisnis & Ekonomi', 'description' => 'Pengembangan usaha, manajemen, dan keuangan', 'count' => '1,800+ buku'],
                ['icon' => '🔬', 'title' => 'Sains & Teknologi', 'description' => 'Penelitian, inovasi, dan perkembangan teknologi', 'count' => '3,200+ buku'],
                ['icon' => '❤️', 'title' => 'Kesehatan & Gaya Hidup', 'description' => 'Tips hidup sehat, nutrisi, dan kesejahteraan', 'count' => '1,500+ buku'],
                ['icon' => '🌍', 'title' => 'Sejarah & Budaya', 'description' => 'Warisan sejarah dan kebudayaan dunia', 'count' => '2,100+ buku'],
                ['icon' => '💡', 'title' => 'Pengembangan Diri', 'description' => 'Motivasi, produktivitas, dan karir', 'count' => '1,900+ buku']
            ];
            @endphp
            
            <div class="categories-grid">
                @foreach($categories as $category)
                <a href="{{ route('buku.index', ['kategori' => $category['title']]) }}" style="text-decoration: none; color: inherit;">
                    <div class="category-card">
                        <div class="category-icon">{{ $category['icon'] }}</div>
                        <h3>{{ $category['title'] }}</h3>
                        <p>{{ $category['description'] }}</p>
                        <p class="category-count">{{ $category['count'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
    </main>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>