<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        @media print {
            .sidebar, .top-bar, .btn, .table-header a, .table-header button {
                display: none !important;
            }
            body {
                margin: 0;
            }
            .main-content {
                margin-left: 0 !important;
            }
            table {
                width: 100%;
            }
            th, td {
                padding: 12px;
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <input type="text" id="searchPetugas" placeholder="Cari petugas...">
                <button id="btnSearch">🔍</button>
            </div>
            <button onclick="window.print()" class="print-button" style="margin-left: 10px;">🖨️ Print</button>
        </header>

        <section class="table-section">
            <div class="container">
            <div class="table-container" style="max-height: 640px; overflow: auto;">
                <div class="table-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>Daftar Petugas</h2>
                    <a href="{{ route('admin.kelola-petugas.create') }}" class="btn btn-primary" style="padding: 8px 16px;">➕ Tambah Petugas</a>
                </div>

                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugas as $user)
                        <tr style="background: #fff; transition: background 0.3s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='#fff'">
                            <td class="font-weight-600">{{ $user->id }}</td>
                            <td class="font-weight-600">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="role-badge">{{ $user->role }}</span></td>
                            <td class="text-center">
                                @if($user->is_active)
                                    <span class="status-active">Aktif</span>
                                @else
                                    <span class="status-inactive">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.kelola-pengguna.edit', $user) }}" class="btn btn-sm">Edit</a>

                                    <form action="{{ route('admin.kelola-pengguna.destroy', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>

                                    <form action="{{ route('admin.kelola-petugas.toggle-status', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding: 40px; text-align: center; color: #6c757d; font-style: italic; background: #f8f9fa;">
                                <i class="fas fa-users" style="font-size: 48px; color: #dee2e6; margin-bottom: 10px;"></i><br>
                                Belum ada petugas yang terdaftar.<br>
                                <strong>Tambahkan petugas menggunakan tombol "Tambah Petugas" di atas.</strong>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('searchPetugas').addEventListener('keyup', function(e) {
            const searchValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        document.getElementById('btnSearch').addEventListener('click', function() {
            document.getElementById('searchPetugas').focus();
        });
    </script>
</body>
</html>
