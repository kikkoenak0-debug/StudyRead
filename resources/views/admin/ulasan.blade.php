<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ulasan - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <section class="welcome-section">
            <h1 style="margin-bottom: 20px;">Kelola Ulasan Peminjam</h1>
            <p>Lihat dan kelola semua ulasan yang dikirim oleh peminjam.</p>
        </section>

        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 4px solid #dc3545;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <section class="table-section">
            <div class="table-container">
                <div class="table-header">
                    <h2>Daftar Ulasan</h2>
                    <div class="table-controls">
                        <input type="text" id="searchInput" placeholder="Cari nama peminjam atau judul buku..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; width: 300px;">
                        <select id="filterRating" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; margin-left: 10px;">
                            <option value="">Semua Rating</option>
                            <option value="5">★★★★★ (5 Bintang)</option>
                            <option value="4">★★★★ (4 Bintang)</option>
                            <option value="3">★★★ (3 Bintang)</option>
                            <option value="2">★★ (2 Bintang)</option>
                            <option value="1">★ (1 Bintang)</option>
                        </select>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Tanggal</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ulasanList as $ulasan)
                        <tr class="ulasan-row" data-peminjam="{{ strtolower($ulasan->user->name) }}" data-buku="{{ strtolower($ulasan->buku->judul) }}" data-rating="{{ $ulasan->rating }}">
                            <td>{{ $ulasan->user->name }}</td>
                            <td>{{ $ulasan->buku->judul }}</td>
                            <td>
                                <span style="color: #FFB800;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $ulasan->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                ({{ $ulasan->rating }})
                            </td>
                            <td>{{ strlen($ulasan->ulasan) > 50 ? substr($ulasan->ulasan, 0, 50) . '...' : $ulasan->ulasan }}</td>
                            <td>{{ $ulasan->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-sm btn-info" onclick="showDetailUlasan({{ $ulasan->id }}, '{{ addslashes($ulasan->user->name) }}', '{{ addslashes($ulasan->buku->judul) }}', {{ $ulasan->rating }}, '{{ addslashes($ulasan->ulasan) }}', '{{ $ulasan->created_at->format('d/m/Y H:i') }}')">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" onclick="showEditUlasan({{ $ulasan->id }}, {{ $ulasan->rating }}, '{{ addslashes($ulasan->ulasan) }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteUlasan({{ $ulasan->id }})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada ulasan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    <p>Menampilkan {{ $ulasanList->count() }} dari {{ $ulasanList->total() }} data</p>
                    {{ $ulasanList->links() }}
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Detail Ulasan -->
    <div id="modalDetail" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail Ulasan</h2>
                <button type="button" class="modal-close" onclick="closeModalDetail()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Peminjam:</label>
                    <input type="text" id="detailPeminjam" readonly style="background-color: #f0f0f0;">
                </div>
                <div class="form-group">
                    <label>Judul Buku:</label>
                    <input type="text" id="detailBuku" readonly style="background-color: #f0f0f0;">
                </div>
                <div class="form-group">
                    <label>Rating:</label>
                    <input type="text" id="detailRating" readonly style="background-color: #f0f0f0;">
                </div>
                <div class="form-group">
                    <label>Ulasan:</label>
                    <textarea id="detailUlasan" readonly style="background-color: #f0f0f0; resize: none;" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal Ulasan:</label>
                    <input type="text" id="detailTanggal" readonly style="background-color: #f0f0f0;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalDetail()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Ulasan -->
    <div id="modalEdit" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Ulasan</h2>
                <button type="button" class="modal-close" onclick="closeModalEdit()">&times;</button>
            </div>
            <form id="formEdit" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editRating">Rating (1-5):</label>
                        <select id="editRating" name="rating" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="1">★ (1 Bintang)</option>
                            <option value="2">★★ (2 Bintang)</option>
                            <option value="3">★★★ (3 Bintang)</option>
                            <option value="4">★★★★ (4 Bintang)</option>
                            <option value="5">★★★★★ (5 Bintang)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editUlasan">Ulasan:</label>
                        <textarea id="editUlasan" name="ulasan" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; resize: none;" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalEdit()">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 550px;
            border-radius: 5px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .table-controls {
            display: flex;
            gap: 10px;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85em;
        }

        .btn {
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            padding: 8px 15px;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        let currentUlasanId = null;

        function showDetailUlasan(id, peminjam, buku, rating, ulasan, tanggal) {
            document.getElementById('detailPeminjam').value = peminjam;
            document.getElementById('detailBuku').value = buku;
            
            let ratingStars = '';
            for(let i = 1; i <= 5; i++) {
                ratingStars += (i <= rating) ? '★' : '☆';
            }
            document.getElementById('detailRating').value = ratingStars + ' (' + rating + ')';
            document.getElementById('detailUlasan').value = ulasan;
            document.getElementById('detailTanggal').value = tanggal;
            document.getElementById('modalDetail').style.display = 'block';
        }

        function closeModalDetail() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        function showEditUlasan(id, rating, ulasan) {
            currentUlasanId = id;
            document.getElementById('editRating').value = rating;
            document.getElementById('editUlasan').value = ulasan;
            document.getElementById('formEdit').action = `/admin/ulasan/${id}`;
            document.getElementById('modalEdit').style.display = 'block';
        }

        function closeModalEdit() {
            document.getElementById('modalEdit').style.display = 'none';
        }

        function deleteUlasan(id) {
            if(confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/ulasan/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filterRating = document.getElementById('filterRating').value;
            
            document.querySelectorAll('.ulasan-row').forEach(row => {
                const peminjam = row.dataset.peminjam;
                const buku = row.dataset.buku;
                const rating = row.dataset.rating;
                
                const matchSearch = peminjam.includes(searchTerm) || buku.includes(searchTerm);
                const matchFilter = !filterRating || rating === filterRating;
                
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('filterRating').addEventListener('change', function(e) {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filterRating = e.target.value;
            
            document.querySelectorAll('.ulasan-row').forEach(row => {
                const peminjam = row.dataset.peminjam;
                const buku = row.dataset.buku;
                const rating = row.dataset.rating;
                
                const matchSearch = peminjam.includes(searchTerm) || buku.includes(searchTerm);
                const matchFilter = !filterRating || rating === filterRating;
                
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });

        window.onclick = function(event) {
            const modalDetail = document.getElementById('modalDetail');
            const modalEdit = document.getElementById('modalEdit');
            
            if (event.target === modalDetail) {
                modalDetail.style.display = 'none';
            }
            if (event.target === modalEdit) {
                modalEdit.style.display = 'none';
            }
        }
    </script>
</body>
</html>
