<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-6">
                <img src="{{ asset('images/logo.svg') }}" alt="StudyRead Logo" class="h-10 w-auto">
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-6 hover:bg-blue-700">Dashboard</a>
                <a href="{{ route('admin.riwayat-transaksi') }}" class="block py-2 px-6 bg-blue-700">Riwayat Peminjaman</a>
                <a href="{{ route('admin.kelola-pengguna.index') }}" class="block py-2 px-6 hover:bg-blue-700">Kelola Pengguna</a>
                <a href="{{ route('admin.kelola-buku.index') }}" class="block py-2 px-6 hover:bg-blue-700">Kelola Buku</a>
                <form action="{{ route('logout') }}" method="POST" class="block py-2 px-6 hover:bg-blue-700">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Riwayat Peminjaman</h1>

            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Buku</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Tanggal Kembali</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $t)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $t->id }}</td>
                            <td class="px-4 py-2">{{ $t->user->name }}</td>
                            <td class="px-4 py-2">{{ $t->buku->judul }}</td>
                            <td class="px-4 py-2">{{ $t->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $t->tanggal_kembali ? $t->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-2">
                                @if($t->status == 'paid')
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded">Dibayar</span>
                                @elseif($t->status == 'approved')
                                    <span class="bg-green-500 text-white px-2 py-1 rounded">Aktif</span>
                                @elseif($t->status == 'returned')
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>

</body>
</html>