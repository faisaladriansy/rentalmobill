# 🔐 Kredensial Login - Sistem Rental Mobil

## 👤 User Accounts

### 1. **Admin (Full Access)**
```
Username: admin
Password: admin
Role: admin
Access: Full CRUD operations
```

**Hak Akses Admin:**
- ✅ Kelola Data Transaksi (Create, Read, Update, Delete)
- ✅ Kelola Data Mobil (Create, Read, Update, Delete)
- ✅ Kelola Data Merk (Create, Read, Update, Delete)
- ✅ Kelola Data Supir (Create, Read, Update, Delete)
- ✅ Update Status Mobil
- ✅ Cetak Invoice
- ✅ Lihat Laporan
- ✅ Export Data

---

### 2. **Manager (Read-Only Access)**
```
Username: manager
Password: manager123
Role: manager
Access: Monitoring & Reporting Only
```

**Hak Akses Manager:**
- ✅ Lihat Laporan Transaksi (Read-Only)
- ✅ Pantau Keluar Masuk Mobil (Read-Only)
- ✅ Dashboard Statistik (Read-Only)
- ✅ Export Data Laporan
- ✅ Filter Laporan by Periode
- ✅ Lihat Detail Transaksi
- ❌ **TIDAK BISA** Tambah/Edit/Hapus Data

---

## 🚀 Cara Setup Manager User

### Method 1: Menggunakan Script PHP (Recommended)

1. **Buka browser dan akses:**
   ```
   http://localhost/rentalmobil/setup_manager_user.php
   ```

2. **Script akan otomatis:**
   - Menambahkan kolom 'role' ke tabel user
   - Membuat user manager baru
   - Verifikasi data

3. **Setelah selesai:**
   - Login menggunakan kredensial manager
   - Hapus file `setup_manager_user.php` untuk keamanan

---

### Method 2: Menggunakan SQL Manual

1. **Buka phpMyAdmin**

2. **Pilih database `dbrentalmobil`**

3. **Jalankan SQL berikut:**

```sql
-- Tambah kolom role (jika belum ada)
ALTER TABLE `user` 
ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`;

-- Update user admin yang ada
UPDATE `user` SET `role` = 'admin' WHERE `username` = 'admin';

-- Tambahkan user manager
INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager', NULL, 1);
```

4. **Verifikasi:**
```sql
SELECT * FROM `user`;
```

---

## 📊 Perbandingan Akses

| Fitur | Admin | Manager |
|-------|-------|---------|
| **Login** | ✅ | ✅ |
| **View Transaksi** | ✅ | ✅ |
| **Add Transaksi** | ✅ | ❌ |
| **Edit Transaksi** | ✅ | ❌ |
| **Delete Transaksi** | ✅ | ❌ |
| **View Mobil** | ✅ | ✅ |
| **Kelola Mobil** | ✅ | ❌ |
| **View Laporan** | ✅ | ✅ |
| **Export Data** | ✅ | ✅ |
| **Dashboard** | ✅ | ✅ |
| **Update Status** | ✅ | ❌ |
| **Cetak Invoice** | ✅ | ❌ |

---

## 🔒 Security Notes

### Password Hash
- Password disimpan dalam format **MD5**
- `admin` → MD5: `21232f297a57a5a743894a0e4a801fc3`
- `manager123` → MD5: `1d0258c2440a8d19e716292b231e3190`

### Best Practices
1. ✅ **Ganti password default** setelah login pertama kali
2. ✅ **Gunakan password yang kuat** (min 8 karakter, kombinasi huruf, angka, simbol)
3. ✅ **Jangan share kredensial** dengan orang yang tidak berwenang
4. ✅ **Logout setelah selesai** menggunakan sistem
5. ✅ **Hapus file setup** setelah instalasi selesai

---

## 🆕 Menambah User Manager Baru

Jika ingin menambahkan user manager lainnya:

```sql
-- Contoh: Tambah manager2
INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager2', MD5('password_anda'), 'manager', NULL, 1);

-- Contoh: Tambah manager3
INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager3', MD5('password_anda'), 'manager', NULL, 1);
```

**Generate MD5 Password:**
- Online: https://www.md5hashgenerator.com/
- PHP: `echo md5('your_password');`
- MySQL: `SELECT MD5('your_password');`

---

## 🔄 Reset Password

### Jika Lupa Password Manager:

```sql
-- Reset password manager menjadi 'manager123'
UPDATE `user` 
SET `password` = '1d0258c2440a8d19e716292b231e3190' 
WHERE `username` = 'manager';
```

### Jika Lupa Password Admin:

```sql
-- Reset password admin menjadi 'admin'
UPDATE `user` 
SET `password` = '21232f297a57a5a743894a0e4a801fc3' 
WHERE `username` = 'admin';
```

---

## 🎯 Testing Login

### Test Admin Login:
1. Buka: `http://localhost/rentalmobil/`
2. Username: `admin`
3. Password: `admin`
4. Verifikasi: Bisa akses semua menu

### Test Manager Login:
1. Buka: `http://localhost/rentalmobil/`
2. Username: `manager`
3. Password: `manager123`
4. Verifikasi: Hanya bisa lihat laporan (read-only)

---

## 📞 Troubleshooting

### Problem: Login gagal dengan kredensial manager

**Solution:**
1. Cek apakah user manager sudah dibuat:
   ```sql
   SELECT * FROM `user` WHERE `username` = 'manager';
   ```

2. Cek apakah kolom 'role' ada:
   ```sql
   SHOW COLUMNS FROM `user`;
   ```

3. Jalankan ulang script setup:
   ```
   http://localhost/rentalmobil/setup_manager_user.php
   ```

### Problem: Manager bisa edit data (seharusnya read-only)

**Solution:**
- Implementasi role-based access control di controller
- Cek session role sebelum allow edit/delete
- Hide button edit/delete untuk role manager

---

## 📁 Files Terkait

- `setup_manager_user.php` - Script setup otomatis
- `add_manager_user.sql` - SQL script manual
- `Manager_Role_Documentation.md` - Dokumentasi lengkap Manager
- `KREDENSIAL_LOGIN.md` - File ini

---

## ⚠️ Important Notes

1. **Keamanan:**
   - Hapus file `setup_manager_user.php` setelah setup
   - Jangan commit kredensial ke Git
   - Gunakan environment variables untuk production

2. **Production:**
   - Ganti semua password default
   - Gunakan hashing yang lebih kuat (bcrypt/argon2)
   - Implementasi 2FA untuk keamanan tambahan
   - Regular password rotation

3. **Backup:**
   - Backup database sebelum menambah user
   - Simpan kredensial di tempat yang aman
   - Dokumentasikan perubahan

---

## 📊 Database Schema

```sql
CREATE TABLE `user` (
  `iduser` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('admin','manager') DEFAULT 'admin',
  `lastlogin` datetime DEFAULT NULL,
  `stuser` int(1) DEFAULT '1',
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

---

*Kredensial Login untuk Sistem Rental Mobil v1.0*  
*© 2026 - Keep credentials secure and confidential*