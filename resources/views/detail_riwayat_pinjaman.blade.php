<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat Peminjaman - Ki-Perpus</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .detail-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 1em;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .detail-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .detail-header h1 {
            margin: 0 0 10px 0;
            font-size: 2em;
        }
        .detail-header p {
            margin: 5px 0;
            opacity: 0.9;
        }
        .detail-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .book-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .book-cover {
            width: 100%;
            height: 300px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 15px;
        }
        .book-cover img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .book-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            flex: 0 0 35%;
        }
        .info-value {
            color: #666;
            flex: 1;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            margin-top: 10px;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-approved_pending_payment {
            background: #cfe2ff;
            color: #084298;
        }
        .status-approved {
            background: #d1e7dd;
            color: #0f5132;
        }
        .status-rejected {
            background: #f8d7da;
            color: #842029;
        }
        .status-returned {
            background: #e2e3e5;
            color: #383d41;
        }
        .status-paid {
            background: #d1e7dd;
            color: #0f5132;
        }
        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
        }
        .timeline {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .timeline h3 {
            margin-top: 0;
            color: #333;
        }
        .timeline-item {
            display: flex;
            gap: 20px;
            padding: 15px 0;
            border-left: 3px solid #007bff;
            padding-left: 20px;
        }
        .timeline-item.completed {
            border-left-color: #28a745;
        }
        .timeline-item.pending {
            border-left-color: #ffc107;
        }
        .timeline-dot {
            width: 20px;
            height: 20px;
            background: #007bff;
            border-radius: 50%;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .timeline-item.completed .timeline-dot {
            background: #28a745;
        }
        .timeline-item.pending .timeline-dot {
            background: #ffc107;
        }
        .timeline-content {
            flex: 1;
        }
        .timeline-content strong {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }
        .timeline-content small {
            color: #999;
        }
        @media (max-width: 768px) {
            .detail-content {
                grid-template-columns: 1fr;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .info-value {
                text-align: left;
                margin-top: 5px;
            }
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
  
        

    <main class="main-content">
        <div class="detail-container">
            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 4px solid #28a745;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 4px solid #f5c6cb;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <a href="{{ route('riwayat.pinjaman') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat Peminjaman
            </a>

            <div class="detail-header">
                <h1>{{ $pinjaman->buku->judul }}</h1>
                <p><strong>ID Peminjaman:</strong> #{{ str_pad($pinjaman->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Nama Peminjam:</strong> {{ $pinjaman->user->name ?? '-' }}</p>
                <p><strong>ID Peminjam:</strong> {{ $pinjaman->user->id ?? '-' }}</p>
                <span class="status-badge status-{{ $pinjaman->status }}">
                    <i class="fas fa-info-circle"></i> {{ ucfirst(str_replace('_', ' ', $pinjaman->status)) }}
                </span>
            </div>

            <div class="detail-content">
                <div class="book-section">
                    <div class="book-cover">
                        @if($pinjaman->buku->foto)
                            <img src="{{ asset('storage/' . $pinjaman->buku->foto) }}" alt="{{ $pinjaman->buku->judul }}">
                        @else
                            <i class="fas fa-book" style="font-size: 4em; color: #ccc;"></i>
                        @endif
                    </div>
                    <h3 style="margin: 0 0 10px 0;">{{ $pinjaman->buku->judul }}</h3>
                    <p style="color: #666; margin: 0;">{{ $pinjaman->buku->penulis }}</p>
                </div>

                <div class="book-info">
                    <h3 style="margin-top: 0;">Informasi Peminjaman</h3>
                    
                    <div class="info-row">
                        <div class="info-label">Tanggal Pinjam</div>
                        <div class="info-value">{{ $pinjaman->tanggal_pinjam->format('d M Y') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Tanggal Kembali</div>
                        <div class="info-value">
                            @if($pinjaman->tanggal_kembali)
                                {{ $pinjaman->tanggal_kembali->format('d M Y') }}
                            @else
                                <span style="color: #ff6b6b;">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Durasi Pinjam</div>
                        <div class="info-value">
                            @if($pinjaman->tanggal_kembali)
                                {{ $pinjaman->tanggal_pinjam->diffInDays($pinjaman->tanggal_kembali) }} hari
                            @else
                                Belum ada tanggal kembali
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Status Peminjaman</div>
                        <div class="info-value">
                            @if($pinjaman->status === 'pending')
                                <span style="color: #ffc107;">Menunggu Verifikasi</span>
                            @elseif($pinjaman->status === 'approved')
                                <span style="color: #28a745;">Disetujui</span>
                            @elseif($pinjaman->status === 'approved_pending_payment')
                                <span style="color: #007bff;">Menunggu Pembayaran</span>
                            @elseif($pinjaman->status === 'paid')
                                <span style="color: #28a745;">Sudah Dibayar</span>
                            @elseif($pinjaman->status === 'returned')
                                <span style="color: #6c757d;">Dikembalikan</span>
                            @elseif($pinjaman->status === 'rejected')
                                <span style="color: #dc3545;">Ditolak</span>
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Catatan</div>
                        <div class="info-value">
                            @if($pinjaman->catatan)
                                {{ $pinjaman->catatan }}
                            @else
                                <span style="color: #999;">Tidak ada catatan</span>
                            @endif
                        </div>
                    </div>

                    @if($pinjaman->alamat)
                    <div class="info-row">
                        <div class="info-label">Alamat Pengiriman</div>
                        <div class="info-value">{{ $pinjaman->alamat }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="timeline">
                <h3>Timeline Peminjaman</h3>
                
                <div class="timeline-item completed">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>Permohonan Dibuat</strong>
                        <small>{{ $pinjaman->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>

                @if(in_array($pinjaman->status, ['pending', 'approved', 'approved_pending_payment', 'paid', 'returned']))
                <div class="timeline-item {{ in_array($pinjaman->status, ['approved', 'approved_pending_payment', 'paid', 'returned']) ? 'completed' : 'pending' }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>Verifikasi Petugas</strong>
                        <small>{{ in_array($pinjaman->status, ['approved', 'approved_pending_payment', 'paid', 'returned']) ? 'Selesai' : 'Menunggu...' }}</small>
                    </div>
                </div>
                @endif

                @if($pinjaman->status === 'approved_pending_payment')
                <div class="timeline-item pending">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>Menunggu Pembayaran</strong>
                        <small>Pembayaran belum diterima</small>
                    </div>
                </div>
                @elseif(in_array($pinjaman->status, ['paid', 'returned']))
                <div class="timeline-item completed">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>Pembayaran Diterima</strong>
                        <small>Pembayaran telah dikonfirmasi</small>
                    </div>
                </div>
                @endif

                @if($pinjaman->status === 'returned')
                <div class="timeline-item completed">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <strong>Buku Dikembalikan</strong>
                        <small>Buku telah dikembalikan ke perpustakaan</small>
                    </div>
                </div>
                @endif

                @if($pinjaman->status === 'rejected')
                <div class="timeline-item">
                    <div class="timeline-dot" style="background: #dc3545;"></div>
                    <div class="timeline-content">
                        <strong>Permohonan Ditolak</strong>
                        <small>Alasan: {{ $pinjaman->catatan ?? 'Tidak ada keterangan' }}</small>
                    </div>
                </div>
                @endif
            </div>

            <div class="actions">
                <button class="btn btn-print" onclick="openPrintPreview()">
                    <i class="fas fa-print"></i> Cetak Riwayat
                </button>
                
                @if($pinjaman->status === 'approved_pending_payment')
                <button class="btn btn-success" onclick="window.location.href='{{ route('buku.halamanBayar', $pinjaman->buku->id) }}'">
                    <i class="fas fa-credit-card"></i> Lakukan Pembayaran
                </button>
                @elseif(in_array($pinjaman->status, ['approved', 'paid']))
                <button class="btn btn-warning" onclick="openKembalikanModal()">
                    <i class="fas fa-undo"></i> Kembalikan Buku
                </button>
                @endif
                
                <a href="{{ route('buku.show', $pinjaman->buku->id) }}" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Lihat Detail Buku
                </a>
                
                <a href="{{ route('riwayat.pinjaman') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </main>

    <!-- Modal Pengembalian Buku -->
    <div id="kembalikanModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <span class="close" onclick="closeKembalikanModal()">&times;</span>
            <h2 style="margin-top: 0; color: #333;">Konfirmasi Pengembalian Buku</h2>
            <p style="color: #666; margin: 15px 0;">Apakah Anda yakin ingin mengembalikan buku <strong>"{{ $pinjaman->buku->judul }}"</strong>?</p>
            
            <form id="kembalikanForm" method="POST" action="{{ route('riwayat.kembalikan', $pinjaman->id) }}">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label for="kondisi" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Kondisi Buku:</label>
                    <select id="kondisi" name="kondisi" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em;">
                        <option value="">Pilih kondisi buku</option>
                        <option value="sangat_baik">Sangat Baik</option>
                        <option value="baik">Baik</option>
                        <option value="cukup">Cukup (Ada kerusakan ringan)</option>
                        <option value="kurang">Kurang (Ada kerusakan signifikan)</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="catatan" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Alasan/Catatan Pengembalian (Opsional):</label>
                    <textarea id="catatan" name="catatan" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; resize: vertical;" placeholder="Contoh: Halaman 45 sobek, buku tidak seru, dll..."></textarea>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn btn-secondary" onclick="closeKembalikanModal()">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Kembalikan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Print Preview -->
    <div id="printPreviewModal" class="modal">
        <div class="modal-content print-content" style="max-width:800px;">
            <span class="close" onclick="closePrintPreview()">&times;</span>
            <div id="printPreviewContent"></div>
            <div style="text-align:right; margin-top:20px;">
                <button class="btn btn-primary" onclick="printFromPreview()">Cetak</button>
            </div>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 25px;
            border: 1px solid #888;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .btn-print {
            background: #6f42c1;
            color: white;
        }
        .btn-print:hover {
            background: #5a32a3;
        }
        /* ensure print preview modal only prints its content */
        @media print {
            body * { visibility: hidden; }
            .modal, .print-content, .print-content * { visibility: visible; }
            .print-content { position: absolute; left: 0; top: 0; width: 100%; }
            .back-link,
            .actions,
            .navbar,
            .main-content > .detail-container > .actions {
                display: none !important;
            }
            .detail-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
            .detail-header {
                page-break-after: avoid;
            }
            .detail-content {
                page-break-inside: avoid;
            }
            .timeline {
                page-break-inside: avoid;
            }
            .book-section,
            .book-info,
            .timeline {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
            .info-row {
                page-break-inside: avoid;
            }
            .timeline-item {
                page-break-inside: avoid;
            }
        }
    </style>

    <script>
        function openKembalikanModal() {
            document.getElementById('kembalikanModal').style.display = 'block';
        }

        function closeKembalikanModal() {
            document.getElementById('kembalikanModal').style.display = 'none';
        }

        function openPrintPreview() {
            const previewContainer = document.getElementById('printPreviewContent');
            let clone = document.querySelector('.detail-container').cloneNode(true);
            // remove action buttons from clone
            let acts = clone.querySelector('.actions');
            if (acts) acts.remove();
            previewContainer.innerHTML = '';
            previewContainer.appendChild(clone);
            document.getElementById('printPreviewModal').style.display = 'block';
        }

        function closePrintPreview() {
            document.getElementById('printPreviewModal').style.display = 'none';
        }

        function printFromPreview() {
            window.print();
        }

        // if the URL has a print flag, trigger the print dialog immediately when the page loads
        if (new URLSearchParams(window.location.search).has('print')) {
            // give the browser a small delay to finish rendering before printing
            setTimeout(() => window.print(), 200);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('kembalikanModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
            if (event.target == document.getElementById('printPreviewModal')) {
                closePrintPreview();
            }
        }

        document.getElementById('kembalikanForm').onsubmit = function(e) {
            const kondisi = document.getElementById('kondisi').value;
            if (!kondisi) {
                e.preventDefault();
                alert('Pilih kondisi buku terlebih dahulu');
                return false;
            }
        }
    </script>

    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
