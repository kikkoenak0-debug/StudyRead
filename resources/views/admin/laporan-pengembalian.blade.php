<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Peminjaman - Perpustakaan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <section class="welcome-section">
            <h1 style="margin-bottom: 20px;">Laporan Peminjaman</h1>
            <p>Daftar transaksi peminjaman buku. Bisa dicetak untuk arsip atau laporan.</p>
        </section>

        <section class="table-section">
            <div class="table-container" id="peminjamanTableContainer">
                <div class="table-header">
                    <h2>Riwayat Transaksi (Peminjaman)</h2>
                    <div class="table-controls">
                        <input type="text" id="searchPeminjaman" placeholder="Cari nama peminjam atau judul buku..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; width: 300px;">
                        <select id="filterStatus" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; margin-left: 10px;">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="returned">Returned</option>
                        </select>
                        <button class="btn btn-secondary btn-sm" style="margin-left:10px;" onclick="printSection('peminjamanTableContainer')">🖨️ Print</button>
                    </div>
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
                    <tbody id="peminjamanRows">
                        @forelse($transactionHistory as $loan)
                        <tr class="peminjaman-row" data-peminjam="{{ strtolower($loan->user->name) }}" data-buku="{{ strtolower($loan->buku->judul) }}" data-status="{{ $loan->status }}">
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

                <div class="pagination">
                    <p>Menampilkan {{ $transactionHistory->count() }} dari {{ $transactionHistory->total() }} data</p>
                    {{ $transactionHistory->links() }}
                </div>
            </div>
        </section>
    </main>

    <script>
        function printSection(containerId) {
            const el = document.getElementById(containerId);
            if (!el) return window.print();
            const w = window.open('', '_blank');
            const styleSheets = Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map(l=>l.href);
            const styles = styleSheets.map(h=>`<link rel="stylesheet" href="${h}">`).join('\n');
            w.document.write(`<!doctype html><html><head><meta charset="utf-8"><title>Print - Laporan Peminjaman</title>${styles}</head><body>${el.outerHTML}</body></html>`);
            w.document.close();
            w.focus();
            setTimeout(()=>{ w.print(); w.close(); }, 500);
        }

        // Search & filter
        document.getElementById('searchPeminjaman')?.addEventListener('keyup', function(e){
            const term = e.target.value.toLowerCase();
            const filter = document.getElementById('filterStatus').value;
            document.querySelectorAll('.peminjaman-row').forEach(row => {
                const peminjam = row.dataset.peminjam || '';
                const buku = row.dataset.buku || '';
                const status = row.dataset.status || '';
                const matchSearch = peminjam.includes(term) || buku.includes(term);
                const matchFilter = !filter || status === filter;
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });
        document.getElementById('filterStatus')?.addEventListener('change', function(e){
            const term = document.getElementById('searchPeminjaman').value.toLowerCase();
            const filter = e.target.value;
            document.querySelectorAll('.peminjaman-row').forEach(row => {
                const peminjam = row.dataset.peminjam || '';
                const buku = row.dataset.buku || '';
                const status = row.dataset.status || '';
                const matchSearch = peminjam.includes(term) || buku.includes(term);
                const matchFilter = !filter || status === filter;
                row.style.display = (matchSearch && matchFilter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
