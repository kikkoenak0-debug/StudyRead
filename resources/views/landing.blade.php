<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyRead | Jendela Dunia</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo-area">
            <h2>StudyRead</h2>
        </div>
        <div class="profile-menu">
            <a href="/login" class="btn-outline btn-sm">Masuk</a>
            <a href="/register" class="btn-fill btn-sm">Daftar</a>
        </div>
    </nav>

    <main class="main-content">
        <section class="hero-new" id="beranda">
            <div class="hero-bg">
                <img src="https://images.unsplash.com/photo-1703236079592-4d2f222e8d2f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBsaWJyYXJ5JTIwaW50ZXJpb3J8ZW58MXx8fHwxNzY4NzkyOTIwfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" alt="Library Interior" />
                <div class="overlay"></div>
            </div>
            <div class="hero-content">
                <h1>Perpustakaan Offline Modern</h1>
                <p>Telusuri ribuan judul melalui website kami, lalu datang dan ambil buku pilihan Anda di perpustakaan.</p>
                @if(session('success'))
                    <p style="color: green; text-align: center;">{{ session('success') }}</p>
                @endif
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <input type="text" id="searchInput" placeholder="Cari judul buku, penulis, atau topik..." />
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <button id="searchBtn" class="btn-primary">Jelajahi Koleksi</button>
                </div>
            </div>
        </section>

         <section class="categories-section" id="kategori">
            <div class="categories-container">
                <div class="categories-header">
                    <h2>Kategori Buku</h2>
                    <p>Jelajahi berbagai koleksi buku sesuai minat Anda</p>
                </div>
                
                <div class="categories-grid">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="category-content">
                            <h3>Fiksi & Sastra</h3>
                            <p>Novel, cerpen, puisi, dan karya sastra lainnya</p>
                            <p class="category-count">2,500+ buku</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="category-content">
                            <h3>Bisnis & Ekonomi</h3>
                            <p>Pengembangan usaha, manajemen, dan keuangan</p>
                            <p class="category-count">1,800+ buku</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <div class="category-content">
                            <h3>Sains & Teknologi</h3>
                            <p>Penelitian, inovasi, dan perkembangan teknologi</p>
                            <p class="category-count">3,200+ buku</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="category-content">
                            <h3>Kesehatan & Gaya Hidup</h3>
                            <p>Tips hidup sehat, nutrisi, dan kesejahteraan</p>
                            <p class="category-count">1,500+ buku</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="category-content">
                            <h3>Sejarah & Budaya</h3>
                            <p>Warisan sejarah dan kebudayaan dunia</p>
                            <p class="category-count">2,100+ buku</p>
                        </div>
                    </div>
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="category-content">
                            <h3>Pengembangan Diri</h3>
                            <p>Motivasi, produktivitas, dan karir</p>
                            <p class="category-count">1,900+ buku</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="features-section">
            <div class="features-container">
                <div class="features-grid">
                    <div class="features-text">
                        <h2>Mengapa Memilih Perpustakaan Kami?</h2>
                        <p>Kami menyediakan pengalaman membaca yang modern dan nyaman dengan berbagai fitur unggulan untuk mendukung kegiatan literasi Anda.</p>
                        
                        <div class="features-list">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="feature-content">
                                    <h3>Katalog 24/7</h3>
                                    <p>Periksa ketersediaan buku kapan saja melalui website kami.</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="feature-content">
                                    <h3>Reservasi Buku</h3>
                                    <p>Pilih judul online dan pesan agar siap diambil di perpustakaan.</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                                <div class="feature-content">
                                    <h3>Bookmark & Catatan</h3>
                                    <p>Tandai judul favorit dan catat ide penting.</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="feature-content">
                                    <h3>Koleksi Lengkap</h3>
                                    <p>Lebih dari 10.000 judul fisik dari berbagai genre.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="features-image">
                        <div class="image-wrapper">
                            <img src="https://images.unsplash.com/photo-1632830096559-fb7091533755?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxyZWFkaW5nJTIwYm9va3MlMjBzdHVkZW50fGVufDF8fHx8MTc2ODkxMDQ5NXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" alt="Reading Books" />
                        </div>
                        <div class="stats-overlay">
                            <p class="stats-number">10,000+</p>
                            <p class="stats-text">Koleksi Buku</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="faq-section">
            <div class="faq-container">
                <div class="faq-header">
                    <h2>Pertanyaan Sering Diajukan</h2>
                    <p>Temukan jawaban untuk pertanyaan umum tentang layanan perpustakaan kami</p>
                </div>
                
                <div class="faq-accordion">
                    <details class="faq-item">
                        <summary>Bagaimana cara meminjam buku?</summary>
                        <p>Anda dapat meminjam buku dengan login ke akun Anda, cari buku yang diinginkan melalui web, dan klik tombol 'Pinjam'. Buku akan siap diambil di perpustakaan kami.</p>
                    </details>
                    <details class="faq-item">
                        <summary>Berapa lama durasi peminjaman buku?</summary>
                        <p>Durasi peminjaman standar adalah 14 hari. Anda dapat memperpanjang masa pinjam hingga 2 kali jika tidak ada daftar tunggu.</p>
                    </details>
                    
                    <details class="faq-item">
                        <summary>Bagaimana cara mencari buku yang sesuai dengan kebutuhan saya?</summary>
                        <p>Anda dapat menggunakan fitur pencarian dengan kata kunci, menjelajahi kategori, atau menggunakan layanan Konsultasi Buku kami di mana pustakawan ahli akan membantu merekomendasikan buku yang tepat.</p>
                    </details>
                    <details class="faq-item">
                        <summary>Apakah saya bisa mengakses perpustakaan dari rumah?</summary>
                        <p>Perpustakaan kami buka setiap hari selama jam operasional. Kunjungi langsung untuk menikmati koleksi fisik dan layanan kami.</p>
                    </details>
                    <details class="faq-item">
                        <summary>Bagaimana cara bergabung dengan klub buku?</summary>
                        <p>Anda dapat mendaftar klub buku melalui halaman Komunitas di website kami. Pilih klub yang sesuai minat Anda dan ikuti pertemuan rutin baik online maupun offline.</p>
                    </details>
                </div>
            </div>
        </section>



        <footer class="footer-new" id="tentang">
            <div class="footer-container">
                <div class="footer-grid">
                    <div class="footer-section">
                        <div class="footer-logo">
                            <i class="fas fa-book-open text-blue-400"></i>
                            <span>Perpustakaan Offline</span>
                        </div>
                        <p>Menyediakan akses mudah ke ribuan koleksi buku dan layanan bantuan literasi terlengkap.</p>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Layanan</h3>
                        <ul>
                            <li><a href="#">Katalog Buku</a></li>
                            <li><a href="#">Konsultasi Buku</a></li>
                            <li><a href="#">Klub Buku</a></li>
                            <li><a href="#">Panduan Membaca</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Tentang</h3>
                        <ul>
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Jam Operasional</a></li>
                            <li><a href="#">Kebijakan</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Kontak</h3>
                        <ul>
                            <li><i class="fas fa-phone"></i> +62 21 1234 5678</li>
                            <li><i class="fas fa-envelope"></i> info@perpustakaan.id</li>
                            <li><i class="fas fa-map-marker-alt"></i> Jl. Literasi No. 123<br>Jakarta, Indonesia</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; 2026 Perpustakaan Offline. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>
    </main>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>