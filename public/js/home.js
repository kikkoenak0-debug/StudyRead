// home.js
document.addEventListener('DOMContentLoaded', () => {
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');
    const searchBtn = document.getElementById('btnHomeSearch');
    const searchInput = document.getElementById('homeSearch');

    // Klik Profil langsung ke halaman profil
    profileToggle.addEventListener('click', (e) => {
        window.location.href = '/profil';
    });

    // Tutup dropdown jika klik di luar
    window.addEventListener('click', () => {
        profileDropdown.style.display = 'none';
    });

    // Fitur Pencarian
    searchBtn.addEventListener('click', () => {
        const val = searchInput.value;
        if(val) alert("Mencari koleksi: " + val);
    });

    // Ambil nama dari login (localStorage)
    const user = localStorage.getItem('username');
    if(user) {
        document.getElementById('userName').innerText = user;
        document.querySelector('.avatar').innerText = user.charAt(0).toUpperCase();
    }
});