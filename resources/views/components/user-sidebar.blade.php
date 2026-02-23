<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">StudyRead</h2>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('home') }}" class="nav-item {{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('buku.index') }}" class="nav-item {{ Route::currentRouteName() === 'buku.index' ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Buku</span>
        </a>
        <a href="{{ route('tentang.index') }}" class="nav-item {{ Route::currentRouteName() === 'tentang.index' ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i>
            <span>Tentang</span>
        </a>
        <a href="{{ route('favorit.index') }}" class="nav-item {{ Route::currentRouteName() === 'favorit.index' ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>Favorit</span>
        </a>
        <a href="{{ route('riwayat.pinjaman') }}" class="nav-item {{ Route::currentRouteName() === 'riwayat.pinjaman' ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Riwayat</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                @if(auth()->user() && auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    <span>{{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}</span>
                @endif
            </div>
            <div class="user-info">
                <p class="user-name">{{ auth()->user() ? auth()->user()->name : 'Tamu' }}</p>
                <small>Anggota</small>
            </div>
            <div class="dropdown-menu" id="profileDropdown">
                <a href="{{ route('profil.index') }}">Edit Profil</a>
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
