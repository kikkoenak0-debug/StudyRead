<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Peminjaman Buku - Koki Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <div class="container mx-auto px-4 py-10 max-w-4xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Ajukan Peminjaman Buku</h2>
        
        <p class="text-center text-gray-600 mb-8">Halaman ini untuk mengajukan peminjaman buku. Isi data di bawah dan submit untuk mengajukan peminjaman.</p>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-semibold mb-6 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-blue-500"></i> Informasi peminjam
                </h3>
                <form action="{{ route('buku.pinjam') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $buku->id ?? '' }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ auth()->user()->name }}" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input type="tel" name="no_telp" placeholder="0812xxxx" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                    </div>
<div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
                    </div>
                    <!-- Tidak ada input harga atau metode pembayaran -->
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 h-fit">
                <h3 class="text-xl font-semibold mb-6">Ringkasan Peminjaman</h3>
                <div class="flex items-center mb-6">
                    <div class="w-16 h-20 bg-blue-100 rounded-lg flex items-center justify-center text-blue-500 mr-4">
                        <i class="fas fa-book fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $buku->judul }}</h4>
                        <p class="text-sm text-gray-500">{{ $buku->penulis }}</p>
                        <p class="text-xs text-gray-400">ISBN: {{ $buku->isbn }}</p>
                    </div>
                </div>
                <button type="submit" class="w-full mt-8 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all transform hover:scale-[1.02] shadow-lg shadow-blue-200">
                    Ajukan Peminjaman
                </button>
                <p class="text-center text-xs text-gray-400 mt-4">
                    <i class="fas fa-shield-alt"></i> Peminjaman gratis & aman
                </p>
            </div>

        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showConfirmationModal();
                } else {
                    alert(data.message || 'Terjadi kesalahan.');
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan jaringan.');
            });
        });

        function showConfirmationModal() {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            `;
            modal.innerHTML = `
                <div style="
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    text-align: center;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    max-width: 400px;
                    width: 90%;
                ">
                    <h3 style="margin-bottom: 20px; color: #333;">Peminjaman Berhasil Diajukan</h3>
                    <p style="margin-bottom: 25px; color: #666;">Sedang menunggu konfirmasi dari petugas.</p>
                    <button onclick="closeModalAndRedirect()" style="
                        background-color: #007bff;
                        color: white;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 16px;
                    ">Oke</button>
                </div>
            `;
            document.body.appendChild(modal);
        }

        function closeModalAndRedirect() {
            document.body.removeChild(document.body.lastChild);
            window.location.href = '{{ route("riwayat.pinjaman") }}';
        }
    </script>

</body>
</html>