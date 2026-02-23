<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        @media print {
            .sidebar, .top-bar, .btn-primary, .table-header a, .table-header button {
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
            .print-button {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <input type="text" id="adminSearch" placeholder="Cari pengguna...">
                <button id="btnAdminSearch">🔍</button>
            </div>
            <button onclick="window.print()" class="print-button" style="background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">🖨️ Print</button>
        </header>

        <section class="table-section">
            <div class="table-container" style="max-height: 500px; overflow: auto;">
                <div class="table-header">
                    <h2>Daftar Pengguna</h2>
                </div>

                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif

                <table style="width: 100%; border-collapse: collapse; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th style="padding: 15px; text-align: left; font-weight: bold;">ID</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Nama</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Email</th>
                            <th style="padding: 15px; text-align: left; font-weight: bold;">Role</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr style="background: #fff; transition: background 0.3s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-weight: 500;">{{ $user->id }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; font-weight: 500;">{{ $user->name }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;">{{ $user->email }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6;"><span style="background: #e9ecef; color: #495057; padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: 500;">{{ $user->role }}</span></td>
                            <td style="padding: 15px; border-bottom: 1px solid #dee2e6; text-align: center;">
                                <span style="background: {{ $user->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $user->is_active ? '#155724' : '#721c24' }}; padding: 4px 8px; border-radius: 12px; font-size: 0.85em; font-weight: 500;">
                                    {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 40px; text-align: center; color: #6c757d; font-style: italic; background: #f8f9fa;">
                                <i class="fas fa-users" style="font-size: 48px; color: #dee2e6; margin-bottom: 10px;"></i><br>
                                Belum ada pengguna yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        document.getElementById('adminSearch').addEventListener('keyup', function(e) {
            const searchValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        document.getElementById('btnAdminSearch').addEventListener('click', function() {
            document.getElementById('adminSearch').focus();
        });
    </script>
</body>
</html>