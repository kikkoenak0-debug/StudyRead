// admin.js
document.addEventListener('DOMContentLoaded', () => {
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');
    const searchBtn = document.getElementById('btnAdminSearch');
    const searchInput = document.getElementById('adminSearch');

    // Toggle Dropdown Profil
    if (profileToggle && profileDropdown) {
        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isVisible = profileDropdown.style.display === 'block';
            profileDropdown.style.display = isVisible ? 'none' : 'block';
        });

        // Tutup dropdown jika klik di luar
        window.addEventListener('click', () => {
            profileDropdown.style.display = 'none';
        });
    }

    // Fitur Pencarian
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', () => {
            const val = searchInput.value;
            if (val) alert("Mencari: " + val);
        });
    }

    // Ambil nama dari auth (sesuai Laravel)
    const userName = document.getElementById('userName');
    if (userName) {
        // Asumsikan nama sudah diisi dari blade
    }
});