# Use Case Diagram - Sistem Rental Mobil

## 🎭 Actors (Aktor)

### 1. **Admin Rental** 👨‍💼
- **Deskripsi**: Pengelola sistem rental mobil
- **Tanggung Jawab**: Mengelola semua data dan transaksi
- **Akses**: Full access ke semua fitur sistem

### 2. **Customer** 👤
- **Deskripsi**: Pelanggan yang menyewa mobil
- **Tanggung Jawab**: Memberikan data dan melakukan pembayaran
- **Akses**: Tidak langsung (melalui admin)

### 3. **Supir** 🚗
- **Deskripsi**: Driver yang melayani customer
- **Tanggung Jawab**: Mengemudikan mobil rental
- **Akses**: Tidak langsung (data dikelola admin)

---

## 📋 Use Cases

### 🔐 **Authentication & Authorization**

#### UC-001: Login Sistem
- **Aktor**: Admin Rental
- **Deskripsi**: Admin masuk ke sistem dengan username dan password
- **Precondition**: Admin memiliki akun valid
- **Postcondition**: Admin berhasil masuk dan dapat mengakses sistem
- **Main Flow**:
  1. Admin membuka halaman login
  2. Admin memasukkan username dan password
  3. Sistem memvalidasi kredensial
  4. Sistem menampilkan dashboard utama
- **Alternative Flow**: 
  - 3a. Kredensial salah → Tampilkan pesan error
- **Exception**: Sistem down, database error

#### UC-002: Logout Sistem
- **Aktor**: Admin Rental
- **Deskripsi**: Admin keluar dari sistem
- **Main Flow**:
  1. Admin klik menu logout
  2. Sistem hapus session
  3. Redirect ke halaman login

---

### 🏷️ **Manajemen Data Merk**

#### UC-003: Kelola Data Merk
- **Aktor**: Admin Rental
- **Deskripsi**: Admin mengelola data merk mobil (Toyota, Honda, dll)
- **Main Flow**:
  1. Admin pilih menu "Data Merk"
  2. Sistem tampilkan daftar merk
  3. Admin dapat tambah/edit/hapus merk
- **Business Rules**: 
  - Merk tidak bisa dihapus jika masih ada mobil yang menggunakan

#### UC-004: Tambah Merk Baru
- **Aktor**: Admin Rental
- **Include**: UC-003
- **Main Flow**:
  1. Admin klik "Tambah Merk"
  2. Admin input nama merk
  3. Sistem validasi data
  4. Sistem simpan ke database
  5. Tampilkan konfirmasi sukses

#### UC-005: Edit Data Merk
- **Aktor**: Admin Rental
- **Include**: UC-003
- **Main Flow**:
  1. Admin pilih merk yang akan diedit
  2. Admin ubah data merk
  3. Sistem update database
  4. Tampilkan konfirmasi sukses

#### UC-006: Hapus Data Merk
- **Aktor**: Admin Rental
- **Include**: UC-003
- **Precondition**: Merk tidak digunakan oleh mobil manapun
- **Main Flow**:
  1. Admin pilih merk yang akan dihapus
  2. Sistem cek constraint (ada mobil yang menggunakan?)
  3. Jika aman, hapus dari database
  4. Tampilkan konfirmasi sukses
- **Alternative Flow**:
  - 2a. Ada mobil yang menggunakan → Tampilkan pesan error

---

### 🚗 **Manajemen Data Mobil**

#### UC-007: Kelola Data Mobil
- **Aktor**: Admin Rental
- **Deskripsi**: Admin mengelola data mobil dan status ketersediaan
- **Main Flow**:
  1. Admin pilih menu "Data Mobil"
  2. Sistem tampilkan daftar mobil dengan merk dan status
  3. Admin dapat tambah/edit/hapus/update status mobil

#### UC-008: Tambah Mobil Baru
- **Aktor**: Admin Rental
- **Include**: UC-007
- **Extend**: UC-003 (Pilih Merk)
- **Main Flow**:
  1. Admin klik "Tambah Mobil"
  2. Admin pilih merk dari dropdown
  3. Admin input detail mobil (type, plat, tarif, dll)
  4. Admin upload foto mobil
  5. Sistem set status default "Tersedia"
  6. Sistem simpan ke database

#### UC-009: Edit Data Mobil
- **Aktor**: Admin Rental
- **Include**: UC-007
- **Main Flow**:
  1. Admin pilih mobil yang akan diedit
  2. Admin ubah data mobil
  3. Sistem update database
  4. Tampilkan konfirmasi sukses

#### UC-010: Update Status Mobil
- **Aktor**: Admin Rental
- **Include**: UC-007
- **Deskripsi**: Admin mengubah status mobil (Tersedia ↔ Jalan)
- **Main Flow**:
  1. Admin lihat status mobil saat ini
  2. Admin klik button toggle status
  3. Sistem konfirmasi perubahan
  4. Admin konfirmasi
  5. Sistem update status di database
- **Business Rules**:
  - Status otomatis berubah saat ada transaksi

#### UC-011: Hapus Data Mobil
- **Aktor**: Admin Rental
- **Include**: UC-007
- **Precondition**: Mobil tidak sedang dalam transaksi aktif
- **Main Flow**:
  1. Admin pilih mobil yang akan dihapus
  2. Sistem cek constraint (ada transaksi aktif?)
  3. Jika aman, hapus dari database
- **Alternative Flow**:
  - 2a. Ada transaksi aktif → Tampilkan pesan error

---

### 👨‍💼 **Manajemen Data Supir**

#### UC-012: Kelola Data Supir
- **Aktor**: Admin Rental
- **Deskripsi**: Admin mengelola data supir/driver
- **Main Flow**:
  1. Admin pilih menu "Data Supir"
  2. Sistem tampilkan daftar supir
  3. Admin dapat tambah/edit/hapus supir

#### UC-013: Tambah Supir Baru
- **Aktor**: Admin Rental
- **Include**: UC-012
- **Main Flow**:
  1. Admin klik "Tambah Supir"
  2. Admin input data supir (nama, alamat, tarif, dll)
  3. Admin upload foto supir
  4. Sistem simpan ke database

#### UC-014: Edit Data Supir
- **Aktor**: Admin Rental
- **Include**: UC-012
- **Main Flow**:
  1. Admin pilih supir yang akan diedit
  2. Admin ubah data supir
  3. Sistem update database

#### UC-015: Hapus Data Supir
- **Aktor**: Admin Rental
- **Include**: UC-012
- **Main Flow**:
  1. Admin pilih supir yang akan dihapus
  2. Sistem hapus dari database
  3. Transaksi terkait berubah menjadi "Lepas Kunci"
- **Business Rules**:
  - Supir bisa dihapus, transaksi tidak terpengaruh (SET NULL)

---

### 📋 **Manajemen Transaksi**

#### UC-016: Kelola Data Transaksi
- **Aktor**: Admin Rental
- **Deskripsi**: Admin mengelola semua transaksi rental
- **Main Flow**:
  1. Admin pilih menu "Data Transaksi"
  2. Sistem tampilkan daftar transaksi dengan detail lengkap
  3. Admin dapat tambah/edit/selesaikan transaksi

#### UC-017: Tambah Transaksi Baru
- **Aktor**: Admin Rental, Customer (indirect)
- **Include**: UC-016
- **Extend**: UC-007 (Pilih Mobil), UC-012 (Pilih Supir)
- **Deskripsi**: Admin membuat transaksi rental baru untuk customer
- **Precondition**: Ada mobil yang tersedia
- **Main Flow**:
  1. Customer datang ke rental
  2. Admin buka form "Tambah Transaksi"
  3. Admin input data customer (nama, KTP, HP, alamat)
  4. Admin pilih mobil dari daftar yang tersedia
  5. Admin pilih supir atau "Lepas Kunci"
  6. Admin set tanggal sewa dan tanggal kembali
  7. Sistem hitung otomatis lama hari dan total biaya
  8. Admin konfirmasi dan simpan transaksi
  9. Sistem update status mobil menjadi "Jalan"
  10. Sistem generate ID transaksi
- **Postcondition**: 
  - Transaksi tersimpan dengan status "Mulai"
  - Mobil tidak tersedia untuk rental lain
- **Business Rules**:
  - Hanya mobil "Tersedia" yang bisa dipilih
  - Biaya dihitung otomatis: (hari × tarif mobil) + (hari × tarif supir)

#### UC-018: Edit Transaksi
- **Aktor**: Admin Rental
- **Include**: UC-016
- **Main Flow**:
  1. Admin pilih transaksi yang akan diedit
  2. Admin ubah data transaksi
  3. Sistem recalculate biaya jika perlu
  4. Sistem update database
- **Business Rules**:
  - Transaksi yang sudah selesai tidak bisa diedit

#### UC-019: Selesaikan Transaksi
- **Aktor**: Admin Rental, Customer (indirect)
- **Include**: UC-016
- **Deskripsi**: Admin menyelesaikan transaksi saat mobil dikembalikan
- **Main Flow**:
  1. Customer mengembalikan mobil
  2. Admin cari transaksi berdasarkan nama/plat
  3. Admin klik button "Selesai"
  4. Sistem update tanggal kembali (hari ini)
  5. Sistem recalculate total biaya final
  6. Sistem update status transaksi menjadi "Selesai"
  7. Sistem update status mobil menjadi "Tersedia"
  8. Sistem generate invoice PDF
- **Postcondition**:
  - Transaksi selesai
  - Mobil tersedia untuk rental berikutnya
  - Invoice siap dicetak

#### UC-020: Hapus Transaksi
- **Aktor**: Admin Rental
- **Include**: UC-016
- **Main Flow**:
  1. Admin pilih transaksi yang akan dihapus
  2. Sistem konfirmasi penghapusan
  3. Admin konfirmasi
  4. Sistem hapus transaksi
  5. Sistem kembalikan status mobil menjadi "Tersedia"

---

### 📊 **Laporan dan Pencarian**

#### UC-021: Lihat Laporan
- **Aktor**: Admin Rental
- **Deskripsi**: Admin melihat berbagai laporan bisnis
- **Main Flow**:
  1. Admin pilih menu "Laporan"
  2. Admin pilih jenis laporan
  3. Sistem generate dan tampilkan laporan
- **Jenis Laporan**:
  - Laporan transaksi per periode
  - Laporan pendapatan
  - Laporan mobil terpopuler
  - Laporan supir terbaik

#### UC-022: Cari Data
- **Aktor**: Admin Rental
- **Deskripsi**: Admin mencari data tertentu
- **Main Flow**:
  1. Admin input keyword pencarian
  2. Sistem cari di database
  3. Sistem tampilkan hasil pencarian
- **Scope**: Semua tabel (mobil, transaksi, supir, merk)

#### UC-023: Cetak Invoice
- **Aktor**: Admin Rental
- **Include**: UC-019
- **Deskripsi**: Admin mencetak invoice transaksi
- **Main Flow**:
  1. Admin pilih transaksi yang sudah selesai
  2. Admin klik "Cetak PDF"
  3. Sistem generate PDF invoice
  4. Sistem download/tampilkan PDF
- **Content Invoice**:
  - Data customer
  - Detail mobil dan supir
  - Periode sewa
  - Breakdown biaya
  - Total pembayaran

---

## 🔄 **Relationship Antar Use Cases**

### **Include Relationships**:
- UC-004, UC-005, UC-006 **include** UC-003
- UC-008, UC-009, UC-010, UC-011 **include** UC-007
- UC-013, UC-014, UC-015 **include** UC-012
- UC-017, UC-018, UC-019, UC-020 **include** UC-016
- UC-023 **include** UC-019

### **Extend Relationships**:
- UC-008 **extend** UC-003 (saat pilih merk)
- UC-017 **extend** UC-007 (saat pilih mobil)
- UC-017 **extend** UC-012 (saat pilih supir)

### **Generalization**:
- Semua UC-004 sampai UC-023 **generalize** dari UC-001 (harus login dulu)

---

## ⚖️ **Business Rules**

1. **Data Integrity**:
   - Merk tidak bisa dihapus jika ada mobil yang menggunakan
   - Mobil tidak bisa dihapus jika ada transaksi aktif
   - Supir bisa dihapus, transaksi menjadi "Lepas Kunci"

2. **Status Management**:
   - Mobil otomatis berubah status saat ada transaksi
   - Hanya mobil "Tersedia" yang bisa disewa
   - Status bisa diubah manual oleh admin

3. **Calculation Rules**:
   - Biaya = (Lama Hari × Tarif Mobil) + (Lama Hari × Tarif Supir)
   - Lama hari dihitung otomatis dari tanggal sewa dan kembali
   - Tarif supir = 0 jika "Lepas Kunci"

4. **Security Rules**:
   - Semua fitur hanya bisa diakses setelah login
   - Session timeout setelah periode tertentu
   - Data sensitif (password) di-encrypt

---

## 🎯 **Success Scenarios**

### **Skenario 1: Rental Mobil Lengkap**
1. Customer datang ingin sewa Toyota Avanza dengan supir
2. Admin login → UC-001
3. Admin buat transaksi baru → UC-017
4. Pilih Toyota Avanza (tersedia) → UC-007
5. Pilih Supir Bambang → UC-012
6. Set periode 3 hari
7. Sistem hitung: (3 × 350.000) + (3 × 100.000) = 1.350.000
8. Simpan transaksi, status Avanza berubah "Jalan"
9. Setelah 3 hari, customer kembali
10. Admin selesaikan transaksi → UC-019
11. Status Avanza kembali "Tersedia"
12. Cetak invoice → UC-023

### **Skenario 2: Manajemen Data Master**
1. Admin login → UC-001
2. Tambah merk baru "Mitsubishi" → UC-004
3. Tambah mobil "Xpander" merk Mitsubishi → UC-008
4. Tambah supir baru "Andi" → UC-013
5. Mobil dan supir siap untuk transaksi

### **Skenario 3: Laporan Bisnis**
1. Admin login → UC-001
2. Lihat laporan bulanan → UC-021
3. Cari transaksi customer tertentu → UC-022
4. Cetak laporan untuk owner → UC-023

---

## 🚫 **Exception Scenarios**

### **Error Handling**:
- Database connection error
- File upload gagal
- Validation error (data tidak lengkap)
- Constraint violation (hapus data yang masih digunakan)
- Session timeout
- Insufficient permission

### **Recovery Actions**:
- Tampilkan pesan error yang jelas
- Log error untuk debugging
- Redirect ke halaman yang aman
- Backup data sebelum operasi kritis
- Rollback transaction jika gagal

---

Dokumentasi use case ini memberikan panduan lengkap untuk development, testing, dan maintenance sistem rental mobil. 🚗✨