<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.admin-sidebar')

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
                        <a href="{{ route('admin.kelola-buku.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>ISBN</th>
                            <th>Kategori</th>
                            <th>Dibuat Oleh</th>
                            <th class="text-center">Tersedia</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $item)
                        <tr>
                            <td>
                                @if($item->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->foto))
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Buku" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div class="text-gray-400" style="width:50px;height:50px;display:flex;align-items:center;justify-content:center;border:1px solid #ddd;border-radius:5px;">📚</div>
                                @endif
                            </td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->penulis }}</td>
                            <td>{{ $item->penerbit ?? '-' }}</td>
                            <td>{{ $item->tahun_terbit ? \Carbon\Carbon::parse($item->tahun_terbit)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->isbn }}</td>
                            <td><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">{{ $item->kategori->nama ?? '' }}</span></td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td class="text-center">{{ $item->tersedia }}</td>
                            <td class="text-right action-cell">
                                <div class="row-actions">
                                    <a href="{{ route('admin.kelola-buku.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.kelola-buku.destroy', $item) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus buku ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada buku.</td>
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
    .table td .btn {
        margin-right: 8px;
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
        th, td { padding:4px !important; font-size:12px; }
    }
</style>
<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>