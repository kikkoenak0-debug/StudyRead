<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Petugas - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.petugas-sidebar')

    <main class="main-content">

        <section class="welcome-section">
            <h1 style="margin-bottom: 20px;">Selamat Datang di Dashboard Petugas!</h1>
            <p>Kelola perpustakaan dengan mudah dan efisien.</p>
        </section>

        <section class="stats-section">
            <h3 class="label">Statistik Perpustakaan</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Buku</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $totalBuku }}</h2>
                    </div>
                    <div class="stat-icon bg-blue-500 text-white">
                        <i class="fas fa-book"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Pengguna</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</h2>
                    </div>
                    <div class="stat-icon bg-green-500 text-white">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="stat-card" onclick="showTab('aktif')" style="cursor: pointer;">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Peminjaman Aktif</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $peminjamanAktif }}</h2>
                    </div>
                    <div class="stat-icon bg-red-500 text-white">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </section>

        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('riwayat')">Riwayat Transaksi</button>
            <button class="tab-btn" onclick="showTab('konfirmasi')">Konfirmasi Peminjaman</button>
        </div>

        <section class="table-section" id="aktif-tab" style="display: none;">
            <div class="table-container">
                <div class="table-header">
                    <h2>Peminjaman Aktif</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeLoans as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->buku->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $loan->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $loan->status)) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada peminjaman aktif</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="table-section" id="riwayat-tab">
            <div class="table-container">
                <div class="table-header">
                    <h2>Riwayat Transaksi</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactionHistory as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->buku->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $loan->status }}">
                                    {{ $loan->status === 'returned' ? 'Dikembalikan' : ucfirst(str_replace('_', ' ', $loan->status)) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada riwayat transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="table-section" id="konfirmasi-tab" style="display: none;">
            <div class="table-container">
                <div class="table-header">
                    <h2>Konfirmasi Peminjaman</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loansToConfirm as $loan)
                        <tr id="loan-row-{{ $loan->id }}">
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->buku->judul }}</td>
                            <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $loan->tanggal_kembali ? $loan->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td>
                                Menunggu Konfirmasi Peminjaman
                            </td>
                            <td class="text-right">
                                <button class="btn btn-success btn-sm" onclick="konfirmasiPinjaman({{ $loan->id }}, 'approve', this)">Konfirmasi</button>
                                <button class="btn btn-danger btn-sm" onclick="konfirmasiPinjaman({{ $loan->id }}, 'reject', this)">Tolak</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada peminjaman yang perlu dikonfirmasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>


        <!-- Modal untuk Form Pengembalian -->
        <div id="modalPengembalian" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Catat Pengembalian Buku</h2>
                    <button type="button" class="modal-close" onclick="closeFormPengembalian()">&times;</button>
                </div>
                <form id="formPengembalian" method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label>Nama Peminjam:</label>
                        <input type="text" id="namaPeminjam" readonly style="background-color: #f0f0f0;">
                    </div>
                    <div class="form-group">
                        <label>Judul Buku:</label>
                        <input type="text" id="judulBuku" readonly style="background-color: #f0f0f0;">
                    </div>
                    <div class="form-group">
                        <label for="tanggalPengembalian">Tanggal Pengembalian:</label>
                        <input type="date" id="tanggalPengembalian" name="tanggal_pengembalian" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisiBuku">Kondisi Buku:</label>
                        <select id="kondisiBuku" name="kondisi_buku" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="denda">Denda (Rp):</label>
                        <input type="number" id="denda" name="denda" min="0" value="0">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan:</label>
                        <textarea id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan jika ada..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                        <button type="button" class="btn btn-secondary" onclick="closeFormPengembalian()">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
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
            width: 500px;
            border-radius: 5px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
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
        .form-group input[type="date"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        function showTab(tabName) {
            // hide all tabs first
            document.getElementById('aktif-tab').style.display = 'none';
            document.getElementById('riwayat-tab').style.display = 'none';
            document.getElementById('konfirmasi-tab').style.display = 'none';

            // clear button active states
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

            // show selected tab and mark button
            document.getElementById(tabName + '-tab').style.display = 'block';
            event.target.classList.add('active');
        }

        function showFormPengembalian(pinjamanId, namaPeminjam, judulBuku) {
            document.getElementById('namaPeminjam').value = namaPeminjam;
            document.getElementById('judulBuku').value = judulBuku;
            document.getElementById('tanggalPengembalian').value = new Date().toISOString().split('T')[0];
            document.getElementById('formPengembalian').action = `/petugas/catat-pengembalian/${pinjamanId}`;
            document.getElementById('modalPengembalian').style.display = 'block';
        }

        function closeFormPengembalian() {
            document.getElementById('modalPengembalian').style.display = 'none';
        }


        function konfirmasiPinjaman(loanId, action, button) {
            // Disable button to prevent double click
            button.disabled = true;
            
            fetch(`/petugas/konfirmasi/${loanId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success notification
                    showNotification(data.message, 'success');
                    
                    // Keep the row in the table (don't remove it)
                    // Just disable the buttons
                    const row = document.getElementById(`loan-row-${loanId}`);
                    if (row) {
                        const buttons = row.querySelectorAll('button');
                        buttons.forEach(btn => {
                            btn.disabled = true;
                            btn.style.opacity = '0.6';
                        });
                    }
                } else {
                    showNotification(data.message || 'Terjadi kesalahan', 'error');
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan pada server', 'error');
                button.disabled = false;
            });
        }

        function showNotification(message, type = 'success') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background-color: ${type === 'success' ? '#4CAF50' : '#f44336'};
                color: white;
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                font-weight: 500;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // default tab on page load
            showTab('riwayat');
        });

        window.onclick = function(event) {
            const modal = document.getElementById('modalPengembalian');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>