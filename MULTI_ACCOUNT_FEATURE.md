# Fitur Multi-Account Login - Dokumentasi

## Deskripsi Fitur

Fitur ini memungkinkan pengguna untuk login dengan berbagai akun dalam **satu tab browser yang sama**. Pengguna dapat:
- Login dengan beberapa akun sekaligus
- Switch (beralih) antar akun dengan mudah
- Logout dari akun tertentu tanpa logout semua
- Melihat list akun yang sedang aktif

## Cara Kerja

### 1. **Login Pertama**
User login dengan akun pertama (misalnya: user@example.com) → Akun disimpan di tabel `logged_in_accounts`

### 2. **Login Kedua (tanpa logout)**
Klik link login di navbar → Login dengan akun kedua (misalnya: admin@example.com) → Kedua akun sekarang tercatat

### 3. **Switch Akun**
- Klik tombol "Account Switcher" di navbar (icon dengan nama pengguna)
- Pilih salah satu akun dari dropdown
- Sistem akan otomatis logout akun lama dan login dengan akun baru
- Halaman akan redirect sesuai role (Admin → /admin, Petugas → /petugas, User → /home)

### 4. **Logout Spesifik**
- Klik tombol X di sebelah kanan nama akun dalam dropdown
- Akun tersebut akan logout, tapi akun lain tetap login

### 5. **Logout Semua Akun**
- Klik tombol "Logout Semua" di dropdown
- Semua akun akan logout dan redirect ke halaman home

## Komponen yang Ditambahkan

### 1. **Migration** 
File: `database/migrations/2026_01_29_011425_create_logged_in_accounts_table.php`
- Membuat tabel `logged_in_accounts` untuk menyimpan session login multiple

### 2. **Model**
File: `app/Models/LoggedInAccount.php`
- Model untuk interact dengan tabel logged_in_accounts
- Relasi dengan User model

### 3. **Controller**
File: `app/Http/Controllers/AccountController.php`
- `getLoggedAccounts()` - Get list akun yang login dalam session
- `switchAccount($userId)` - Switch ke akun lain
- `logoutAccount($userId)` - Logout dari akun spesifik

### 4. **Routes**
File: `routes/web.php` (tambahan)
```php
Route::middleware('auth')->group(function () {
    Route::get('/api/accounts', [AccountController::class, 'getLoggedAccounts'])->name('accounts.list');
    Route::post('/account/switch/{userId}', [AccountController::class, 'switchAccount'])->name('account.switch');
    Route::post('/account/logout/{userId?}', [AccountController::class, 'logoutAccount'])->name('account.logout');
});
```

### 5. **View Component**
File: `resources/views/components/account-switcher.blade.php`
- UI dropdown untuk menampilkan akun yang login
- Styling modern dengan animasi
- Responsive design

### 6. **Updated AuthController**
File: `app/Http/Controllers/AuthController.php`
- Tambahan logic untuk menyimpan akun ke tabel logged_in_accounts saat login
- Update logout untuk menghapus dari tabel saat logout

### 7. **Updated Layout**
File: `resources/views/layouts/app.blade.php`
- Include account-switcher component
- Tambah meta csrf-token

## Testing

### Test Scenario 1: Login Multiple Accounts
1. Buka aplikasi di browser
2. Klik "Login"
3. Login dengan akun pertama
4. Klik tombol account switcher (nama user di navbar)
5. Akan terlihat 1 akun dalam dropdown
6. Buka halaman login lagi (logout terlebih dahulu JANGAN)
7. Login dengan akun kedua
8. Klik account switcher lagi
9. Sekarang harus terlihat 2 akun dalam dropdown

### Test Scenario 2: Switch Account
1. Dari dropdown, klik salah satu akun lain
2. Sistem akan logout akun saat ini dan login dengan akun baru
3. Halaman akan redirect ke dashboard sesuai role

### Test Scenario 3: Logout Specific Account
1. Dari dropdown, klik tombol X di sebelah salah satu akun
2. Akun tersebut akan logout
3. List akun akan update tanpa reload halaman

### Test Scenario 4: Logout All
1. Klik tombol "Logout Semua" 
2. Semua akun akan logout
3. Redirect ke halaman home

## Akun Test

Untuk testing, gunakan akun berikut (jika sudah ada di database):
- Email: user@example.com, Password: password123
- Email: admin@example.com, Password: password123
- Email: petugas@example.com, Password: password123

Atau daftar akun baru di halaman register.

## Keamanan

✅ Session-based: Setiap session browser memiliki akun terpisah
✅ CSRF Protection: Semua POST request dilindungi CSRF token
✅ Auth Middleware: Routes terlindungi dengan middleware 'auth'
✅ Database: User ID divalidasi dari database sebelum switch/logout

## Browser Support

✅ Chrome
✅ Firefox
✅ Safari
✅ Edge
✅ Mobile browsers

## Troubleshooting

### Dropdown tidak muncul akun?
- Pastikan sudah login minimal 2 akun
- Refresh halaman dan coba lagi
- Check browser console untuk error

### Switch akun tidak berhasil?
- Pastikan meta csrf-token ada di layout
- Check browser console untuk error message
- Pastikan user ID valid di database

### Akun tidak tersimpan?
- Pastikan migration sudah dijalankan: `php artisan migrate`
- Check database table `logged_in_accounts` apakah ada data
- Restart server jika perlu: `php artisan serve`

## Future Enhancements

1. **Remember Last Active Account** - Auto-login ke akun terakhir yang digunakan
2. **Account Activity Log** - Track kapan last login dari setiap akun
3. **Concurrent Account Warning** - Alert jika akun login dari device lain
4. **Session Timeout** - Auto logout jika idle terlalu lama
5. **Account Lock** - Lock akun tertentu setelah logout
6. **Device Recognition** - Tunjukkan device mana saja akun sedang aktif

## Support

Jika ada pertanyaan atau issue, silakan hubungi developer.
