<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.petugas-sidebar')

    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <input type="text" id="adminSearch" placeholder="Cari buku...">
                <button id="btnAdminSearch">🔍</button>
            </div>
        </header>

        <section class="table-section">
            <div class="table-container" style="max-width: none; overflow-x: auto;">
                <div class="table-header">
                    <h2>Daftar Buku</h2>
                    <div class="header-actions">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <a href="{{ route('petugas.kelola-buku.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table style="width: 100%; border-collapse: collapse; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Foto</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Judul</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Penulis</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Penerbit</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold;">Tahun</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">ISBN</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Kategori</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Dibuat Oleh</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold;">Tersedia</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $item)
                        <tr style="background: #fff; transition: background 0.3s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Buku" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                @else
                                    <span style="color: #6c757d; font-style: italic;">No Image</span>
                                @endif
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-weight: 500;">{{ $item->judul }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $item->penulis }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $item->penerbit ?? '-' }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $item->tahun_terbit ? \Carbon\Carbon::parse($item->tahun_terbit)->format('d/m/Y') : '-' }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-family: monospace;">{{ $item->isbn }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;"><span style="background: #e9ecef; color: #495057; padding: 4px 8px; border-radius: 12px; font-size: 0.85em;">{{ $item->kategori->nama ?? '' }}</span></td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $item->user->name ?? '-' }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; text-align: center; font-weight: bold; color: #28a745;">{{ $item->tersedia }}</td>
                            <td class="text-right action-cell" style="padding: 15px; border-bottom: 1px solid #dee2e6;">
                                <div class="row-actions">
                                    <a href="{{ route('petugas.kelola-buku.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('petugas.kelola-buku.destroy', $item) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="padding: 40px; text-align: center; color: #6c757d; font-style: italic; background: #f8f9fa;">
                                <i class="fas fa-book-open" style="font-size: 48px; color: #dee2e6; margin-bottom: 10px;"></i><br>
                                Belum ada buku yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

<style>
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header-actions button,
    .header-actions a {
        margin-left: 8px;
    }
    .row-actions {
        display: inline-flex;
        gap: 4px;
        justify-content: flex-end;
        align-items: center;
    }
    .action-cell {
        white-space: nowrap;
        min-width: 120px;
    }
</style>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>