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
            <div class="table-container">
                <div class="table-header">
                    <h2>Daftar Buku</h2>
                    <a href="{{ route('admin.kelola-buku.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Buku
                    </a>
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
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Buku" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <span class="text-gray-400">No Image</span>
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
                            <td class="text-right">
                                <a href="{{ route('admin.kelola-buku.edit', $item) }}" class="btn btn-sm" style="margin-right:8px;">Edit</a>
                                <form action="{{ route('admin.kelola-buku.destroy', $item) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus buku ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
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

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>