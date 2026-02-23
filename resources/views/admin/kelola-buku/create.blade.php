<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Buku - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    @include('components.admin-sidebar')

    <main class="main-content">
        <div class="form-container" style="margin: 40px auto; max-width: 600px; display: flex; flex-direction: column; align-items: center;">
            <h2>Tambah Buku Baru</h2>
            <form id="bookForm" action="{{ route('admin.kelola-buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
                </div>
                <div class="form-group">
                    <label for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
                </div>
                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" placeholder="Contoh: Gramedia" >
                </div>
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="date" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') ? (\Carbon\Carbon::parse(old('tahun_terbit'))->format('Y-m-d')) : '' }}" placeholder="Contoh: 2021">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                </div>
                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tersedia">Jumlah Tersedia</label>
                    <input type="number" id="tersedia" name="tersedia" value="{{ old('tersedia') }}" required min="0">
                </div>
                <div class="form-group">
                    <label for="sinopsis">Sinopsis</label>
                    <textarea id="sinopsis" name="sinopsis" rows="4" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;">{{ old('sinopsis') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Buku</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Buku</button>
                <a href="{{ route('admin.kelola-buku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </main>

<script src="{{ asset('js/admin.js') }}"></script>
<script>
document.getElementById('bookForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    const formData = new FormData(this);
    try {
        const res = await fetch(this.action, {
            method: this.method || 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (res.redirected) {
            window.location.href = res.url;
            return;
        }

        const contentType = res.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
            const data = await res.json();
            if (data.success) {
                alert(data.message);
                window.location.href = '{{ route("admin.kelola-buku.index") }}';
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        } else {
            window.location.reload();
        }
    } catch (err) {
        alert('Terjadi kesalahan jaringan');
    } finally {
        submitBtn.disabled = false;
    }
});
</script>
</body>
</html>