<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <input type="text" id="adminSearch" placeholder="Cari kategori...">
                <button id="btnAdminSearch">🔍</button>
            </div>
        </header>

        <section class="table-section">
            <div class="table-container" style="max-height: 500px; overflow: auto;">
                <div class="table-header">
                    <h2>Daftar Kategori</h2>
                    <a href="{{ route('admin.kategori.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Kategori
                    </a>
                </div>

                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table style="width: 100%; border-collapse: collapse; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th style="padding: 15px; text-align: left; font-weight: bold;">No</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Nama Kategori</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kat)
                        <tr style="background: #fff; transition: background 0.3s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-weight: 500;">{{ $loop->iteration + ($kategoris->currentPage()-1) * $kategoris->perPage() }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-weight: 500;">{{ $kat->nama }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; text-align: center;">
                                <a href="{{ route('admin.kategori.edit', $kat->id) }}" style="background: #007bff; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; margin-right: 5px; display: inline-block; transition: background 0.3s;" onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" style="background: #dc3545; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#c82333'" onmouseout="this.style.background='#dc3545'"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 40px; text-align: center; color: #6c757d; font-style: italic; background: #f8f9fa;">
                                <i class="fas fa-folder-open" style="font-size: 48px; color: #dee2e6; margin-bottom: 10px;"></i><br>
                                Belum ada kategori yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div style="margin-top: 20px;">
            {{ $kategoris->links() }}
        </div>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
