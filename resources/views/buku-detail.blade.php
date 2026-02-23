<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul }} - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .star-rating {
            font-size: 24px;
            color: #fbbf24;
        }
        .star-rating .empty {
            color: #d1d5db;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

  

    <div class="container mx-auto px-4 py-10 max-w-6xl">
        
        <!-- Tombol Kembali -->
        <a href="{{ route('buku.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Buku
        </a>

        <!-- Detail Buku -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Gambar dan Tombol -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                    @if($buku->foto)
                        <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-blue-100 flex items-center justify-center text-blue-500">
                            <i class="fas fa-book fa-8x"></i>
                        </div>
                    @endif
                    
                    <div class="p-6 space-y-4">
                        <!-- Tombol Favorit -->
                        <button id="favoriteBtn" class="w-full py-3 px-4 rounded-lg font-semibold transition-all flex items-center justify-center gap-2
                            @if($isFavorited) bg-red-500 text-white hover:bg-red-600 @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                            <i class="fas fa-heart"></i>
                            <span id="favoriteText">@if($isFavorited) Hapus Favorit @else Tambah Favorit @endif</span>
                        </button>

                        <!-- Tombol Pinjam -->
                        <a href="{{ route('buku.halamanPinjam', $buku->id) }}" class="w-full py-3 px-4 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 bg-blue-600 text-white hover:bg-blue-700 text-decoration-none">
                            <i class="fas fa-hand-holding-heart"></i>
                            Pinjam Buku
                        </a>

                        <!-- Info Buku Singkat -->
                        <div class="space-y-3 border-t pt-4">
                            <div>
                                <p class="text-sm text-gray-600">ISBN</p>
                                <p class="font-semibold">{{ $buku->isbn }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Penulis</p>
                                <p class="font-semibold">{{ $buku->penulis }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tahun Terbit</p>
                                <p class="font-semibold">{{ $buku->tahun_terbit ? \Carbon\Carbon::parse($buku->tahun_terbit)->format('d/m/Y') : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Kategori</p>
                                <p class="font-semibold">{{ $buku->kategori->nama ?? 'Tidak ada' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Stok Tersedia</p>
                                <p class="font-semibold text-lg @if($buku->tersedia > 0) text-green-600 @else text-red-600 @endif">
                                    {{ $buku->tersedia }} Eksemplar
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Konten Utama -->
            <div class="md:col-span-2 space-y-8">
                
                <!-- Judul dan Rating -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $buku->judul }}</h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-2">
                            <div class="star-rating">
                                @php
                                    $rating = round($ratingRataRata ?? 0);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';
                                        } else {
                                            echo '<i class="fas fa-star empty"></i>';
                                        }
                                    }
                                @endphp
                            </div>
                            <span class="font-semibold text-gray-700">{{ number_format($ratingRataRata ?? 0, 1) }}/5</span>
                        </div>
                        <span class="text-gray-600">{{ $totalUlasan }} ulasan</span>
                    </div>
                </div>

                <!-- Synopsis -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-align-left text-blue-500 mr-2"></i>Sinopsis
                    </h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $buku->sinopsis ?? 'Tidak ada sinopsis tersedia untuk buku ini.' }}
                    </p>
                    <p style="margin-top:10px; font-size:0.9em; color:#666;">
                        <strong>Dibuat oleh:</strong> {{ $buku->user->name ?? 'Admin' }}
                    </p>
                    </p>
                </div>

                <!-- Section Ulasan & Rating -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">
                        <i class="fas fa-comments text-blue-500 mr-2"></i>Ulasan & Review
                    </h2>

                    <!-- Form Berikan Ulasan -->
                    <div class="bg-blue-50 rounded-lg p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Ulasan Anda</h3>
                        <form action="{{ route('buku.simpanUlasan', $buku->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <div class="flex gap-2" id="ratingInput">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" data-rating="{{ $i }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="ratingValue" value="">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ulasan</label>
                                <textarea name="ulasan" placeholder="Tuliskan ulasan Anda tentang buku ini..." 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none" rows="4" required></textarea>
                                <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter</p>
                            </div>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Ulasan
                            </button>
                        </form>
                    </div>

                    <!-- Daftar Ulasan -->
                    <div class="space-y-4">
                        @forelse($ulasan as $item)
                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                    <div class="star-rating text-lg">
                                        @php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $item->rating) {
                                                    echo '<i class="fas fa-star"></i>';
                                                } else {
                                                    echo '<i class="fas fa-star empty"></i>';
                                                }
                                            }
                                        @endphp
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $item->ulasan }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-comment-slash text-4xl text-gray-300 mb-3 block"></i>
                                <p class="text-gray-500">Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/home.js') }}"></script>
    <script>
        // Favorite Button
        const favoriteBtn = document.getElementById('favoriteBtn');
        const favoriteText = document.getElementById('favoriteText');
        let isFavorited = {{ $isFavorited ? 'true' : 'false' }};

        favoriteBtn.addEventListener('click', async function() {
            try {
                const response = await fetch('{{ route("buku.toggleFavorit", $buku->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    isFavorited = data.isFavorited;
                    
                    if (isFavorited) {
                        favoriteBtn.classList.remove('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
                        favoriteBtn.classList.add('bg-red-500', 'text-white', 'hover:bg-red-600');
                        favoriteText.textContent = 'Hapus Favorit';
                    } else {
                        favoriteBtn.classList.remove('bg-red-500', 'text-white', 'hover:bg-red-600');
                        favoriteBtn.classList.add('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
                        favoriteText.textContent = 'Tambah Favorit';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah favorit');
            }
        });

        // Rating Input
        const ratingButtons = document.querySelectorAll('#ratingInput button');
        const ratingValue = document.getElementById('ratingValue');
        let selectedRating = 0;

        ratingButtons.forEach((button, index) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                selectedRating = index + 1;
                ratingValue.value = selectedRating;
                
                ratingButtons.forEach((btn, i) => {
                    if (i < selectedRating) {
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-yellow-400');
                    } else {
                        btn.classList.remove('text-yellow-400');
                        btn.classList.add('text-gray-300');
                    }
                });
            });

            button.addEventListener('mouseover', function() {
                ratingButtons.forEach((btn, i) => {
                    if (i < index + 1) {
                        btn.classList.add('text-yellow-300');
                    } else {
                        btn.classList.remove('text-yellow-300');
                    }
                });
            });
        });

        document.getElementById('ratingInput').addEventListener('mouseleave', function() {
            ratingButtons.forEach((btn, i) => {
                btn.classList.remove('text-yellow-300');
                if (i < selectedRating) {
                    btn.classList.add('text-yellow-400');
                } else {
                    btn.classList.add('text-gray-300');
                }
            });
        });
    </script>
</body>
</html>
