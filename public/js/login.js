// login.js
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const user = document.getElementById('loginUser').value;
        const pass = document.getElementById('loginPass').value;

        // Simulasi Validasi Sederhana
        if (user === "admin" && pass === "12345") {
            alert("Login Berhasil! Selamat datang di Perpustakaan.");
            // Arahkan ke halaman utama perpustakaan
            // window.location.href = 'dashboard.html';
        } else {
            alert("Username atau Password salah. Silakan coba lagi.");
        }
    });
});