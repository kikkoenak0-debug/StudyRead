# 🔄 Multi-Account Login Feature

## ⚡ Quick Start

### Cara Menggunakan:

1. **Login Akun Pertama**
   - Buka `/login`
   - Masukkan email & password
   - Submit

2. **Login Akun Kedua (Tanpa Logout)**
   - Buka `/login` lagi (atau register akun baru)
   - Login dengan email/password yang berbeda
   - Sekarang 2 akun sudah active di browser

3. **Switch Antar Akun**
   - Lihat tombol di navbar dengan nama user & icon avatar
   - Klik tombol tersebut
   - Dropdown akan muncul menampilkan semua akun yang login
   - Klik akun yang ingin digunakan → auto switch

4. **Logout Akun Tertentu**
   - Klik dropdown account switcher
   - Klik tombol X di sebelah akun yang mau logout
   - Akun logout, akun lain tetap aktif

## 🧪 Testing Credentials

```
Login dengan akun-akun berikut:
1. user1@test.com / password123    (Role: User)
2. user2@test.com / password123    (Role: User)
3. admin@test.com / password123    (Role: Admin)
4. petugas@test.com / password123  (Role: Petugas)
```

## 📁 Files Added/Modified

### New Files:
- ✅ `database/migrations/2026_01_29_011425_create_logged_in_accounts_table.php`
- ✅ `app/Models/LoggedInAccount.php`
- ✅ `app/Http/Controllers/AccountController.php`
- ✅ `resources/views/components/account-switcher.blade.php`
- ✅ `database/seeders/TestAccountSeeder.php`
- ✅ `MULTI_ACCOUNT_FEATURE.md` (dokumentasi lengkap)

### Modified Files:
- 🔄 `app/Http/Controllers/AuthController.php` - Add multi-account logic
- 🔄 `routes/web.php` - Add account switching routes
- 🔄 `resources/views/layouts/app.blade.php` - Include account-switcher

## 🔐 How It Works

```
┌─────────────────────────────────────────┐
│  Browser Session                         │
│  ┌─────────────────────────────────────┐│
│  │ logged_in_accounts (DB Table)       ││
│  │ ┌──────────────────────────────────┐││
│  │ │ User 1 (Active) ✓               │││
│  │ │ User 2 (Inactive)               │││
│  │ │ User 3 (Inactive)               │││
│  │ └──────────────────────────────────┘││
│  └─────────────────────────────────────┘│
│                                         │
│  Switch User → Logout Old, Login New   │
│  Logout User → Remove from Table       │
└─────────────────────────────────────────┘
```

## 🎯 Features

✨ **Multiple Account Login** - Login dengan berbagai akun dalam 1 tab
🔄 **Easy Account Switching** - Switch antar akun dengan 1 klik
🚪 **Selective Logout** - Logout akun tertentu tanpa logout semua
👥 **Account List** - Lihat daftar akun yang active
📱 **Responsive UI** - Works on mobile & desktop
🔒 **Session-Based** - Setiap session browser terpisah
🛡️ **CSRF Protected** - Semua POST request aman

## 🔧 Database Schema

```sql
CREATE TABLE logged_in_accounts (
    id BIGINT PRIMARY KEY,
    session_id VARCHAR,
    user_id BIGINT FOREIGN KEY,
    logged_at TIMESTAMP,
    last_active_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(session_id, user_id),
    INDEX(session_id)
);
```

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Dropdown tidak muncul akun | Login dengan minimal 2 akun terlebih dahulu |
| Switch akun tidak berhasil | Cek console error, refresh halaman |
| Akun tidak tercatat | Jalankan `php artisan migrate` |
| Test account tidak ada | Jalankan `php artisan db:seed --class=TestAccountSeeder` |

## 📖 Full Documentation

Lihat file `MULTI_ACCOUNT_FEATURE.md` untuk dokumentasi lengkap dan detailed.

## 🚀 Next Steps

Fitur sudah siap digunakan! Silakan:
1. Test dengan credentials di atas
2. Coba login multiple accounts
3. Coba switch antar akun
4. Report bugs jika ada

---

**Created:** 2026-01-29  
**Status:** ✅ Ready to Use
