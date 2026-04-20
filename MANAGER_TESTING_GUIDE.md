# 🧪 Manager Testing Guide

## Panduan Lengkap Testing Fitur Manager

---

## 📋 Pre-requisites

### 1. Setup Database
Pastikan sudah menjalankan salah satu:

**Option A: Web Setup (Recommended)**
```
http://localhost/rentalmobil/setup_manager_user.php
```

**Option B: Manual SQL**
```sql
ALTER TABLE `user` 
ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`;

INSERT INTO `user` (`username`, `password`, `role`) 
VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager');
```

### 2. Kredensial Login

**Manager:**
- Username: `manager`
- Password: `manager123`

**Admin:**
- Username: `admin`
- Password: `admin`

---

## ✅ Test Cases

### Test 1: Login sebagai Manager

**Steps:**
1. Buka `http://localhost/rentalmobil/`
2. Login dengan username: `manager`, password: `manager123`
3. Klik tombol Login

**Expected Result:**
- ✅ Login berhasil
- ✅ Redirect ke `/manager` (Dashboard Manager)
- ✅ Navbar menampilkan "manager (Manager)"
- ✅ Menu sidebar menampilkan menu Manager (bukan Admin)

---

### Test 2: Dashboard Manager

**Steps:**
1. Login sebagai Manager
2. Perhatikan Dashboard

**Expected Result:**
- ✅ Menampilkan 4 statistik cards:
  - Mobil Tersedia
  - Mobil Sedang Jalan
  - Transaksi Hari Ini
  - Pendapatan Bulan Ini
- ✅ Menampilkan Occupancy Rate
- ✅ Menampilkan Quick Access Menu (4 tombol)
- ✅ Warna tema purple gradient (#667eea - #764ba2)

---

### Test 3: Monitoring Mobil

**Steps:**
1. Login sebagai Manager
2. Klik menu "Monitoring Mobil"
3. Perhatikan tab "Mobil Tersedia"
4. Klik tab "Mobil Sedang Jalan"
5. Tunggu 30 detik

**Expected Result:**
- ✅ Tab "Mobil Tersedia" menampilkan daftar mobil dengan status "bebas"
- ✅ Tab "Mobil Sedang Jalan" menampilkan mobil dengan status "jalan"
- ✅ Menampilkan informasi pelanggan & tanggal sewa untuk mobil yang jalan
- ✅ Auto-refresh setiap 30 detik (countdown timer muncul)
- ✅ Tombol "View Detail" berfungsi

---

### Test 4: Laporan Transaksi

**Steps:**
1. Login sebagai Manager
2. Klik menu "Laporan Transaksi"
3. Coba filter berdasarkan:
   - Tanggal (dari - sampai)
   - Status (mulai/selesai)
   - Mobil tertentu
4. Klik tombol "Filter"
5. Klik tombol "Export Excel"
6. Klik tombol "Print"
7. Klik "View Detail" pada salah satu transaksi

**Expected Result:**
- ✅ Filter bekerja dengan benar
- ✅ Data transaksi ditampilkan sesuai filter
- ✅ Export Excel mengunduh file .xls
- ✅ Print membuka dialog print browser
- ✅ View Detail menampilkan informasi lengkap transaksi

---

### Test 5: Detail Transaksi

**Steps:**
1. Login sebagai Manager
2. Dari halaman Laporan, klik "View Detail"
3. Perhatikan informasi yang ditampilkan

**Expected Result:**
- ✅ Menampilkan informasi pelanggan lengkap
- ✅ Menampilkan informasi mobil & supir
- ✅ Menampilkan rincian biaya (mobil + supir)
- ✅ Menampilkan status transaksi dengan badge warna
- ✅ Tombol "Kembali ke Laporan" berfungsi

---

### Test 6: Statistik & Analytics

**Steps:**
1. Login sebagai Manager
2. Klik menu "Statistik"
3. Perhatikan grafik dan data

**Expected Result:**
- ✅ Menampilkan 4 info box statistik umum
- ✅ Menampilkan grafik bar chart 6 bulan terakhir
- ✅ Menampilkan Top 10 Mobil Populer
- ✅ Menampilkan rata-rata pendapatan & lama sewa
- ✅ Menampilkan completion rate
- ✅ Quick Actions buttons berfungsi

---

### Test 7: Role-Based Access Control (Manager)

**Steps:**
1. Login sebagai Manager
2. Coba akses URL berikut secara manual:
   - `http://localhost/rentalmobil/transaksi`
   - `http://localhost/rentalmobil/mobil`
   - `http://localhost/rentalmobil/merk`
   - `http://localhost/rentalmobil/supir`

**Expected Result:**
- ✅ Semua akses ditolak
- ✅ Muncul flashdata: "Akses ditolak. Anda tidak memiliki hak untuk mengubah data."
- ✅ Redirect ke `/manager`

---

### Test 8: Role-Based Menu (Manager)

**Steps:**
1. Login sebagai Manager
2. Perhatikan sidebar menu

**Expected Result:**
- ✅ Menu "MENU MANAGER" muncul
- ✅ Menu Admin (Merk, Mobil, Supir, Transaksi) TIDAK muncul
- ✅ Hanya menampilkan:
  - Dashboard
  - Monitoring Mobil
  - Laporan Transaksi
  - Statistik

---

### Test 9: Login sebagai Admin

**Steps:**
1. Logout dari Manager
2. Login dengan username: `admin`, password: `admin`

**Expected Result:**
- ✅ Login berhasil
- ✅ Redirect ke `/transaksi` (bukan `/site`)
- ✅ Navbar menampilkan "admin (Admin)"
- ✅ Menu sidebar menampilkan menu Admin (bukan Manager)

---

### Test 10: Role-Based Menu (Admin)

**Steps:**
1. Login sebagai Admin
2. Perhatikan sidebar menu

**Expected Result:**
- ✅ Menu "MAIN NAVIGATION" muncul
- ✅ Menu Manager TIDAK muncul
- ✅ Menampilkan menu Admin lengkap:
  - Dashboard
  - Merk Mobil
  - Mobil
  - Keterangan (Supir)
  - Transaksi

---

### Test 11: Export Excel

**Steps:**
1. Login sebagai Manager
2. Buka Laporan Transaksi
3. Pilih filter (optional)
4. Klik "Export Excel"

**Expected Result:**
- ✅ File .xls terdownload
- ✅ Nama file: `Laporan_Transaksi_YYYY-MM-DD.xls`
- ✅ File berisi data transaksi sesuai filter
- ✅ Format tabel rapi dengan header

---

### Test 12: Auto Refresh Monitoring

**Steps:**
1. Login sebagai Manager
2. Buka Monitoring Mobil
3. Perhatikan countdown timer di pojok kanan atas
4. Tunggu hingga countdown mencapai 0

**Expected Result:**
- ✅ Countdown dimulai dari 30 detik
- ✅ Countdown berkurang setiap detik
- ✅ Saat mencapai 0, halaman auto-refresh
- ✅ Data mobil ter-update
- ✅ Countdown restart dari 30 detik

---

### Test 13: Print Laporan

**Steps:**
1. Login sebagai Manager
2. Buka Laporan Transaksi
3. Klik tombol "Print"
4. Perhatikan print preview

**Expected Result:**
- ✅ Dialog print browser terbuka
- ✅ Layout print-friendly (tanpa sidebar, navbar)
- ✅ Data transaksi tampil lengkap
- ✅ Format rapi untuk print

---

### Test 14: Logout

**Steps:**
1. Login sebagai Manager atau Admin
2. Klik dropdown user di navbar
3. Klik "Sign out"

**Expected Result:**
- ✅ Session destroyed
- ✅ Redirect ke halaman login
- ✅ Tidak bisa akses halaman Manager/Admin tanpa login

---

## 🐛 Common Issues & Solutions

### Issue 1: Menu tidak muncul
**Cause:** Session 'role' tidak di-set saat login  
**Solution:** Pastikan `Site.php` sudah di-update dengan kode role handling

### Issue 2: Redirect loop
**Cause:** Kondisi role di constructor salah  
**Solution:** Cek kondisi `if($this->session->userdata('role') == 'manager')`

### Issue 3: Data tidak muncul
**Cause:** Model belum di-load  
**Solution:** Pastikan `$this->load->model('managermodel')` ada di constructor

### Issue 4: Export error
**Cause:** Headers sudah di-send sebelumnya  
**Solution:** Pastikan tidak ada output sebelum `header()` di method export

### Issue 5: Chart tidak muncul
**Cause:** Chart.js tidak ter-load  
**Solution:** Pastikan `Chart.min.js` ada di folder `assets/plugins/chartjs/`

---

## 📊 Test Data Requirements

Untuk testing optimal, pastikan database memiliki:

- ✅ Minimal 5 mobil dengan status berbeda (bebas/jalan)
- ✅ Minimal 10 transaksi dengan status berbeda (mulai/selesai)
- ✅ Transaksi dari bulan yang berbeda (untuk grafik)
- ✅ Minimal 2 merk mobil
- ✅ Minimal 3 supir

---

## ✅ Testing Checklist

### Functional Testing
- [ ] Login Manager berhasil
- [ ] Login Admin berhasil
- [ ] Dashboard menampilkan statistik
- [ ] Monitoring menampilkan mobil
- [ ] Laporan menampilkan transaksi
- [ ] Filter laporan bekerja
- [ ] Export Excel berhasil
- [ ] Print laporan berhasil
- [ ] Detail transaksi tampil
- [ ] Statistik & grafik tampil
- [ ] Auto-refresh monitoring bekerja

### Security Testing
- [ ] Manager tidak bisa akses halaman Admin
- [ ] Admin bisa akses semua halaman
- [ ] Logout menghapus session
- [ ] Tidak bisa akses tanpa login
- [ ] Role-based redirect bekerja

### UI/UX Testing
- [ ] Menu sesuai role
- [ ] Navbar menampilkan role
- [ ] Warna tema konsisten (purple gradient)
- [ ] Responsive di mobile
- [ ] Icons tampil dengan benar
- [ ] Buttons berfungsi
- [ ] Flashdata muncul

---

## 🎯 Performance Testing

### Load Time
- Dashboard: < 2 detik
- Monitoring: < 2 detik
- Laporan: < 3 detik
- Statistik: < 3 detik

### Auto Refresh
- Monitoring refresh: setiap 30 detik
- Tidak ada memory leak
- Countdown akurat

---

## 📝 Test Report Template

```
Test Date: _______________
Tester: _______________
Environment: _______________

Test Results:
[ ] All tests passed
[ ] Some tests failed (see details below)

Failed Tests:
1. _______________
2. _______________

Notes:
_______________
_______________
```

---

*Manager Testing Guide v1.0*  
*© 2026 Sistem Rental Mobil*
