<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">StudyRead</h2>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ Route::currentRouteName() === 'petugas.dashboard' ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('petugas.kelola-buku.index') }}" class="nav-item {{ Route::currentRouteName() === 'petugas.kelola-buku.index' ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Kelola Buku</span>
        </a>
        <a href="{{ route('petugas.laporan') }}" class="nav-item {{ Route::currentRouteName() === 'petugas.laporan' ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Laporan Pengembalian</span>
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
                <small>Petugas</small>
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
