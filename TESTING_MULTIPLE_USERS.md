# 🧪 Testing Multiple Users Bersamaan

## 📌 Penjelasan

Sistem rental mobil menggunakan session-based authentication. Satu browser hanya bisa login sebagai satu user pada satu waktu. Ini adalah fitur keamanan yang BENAR dan PENTING.

**Kenapa tidak bisa login bersamaan di browser yang sama?**
- Session browser menyimpan informasi login
- Ketika login user baru, session lama akan di-replace
- Ini mencegah satu orang mengakses multiple accounts sekaligus
- Standard security practice untuk web applications

---

## ✅ Solusi Testing Multiple Users

### Metode 1: Browser Berbeda (RECOMMENDED)

Gunakan browser yang berbeda untuk setiap user:

```
Chrome     → Login sebagai Admin
Firefox    → Login sebagai Manager
Edge       → Login sebagai user lain (jika ada)
Opera      → Login sebagai user lain (jika ada)
```

**Langkah-langkah:**

1. **Buka Chrome**
   ```
   URL: http://localhost/rentalmobil/
   Username: admin
   Password: admin
   ```

2. **Buka Firefox** (jangan tutup Chrome)
   ```
   URL: http://localhost/rentalmobil/
   Username: manager
   Password: manager123
   ```

3. **Sekarang Anda bisa:**
   - Switch antara Chrome (Admin) dan Firefox (Manager)
   - Melihat perbedaan menu dan akses
   - Testing fitur secara bersamaan

---

### Metode 2: Incognito/Private Window

Gunakan normal window dan incognito window di browser yang sama:

**Google Chrome:**
```
Window Normal:
  - Login sebagai Admin
  - URL: http://localhost/rentalmobil/

Window Incognito (Ctrl+Shift+N):
  - Login sebagai Manager
  - URL: http://localhost/rentalmobil/
```

**Mozilla Firefox:**
```
Window Normal:
  - Login sebagai Admin

Private Window (Ctrl+Shift+P):
  - Login sebagai Manager
```

**Microsoft Edge:**
```
Window Normal:
  - Login sebagai Admin

InPrivate Window (Ctrl+Shift+N):
  - Login sebagai Manager
```

**Keuntungan:**
- Tidak perlu install browser lain
- Session terpisah antara normal dan incognito
- Mudah switch dengan Alt+Tab

---

### Metode 3: Chrome Multiple Profiles

Chrome memiliki fitur multiple profiles yang sangat berguna:

**Setup Chrome Profiles:**

1. **Buat Profile Admin**
   ```
   1. Klik icon profile di pojok kanan atas Chrome
   2. Klik "Add" atau "Tambah"
   3. Pilih "Continue without an account"
   4. Nama: "Admin Profile"
   5. Pilih warna/icon: Merah
   ```

2. **Buat Profile Manager**
   ```
   1. Klik icon profile di pojok kanan atas Chrome
   2. Klik "Add" atau "Tambah"
   3. Pilih "Continue without an account"
   4. Nama: "Manager Profile"
   5. Pilih warna/icon: Ungu
   ```

3. **Gunakan Profiles**
   ```
   Profile Admin (Window 1):
     - Login sebagai admin
     - Warna merah di pojok kanan atas
   
   Profile Manager (Window 2):
     - Login sebagai manager
     - Warna ungu di pojok kanan atas
   ```

**Keuntungan:**
- Session benar-benar terpisah
- Bisa buka banyak window per profile
- History dan cookies terpisah
- Sangat berguna untuk development

---

### Metode 4: Portable Browser

Download portable browser untuk testing:

**Chrome Portable:**
```
Download: https://portableapps.com/apps/internet/google_chrome_portable
Install: Tidak perlu install, langsung jalankan
Gunakan: Login sebagai Manager
```

**Firefox Portable:**
```
Download: https://portableapps.com/apps/internet/firefox_portable
Install: Tidak perlu install, langsung jalankan
Gunakan: Login sebagai Admin
```

---

## 🎯 Skenario Testing

### Skenario 1: Compare Menu & Access

**Tujuan:** Membandingkan menu Admin vs Manager

**Steps:**
1. Browser 1 (Chrome): Login sebagai Admin
2. Browser 2 (Firefox): Login sebagai Manager
3. Letakkan kedua browser side-by-side
4. Bandingkan:
   - Menu sidebar
   - Navbar (role badge)
   - Halaman yang bisa diakses

**Expected:**
- Admin: Menu lengkap (Merk, Mobil, Supir, Transaksi)
- Manager: Menu terbatas (Dashboard, Monitoring, Laporan, Statistik)

---

### Skenario 2: Test Access Control

**Tujuan:** Verify Manager tidak bisa akses halaman Admin

**Steps:**
1. Browser 1: Login sebagai Manager
2. Coba akses URL Admin:
   ```
   http://localhost/rentalmobil/transaksi
   http://localhost/rentalmobil/mobil
   http://localhost/rentalmobil/merk
   ```
3. Browser 2: Login sebagai Admin
4. Akses URL yang sama

**Expected:**
- Manager: Access denied, redirect ke /manager
- Admin: Bisa akses semua halaman

---

### Skenario 3: Real-time Monitoring

**Tujuan:** Test auto-refresh monitoring

**Steps:**
1. Browser 1 (Admin): Buka halaman Transaksi
2. Browser 2 (Manager): Buka halaman Monitoring
3. Di Browser 1: Ubah status mobil (mulai transaksi)
4. Di Browser 2: Tunggu auto-refresh (30 detik)

**Expected:**
- Manager monitoring ter-update otomatis
- Status mobil berubah dari "tersedia" ke "jalan"

---

### Skenario 4: Concurrent Export

**Tujuan:** Test export bersamaan

**Steps:**
1. Browser 1 (Admin): Export data dari halaman Transaksi
2. Browser 2 (Manager): Export laporan dari halaman Laporan
3. Kedua export harus berhasil

**Expected:**
- Kedua file ter-download
- Tidak ada conflict
- Data sesuai dengan role masing-masing

---

## 🖥️ Setup Testing Environment

### Recommended Setup untuk Development:

```
Monitor 1 (Kiri):
  ├── Chrome (Admin)
  │   ├── Tab 1: Dashboard
  │   ├── Tab 2: Transaksi
  │   └── Tab 3: Mobil

Monitor 2 (Kanan):
  ├── Firefox (Manager)
  │   ├── Tab 1: Dashboard
  │   ├── Tab 2: Monitoring
  │   └── Tab 3: Laporan
```

### Single Monitor Setup:

```
Split Screen (Windows: Win + Arrow):
  ├── Kiri: Chrome (Admin)
  └── Kanan: Firefox (Manager)
```

---

## 📱 Testing di Mobile

### Android:

**Chrome:**
```
1. Buka Chrome
2. Login sebagai Admin
3. Menu → New Incognito Tab
4. Login sebagai Manager
```

**Firefox:**
```
1. Buka Firefox
2. Login sebagai Admin
3. Menu → New Private Tab
4. Login sebagai Manager
```

### iOS:

**Safari:**
```
1. Buka Safari
2. Login sebagai Admin
3. New Private Tab
4. Login sebagai Manager
```

**Chrome iOS:**
```
1. Buka Chrome
2. Login sebagai Admin
3. New Incognito Tab
4. Login sebagai Manager
```

---

## 🔧 Troubleshooting

### Problem: Session tetap bentrok

**Solution:**
```
1. Clear browser cache & cookies
2. Restart browser
3. Coba browser berbeda
4. Pastikan menggunakan incognito/private window
```

### Problem: Login di browser kedua logout browser pertama

**Cause:** Menggunakan browser yang sama tanpa incognito

**Solution:**
```
1. Gunakan incognito window, ATAU
2. Gunakan browser berbeda, ATAU
3. Gunakan Chrome profiles
```

### Problem: Tidak bisa buka incognito

**Solution:**
```
Chrome: Ctrl + Shift + N
Firefox: Ctrl + Shift + P
Edge: Ctrl + Shift + N
Safari: Cmd + Shift + N (Mac)
```

---

## 📊 Testing Checklist

### Pre-Testing
```
[ ] Install minimal 2 browsers (Chrome + Firefox)
[ ] Clear cache & cookies
[ ] Prepare test credentials
[ ] Open testing documentation
```

### During Testing
```
[ ] Login Admin di Browser 1
[ ] Login Manager di Browser 2
[ ] Verify menu berbeda
[ ] Test access control
[ ] Test all features
[ ] Compare UI/UX
[ ] Test concurrent actions
```

### Post-Testing
```
[ ] Logout dari semua browser
[ ] Clear cache & cookies
[ ] Document any issues found
[ ] Report bugs (if any)
```

---

## 🎓 Best Practices

### DO:
✅ Gunakan browser berbeda untuk testing
✅ Gunakan incognito window
✅ Clear cache sebelum testing
✅ Test access control thoroughly
✅ Document test results

### DON'T:
❌ Jangan login 2 user di browser yang sama (tanpa incognito)
❌ Jangan share session antar users
❌ Jangan skip logout setelah testing
❌ Jangan test di production dengan multiple logins

---

## 🚀 Quick Start Guide

**Cara Tercepat untuk Testing:**

```bash
# Step 1: Buka Chrome
1. Buka Chrome
2. Go to: http://localhost/rentalmobil/
3. Login: admin / admin

# Step 2: Buka Firefox
1. Buka Firefox (jangan tutup Chrome)
2. Go to: http://localhost/rentalmobil/
3. Login: manager / manager123

# Step 3: Test
1. Switch antara Chrome dan Firefox (Alt+Tab)
2. Bandingkan menu dan fitur
3. Test access control
4. Done!
```

---

## 📝 Testing Template

```
Test Date: _______________
Tester: _______________

Browser Setup:
[ ] Browser 1: __________ (User: __________)
[ ] Browser 2: __________ (User: __________)

Test Results:
[ ] Both users can login simultaneously
[ ] Menus display correctly per role
[ ] Access control working
[ ] No session conflicts
[ ] All features working

Issues Found:
1. _______________
2. _______________

Notes:
_______________
```

---

## 💡 Tips & Tricks

### Tip 1: Keyboard Shortcuts
```
Alt + Tab        : Switch between browsers
Ctrl + Shift + N : Chrome Incognito
Ctrl + Shift + P : Firefox Private
F5               : Refresh page
Ctrl + F5        : Hard refresh (clear cache)
```

### Tip 2: Browser Extensions
```
- Session Manager: Manage multiple sessions
- User-Agent Switcher: Test different devices
- Window Resizer: Test responsive design
```

### Tip 3: Developer Tools
```
F12              : Open DevTools
Ctrl + Shift + C : Inspect element
Ctrl + Shift + J : Console
```

---

## 🎯 Summary

**Untuk testing Admin dan Manager bersamaan:**

1. **Paling Mudah:** Gunakan Chrome + Firefox
2. **Paling Praktis:** Gunakan Incognito Window
3. **Paling Professional:** Gunakan Chrome Profiles
4. **Paling Fleksibel:** Gunakan Portable Browsers

**Remember:** Ini adalah behavior yang BENAR untuk security. Jangan ubah sistem untuk allow multiple logins di browser yang sama untuk production!

---

*Testing Guide v1.0*  
*Happy Testing! 🚀*
