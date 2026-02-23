<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Ki-Perpus</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .loan-history {
            margin-top: 20px;
        }
        .loan-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .loan-item h4 {
            margin: 0 0 10px 0;
        }
        .loan-details {
            color: #666;
            font-size: 0.9em;
        }
        .status-pending {
            color: orange;
        }
        .status-approved_pending_payment {
            color: blue;
        }
        .status-approved {
            color: green;
        }
        .status-rejected {
            color: red;
        }
        .status-returned {
            color: gray;
        }
        .btn-bayar {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-bayar:hover {
            background-color: #0056b3;
        }
        .btn-kembali {
            background-color: #ffc107;
            color: #333;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-kembali:hover {
            background-color: #e0a800;
        }
        .btn-print {
            background-color: #6f42c1;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #5a32a3;
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
        /* general modal styling (used for print preview) */
        .modal{
            display:none;
            position:fixed;
            z-index:1000;
            left:0;top:0;
            width:100%;height:100%;
            overflow:auto;
            background-color:rgba(0,0,0,0.4);
        }
        .modal-content{
            background-color:#fefefe;
            margin:10% auto;
            padding:25px;
            border:1px solid #888;
            border-radius:8px;
            box-shadow:0 4px 6px rgba(0,0,0,0.1);
            max-width:800px;
            line-height:1.6;
        }
        .modal-content h2 {
            margin-top:0;
            margin-bottom:15px;
        }
        .modal-content p,
        .modal-content ul li {
            margin-bottom:10px;
        }
        .modal-content ul {
            padding-left:20px;
        }
        .modal-content hr {
            margin:20px 0;
        }
        .close{
            color:#aaa;
            float:right;
            font-size:28px;
            font-weight:bold;
            cursor:pointer;
        }
        .close:hover{
            color:#000;
        }
        /* print: only show the modal with print-content */
        @media print {
            body * { visibility: hidden; }
            .modal, .print-content, .print-content * { visibility: visible; }
            .print-content { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</head>
<body>
    @include('components.user-sidebar')

    <main class="main-content">
        <header class="top-bar">
            <h1>Riwayat Peminjaman Buku</h1>
        </header>

        <section class="loan-history">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif
            @forelse($pinjaman as $item)
            <div class="loan-item">
                <h4>{{ $item->buku->judul }}</h4>
                <div class="loan-details">
                    <p><strong>Tanggal Pinjam:</strong> {{ $item->tanggal_pinjam->format('d/m/Y') }}</p>
                    <p><strong>Tanggal Kembali:</strong> {{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d/m/Y') : 'Belum ditentukan' }}</p>
                    <p><strong>Status:</strong> <span class="status-{{ $item->status }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></p>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                    <a href="{{ route('riwayat.detail', $item->id) }}" style="background: #6c757d; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block;">
                        📋 Lihat Detail
                    </a>
                    <button class="btn-print" onclick="openPrintModal({{ $item->id }})">
                        🖨️ Cetak
                    </button>
                    @if($item->status === 'approved_pending_payment')
                    <button class="btn-bayar" onclick="window.location.href='{{ route('buku.halamanBayar', $item->buku->id) }}'">💳 Bayar Sekarang</button>
                    @elseif(in_array($item->status, ['approved', 'paid']))
                    <button class="btn-kembali" onclick="window.location.href='{{ route('riwayat.detail', $item->id) }}'">↩️ Kembalikan Buku</button>
                    @elseif($item->status === 'paid')
                    <p style="color: blue; margin: 0; padding: 8px 0;">Peminjaman sedang diproses. Tunggu konfirmasi petugas.</p>
                    @elseif($item->status === 'approved')
                    <p style="color: green; margin: 0; padding: 8px 0;">Peminjaman berhasil. Selamat membaca!</p>
                    @endif
                </div>
            </div>
            <!-- print preview modal for this loan -->
            <div id="printModal-{{ $item->id }}" class="modal">
                <div class="modal-content print-content" style="max-width:800px;">
                    <span class="close" onclick="closePrintModal({{ $item->id }})">&times;</span>
                    <h2>{{ $item->buku->judul }}</h2>
                    <p><strong>ID Peminjaman:</strong> #{{ str_pad($item->id,5,'0',STR_PAD_LEFT) }}</p>
                    <p><strong>Nama Peminjam:</strong> {{ $item->user->name }}</p>
                    <p><strong>ID Peminjam:</strong> {{ $item->user->id }}</p>
                    <p><strong>Status:</strong> {{ ucfirst(str_replace('_',' ',$item->status)) }}</p>
                    <hr>
                    <p><strong>Tanggal Pinjam:</strong> {{ $item->tanggal_pinjam->format('d/m/Y') }}</p>
                    <p><strong>Tanggal Kembali:</strong> {{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d/m/Y') : 'Belum ditentukan' }}</p>
                    <p><strong>Catatan:</strong> {{ $item->catatan ?? '-' }}</p>
                    <h3>Timeline</h3>
                    <ul style="list-style:none;padding:0;">
                        <li>Permohonan Dibuat: {{ $item->created_at->format('d M Y H:i') }}</li>
                        @if(in_array($item->status, ['approved','approved_pending_payment','paid','returned']))
                        <li>Verifikasi Petugas: Selesai</li>
                        @else
                        <li>Verifikasi Petugas: Menunggu</li>
                        @endif
                        @if($item->status === 'approved_pending_payment')
                        <li>Menunggu Pembayaran</li>
                        @elseif(in_array($item->status,['paid','returned']))
                        <li>Pembayaran Diterima</li>
                        @endif
                        @if($item->status === 'returned')
                        <li>Buku Dikembalikan</li>
                        @endif
                        @if($item->status === 'rejected')
                        <li>Permohonan Ditolak: {{ $item->catatan ?? 'Tidak ada keterangan' }}</li>
                        @endif
                    </ul>
                    <button class="btn btn-primary" onclick="printModalContent({{ $item->id }})">Cetak</button>
                </div>
            </div>
            @empty
            <p>Belum ada riwayat peminjaman.</p>
            <a href="{{ route('buku.index') }}" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Pinjam Buku Sekarang</a>
            @endforelse
        </section>
    </main>

<script>
    function openPrintModal(id) {
        document.getElementById('printModal-' + id).style.display = 'block';
    }

    function closePrintModal(id) {
        document.getElementById('printModal-' + id).style.display = 'none';
    }

    function printModalContent(id) {
        window.print();
    }

    // close any modal when clicking outside of its content
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    };
</script>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>