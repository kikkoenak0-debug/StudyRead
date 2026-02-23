🚀 START HERE - MULTI-ACCOUNT LOGIN FEATURE
==========================================

**Fitur Multi-Account Login sudah siap digunakan!**

## 📋 Apa Itu Fitur Ini?

Dengan fitur ini, Anda bisa:
✅ Login dengan beberapa akun dalam **1 tab browser yang sama**
✅ Switch (ganti) akun dengan mudah
✅ Logout dari akun tertentu tanpa logout yang lain
✅ Melihat semua akun yang sedang aktif

## ⚡ Mulai Testing (5 Menit)

### Step 1: Buka Aplikasi
```
1. Buka browser
2. Kunjungi: http://localhost:8000
   (atau http://YOUR_IP:8000 jika di device lain)
```

### Step 2: Login Akun Pertama
```
1. Klik "Masuk" atau "Login" di navbar
2. Masukkan:
   Email: user1@test.com
   Password: password123
3. Klik tombol Login
```

### Step 3: Lihat Account Switcher
```
1. Di navbar kanan, lihat tombol dengan nama "User Test 1" + avatar
2. Klik tombol tersebut
3. Dropdown muncul menampilkan 1 akun yang aktif
```

### Step 4: Login Akun Kedua (Tanpa Logout)
```
1. Klik link "Masuk" lagi (atau buka /login di URL bar)
2. Masukkan:
   Email: user2@test.com
   Password: password123
3. Klik Login
```

### Step 5: Verifikasi 2 Akun
```
1. Klik account switcher di navbar lagi
2. Sekarang dropdown menampilkan 2 akun:
   - User Test 1 (sudah tidak aktif)
   - User Test 2 (sekarang aktif, ditandai ✓)
```

### Step 6: Switch Akun
```
1. Dari dropdown, klik "User Test 1"
2. Sistem otomatis switch:
   - Logout dari User Test 2
   - Login dengan User Test 1
   - Navbar berubah ke "Halo, User Test 1"
```

### Step 7: Logout Akun Tertentu
```
1. Klik account switcher lagi
2. Lihat tombol X di sebelah "User Test 2"
3. Klik tombol X tersebut
4. Confirm logout
5. User Test 2 hilang dari list, hanya User Test 1 tersisa
```

### Step 8: Logout Semua
```
1. Klik account switcher
2. Di bawah, klik "Logout Semua"
3. Confirm
4. Redirect ke halaman home (tidak login)
```

## 👥 Test Accounts

Gunakan akun-akun ini untuk testing:

| Email | Password | Role |
|-------|----------|------|
| user1@test.com | password123 | User |
| user2@test.com | password123 | User |
| admin@test.com | password123 | Admin |
| petugas@test.com | password123 | Petugas |

## 🎯 Test Scenarios

### Scenario 1: Login Multiple Users
```
1. Login user1
2. Check account switcher (1 account)
3. Login user2 (same tab)
4. Check account switcher (2 accounts)
5. Login admin (same tab)
6. Check account switcher (3 accounts)
✅ Harusnya bisa login 3+ akun sekaligus
```

### Scenario 2: Test Switch
```
1. Login user1 + user2
2. Account switcher tunjukkan user2 aktif
3. Klik user1 dari dropdown
4. Navbar berubah ke user1, dropdown tunjukkan user1 aktif
5. Klik user2 dari dropdown
6. Navbar berubah ke user2, dropdown tunjukkan user2 aktif
✅ Harusnya bisa switch antar akun dengan mulus
```

### Scenario 3: Test Logout Spesifik
```
1. Login user1 + user2
2. Click X button di user2
3. Confirm logout
4. User2 hilang dari list, user1 masih aktif
5. Click X button di user1
6. Confirm logout
7. Redirect ke home (no active account)
✅ Harusnya bisa logout akun spesifik
```

### Scenario 4: Test Role-Based Redirect
```
1. Login user@test.com → Redirect ke /home
2. Switch ke admin@test.com → Redirect ke /admin
3. Switch ke petugas@test.com → Redirect ke /petugas
4. Switch kembali → Redirect sesuai role
✅ Harusnya redirect otomatis sesuai role
```

## 📱 Test di Mobile

```
1. Cari IP address komputer Anda
   - Windows: ipconfig (cari IPv4 Address)
   - Mac: ifconfig | grep "inet "
   
2. Di mobile browser, buka:
   http://YOUR_IP:8000
   Contoh: http://192.168.1.100:8000

3. Test semua fitur (sama seperti desktop)

4. Perhatikan responsive design:
   - Navbar menyesuaikan ukuran
   - Dropdown tetap centered
   - Avatar kelihatan jelas
```

## 🔍 Apa Yang Harus Dilihat?

### Navbar Element
```
┌─────────────────────────────────────────┐
│ Logo | Halo, User Test 1 | [Avatar]▼    │
└─────────────────────────────────────────┘
                          ↑
                    Klik untuk dropdown
```

### Dropdown Saat Diklik
```
┌────────────────────────────┐
│ AKUN AKTIF                 │
├────────────────────────────┤
│ [Avatar] User Test 1    ✓  │ ← Current active
│ [Avatar] User Test 2       │ ← Clickable to switch
│ [Avatar] Admin Test        │ ← Clickable to switch
├────────────────────────────┤
│ [Logout Semua] button      │
└────────────────────────────┘
```

### Avatar Styles
- Circle shape dengan user initial atau foto
- Gradient background (purple)
- Responsive sizing

## ⚙️ Technical Details (Opsional)

Jika ingin tahu gimana cara kerjanya:

**Database:**
- Tabel baru: `logged_in_accounts`
- Menyimpan session_id + user_id
- Tracks login time dan last activity

**Routes:**
- GET /api/accounts (ambil list akun)
- POST /account/switch/{id} (switch akun)
- POST /account/logout/{id} (logout akun)

**Components:**
- account-switcher component (UI dropdown)
- AccountController (logic switching)
- AuthController (track login/logout)

## 🐛 Troubleshooting

**Dropdown tidak muncul akun?**
- Pastikan sudah login dengan minimal 2 akun
- Refresh halaman (F5)
- Check browser console (F12)

**Switch akun tidak berhasil?**
- Check browser console untuk error
- Pastikan jaringan normal
- Refresh halaman dan coba lagi

**Akun tidak tersimpan?**
- Database migration mungkin belum jalan
- Hubungi developer untuk check migration status

**Test account tidak ada?**
- Jalankan seeder: `php artisan db:seed --class=TestAccountSeeder`
- Atau buat akun baru via register

## 📖 Dokumentasi Lengkap

Jika mau tahu lebih detail:

```
Baca file-file ini:

1. MULTI_ACCOUNT_FEATURE.md
   - Penjelasan lengkap fitur
   - Cara kerja detail
   - FAQ & Troubleshooting

2. SETUP_MULTI_ACCOUNT.md
   - Quick reference guide
   - Test credentials
   - How to use

3. VISUAL_GUIDE.txt
   - UI appearance
   - Interaction flows
   - User journey

4. QUICK_COMMANDS.md
   - Useful commands
   - Database queries
   - Debug tips
```

## ✅ Checklist

Sebelum mulai testing, pastikan:

- [ ] Browser sudah buka ke http://localhost:8000
- [ ] Laravel server sedang jalan (php artisan serve)
- [ ] Database sudah updated (migration ran)
- [ ] Test accounts sudah dibuat (seeder ran)
- [ ] Cache sudah cleared (php artisan cache:clear)

Checklist saat testing:
- [ ] Login akun pertama berhasil
- [ ] Account switcher button terlihat
- [ ] Bisa login akun kedua tanpa logout
- [ ] Dropdown menampilkan 2 akun
- [ ] Bisa switch antar akun
- [ ] Bisa logout akun spesifik
- [ ] Bisa logout semua akun

## 🎉 Selesai!

Jika semua checklist ✅, berarti fitur sudah bekerja dengan baik!

Silakan:
1. Coba berbagai skenario testing
2. Coba di berbagai browser
3. Coba di mobile
4. Report issues jika ada
5. Request improvements jika perlu

---

## 💬 Feedback

Jika ada feedback atau bug:
1. Catat apa yang terjadi
2. Catat langkah-langkah untuk reproduce
3. Screenshot/video jika perlu
4. Report ke developer

---

**Terima kasih sudah menggunakan fitur Multi-Account Login! 🎊**

Untuk bantuan lebih lanjut, lihat dokumentasi di folder ini atau hubungi developer.
