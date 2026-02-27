<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">StudyRead</h2>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.kelola-pengguna.index') }}" class="nav-item {{ Route::currentRouteName() === 'admin.kelola-pengguna.index' ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Kelola Pengguna</span>
        </a>
        <a href="{{ route('admin.kelola-petugas.index') }}" class="nav-item {{ Route::currentRouteName() === 'admin.kelola-petugas.index' ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i>
            <span>Kelola Petugas</span>
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ Route::currentRouteName() === 'admin.kategori.index' ? 'active' : '' }}">
            <i class="fas fa-list"></i>
            <span>Kategori</span>
        </a>
        <a href="{{ route('admin.kelola-buku.index') }}" class="nav-item {{ Route::currentRouteName() === 'admin.kelola-buku.index' ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Kelola Buku</span>
        </a>
        <a href="{{ route('admin.laporan') }}" class="nav-item {{ Route::currentRouteName() === 'admin.laporan' ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        
        <a href="{{ route('admin.ulasan') }}" class="nav-item {{ Route::currentRouteName() === 'admin.ulasan' ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>Ulasan</span>
        </a>
        
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                @endif
            </div>
            <div class="user-info">
                <p class="user-name">{{ auth()->user()->name }}</p>
                <small>Administrator</small>
            </div>
            <div class="dropdown-menu" id="profileDropdown">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Anda ingin keluar?')" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
