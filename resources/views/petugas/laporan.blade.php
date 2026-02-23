<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Pengembalian - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.petugas-sidebar')

    <main class="main-content">
        <section class="welcome-section">
            <h1 style="margin-bottom: 20px;">Laporan Pengembalian Buku</h1>
            <p>Lihat semua laporan pengembalian buku dari peminjam.</p>
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
                    <h2>Daftar Laporan Pengembalian</h2>
                    <div class="table-controls">
                        <input type="text" id="searchInput" placeholder="Cari nama peminjam atau judul buku..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; width: 300px;">
                        <select id="filterKondisi" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; margin-left: 10px;">
                            <option value="">Semua Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Kondisi Buku</th>
                            <th>Keterangan</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanPengembalian as $laporan)
                        <tr class="laporan-row" data-peminjam="{{ strtolower($laporan->user->name) }}" data-buku="{{ strtolower($laporan->buku->judul) }}" data-kondisi="{{ $laporan->kondisi_buku }}">
                            <td>{{ $laporan->user->name }}</td>
                            <td>{{ $laporan->buku->judul }}</td>
                            <td>{{ $laporan->tanggal_pengembalian->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge @if($laporan->kondisi_buku === 'baik') badge-success @elseif($laporan->kondisi_buku === 'rusak') badge-warning @else badge-danger @endif">
                                    {{ ucfirst($laporan->kondisi_buku) }}
                                </span>
                            </td>
                            <td>{{ $laporan->keterangan ?? '-' }}</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-sm btn-info" onclick="showDetailLaporan({{ $laporan->id }}, '{{ $laporan->user->name }}', '{{ $laporan->buku->judul }}', '{{ $laporan->tanggal_pengembalian->format('d/m/Y') }}', '{{ $laporan->kondisi_buku }}', '{{ $laporan->keterangan ?? '' }}')">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada laporan pengembalian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    <p>Menampilkan {{ $laporanPengembalian->count() }} dari {{ $laporanPengembalian->total() }} data</p>
                    {{ $laporanPengembalian->links() }}
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Detail Laporan -->
    <div id="modalDetail" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail Laporan Pengembalian</h2>
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
                    <label>Tanggal Pengembalian:</label>
                    <input type="text" id="detailTanggal" readonly style="background-color: #f0f0f0;">
                </div>
                <div class="form-group">
                    <label>Kondisi Buku:</label>
                    <input type="text" id="detailKondisi" readonly style="background-color: #f0f0f0;">
                </div>
                <div class="form-group">
                    <label>Keterangan/Alasan Pengembalian:</label>
                    <textarea id="detailKeterangan" readonly style="background-color: #f0f0f0; resize: none;" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalDetail()">Tutup</button>
            </div>
        </div>
    </div>


    <!-- Modal Ubah Denda -->
    <!-- Dihapus -->
    
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

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-danger {
            background-color: #dc3545;
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
        .form-group textarea {
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
        function showDetailLaporan(id, peminjam, buku, tanggal, kondisi, keterangan) {
            document.getElementById('detailPeminjam').value = peminjam;
            document.getElementById('detailBuku').value = buku;
            document.getElementById('detailTanggal').value = tanggal;
            document.getElementById('detailKondisi').value = kondisi.charAt(0).toUpperCase() + kondisi.slice(1);
            document.getElementById('detailKeterangan').value = keterangan || '-';
            document.getElementById('modalDetail').style.display = 'block';
        }

        function closeModalDetail() {
            document.getElementById('modalDetail').style.display = 'none';
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filterKondisi = document.getElementById('filterKondisi').value;
            
            document.querySelectorAll('.laporan-row').forEach(row => {
                const peminjam = row.dataset.peminjam;
                const buku = row.dataset.buku;
                const kondisi = row.dataset.kondisi;
                
                const matchSearch = peminjam.includes(searchTerm) || buku.includes(searchTerm);
                const matchFilter = !filterKondisi || kondisi === filterKondisi;
                
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('filterKondisi').addEventListener('change', function(e) {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filterKondisi = e.target.value;
            
            document.querySelectorAll('.laporan-row').forEach(row => {
                const peminjam = row.dataset.peminjam;
                const buku = row.dataset.buku;
                const kondisi = row.dataset.kondisi;
                
                const matchSearch = peminjam.includes(searchTerm) || buku.includes(searchTerm);
                const matchFilter = !filterKondisi || kondisi === filterKondisi;
                
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });

        window.onclick = function(event) {
            const modalDetail = document.getElementById('modalDetail');
            
            if (event.target === modalDetail) {
                modalDetail.style.display = 'none';
            }
        }
    </script>
</body>
</html>
