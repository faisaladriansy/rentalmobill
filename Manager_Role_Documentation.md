# 👔 Manager Role - Sistem Rental Mobil

## 📋 Overview

Manager adalah user dengan akses khusus untuk **monitoring dan reporting** dalam sistem rental mobil. Manager memiliki **read-only access** untuk memantau operasional bisnis tanpa dapat mengubah data.

---

## 🎯 Tanggung Jawab Manager

### 1. **Monitoring Keluar Masuk Mobil** 🚗
- Memantau status mobil (tersedia/jalan)
- Melihat mobil yang sedang disewa
- Tracking mobil yang sudah kembali
- Monitoring real-time availability

### 2. **Memantau Data Transaksi** 📊
- Melihat semua transaksi rental
- Tracking transaksi aktif
- Monitoring transaksi yang sudah selesai
- Analisis pola rental

### 3. **Laporan dan Statistik** 📈
- Dashboard statistik bisnis
- Laporan pendapatan
- Laporan mobil terpopuler
- Laporan supir terbaik
- Trend analysis

---

## 🔐 Hak Akses Manager

### ✅ **Yang BISA Dilakukan:**

| Fitur | Akses | Deskripsi |
|-------|-------|-----------|
| **Login** | ✅ Full | Masuk ke sistem dengan kredensial manager |
| **Lihat Laporan Transaksi** | ✅ Read | Melihat semua data transaksi |
| **Pantau Keluar Masuk Mobil** | ✅ Read | Monitoring status mobil real-time |
| **Dashboard Statistik** | ✅ Read | Melihat grafik dan statistik bisnis |
| **Export Data Laporan** | ✅ Export | Download laporan dalam format Excel/PDF |
| **Filter Laporan by Periode** | ✅ Read | Filter data berdasarkan tanggal |
| **Lihat Detail Transaksi** | ✅ Read | Melihat detail lengkap transaksi |

### ❌ **Yang TIDAK BISA Dilakukan:**

| Fitur | Akses | Alasan |
|-------|-------|--------|
| **Tambah/Edit/Hapus Transaksi** | ❌ No | Hanya admin yang bisa mengubah data |
| **Kelola Data Mobil** | ❌ No | Data master dikelola admin |
| **Kelola Data Merk** | ❌ No | Data master dikelola admin |
| **Kelola Data Supir** | ❌ No | Data master dikelola admin |
| **Update Status Mobil** | ❌ No | Status diupdate otomatis oleh sistem |
| **Cetak Invoice** | ❌ No | Invoice dicetak oleh admin |

---

## 📊 Use Cases untuk Manager

### UC-M01: Login Sistem
**Aktor:** Manager  
**Deskripsi:** Manager masuk ke sistem dengan kredensial khusus  
**Precondition:** Manager memiliki akun dengan role "manager"  
**Main Flow:**
1. Manager buka halaman login
2. Manager input username dan password
3. Sistem validasi kredensial
4. Sistem cek role = "manager"
5. Sistem redirect ke dashboard manager
6. Tampilkan menu monitoring dan laporan

**Postcondition:** Manager berhasil login dan melihat dashboard

---

### UC-M02: Lihat Laporan Transaksi
**Aktor:** Manager  
**Include:** UC-M01 (Login)  
**Deskripsi:** Manager melihat laporan semua transaksi rental  
**Main Flow:**
1. Manager klik menu "Laporan Transaksi"
2. Sistem tampilkan daftar transaksi
3. Manager dapat filter by:
   - Tanggal (dari - sampai)
   - Status (mulai/selesai)
   - Mobil
   - Customer
4. Sistem tampilkan hasil filter
5. Manager dapat lihat detail transaksi

**Business Rules:**
- Data ditampilkan read-only
- Tidak ada tombol edit/hapus
- Sorting dan filtering tersedia

---

### UC-M03: Pantau Keluar Masuk Mobil
**Aktor:** Manager  
**Include:** UC-M01 (Login)  
**Deskripsi:** Manager memantau status mobil secara real-time  
**Main Flow:**
1. Manager klik menu "Monitoring Mobil"
2. Sistem tampilkan dashboard monitoring:
   - Total mobil tersedia
   - Total mobil sedang jalan
   - List mobil dengan status
   - Estimasi tanggal kembali
3. Manager dapat filter by merk/type
4. Sistem update status real-time

**Display Information:**
- Mobil ID & Type
- Status (Tersedia/Jalan)
- Customer (jika sedang jalan)
- Tanggal sewa
- Estimasi tanggal kembali
- Lama sewa (hari)

---

### UC-M04: Lihat Dashboard Statistik
**Aktor:** Manager  
**Include:** UC-M01 (Login)  
**Deskripsi:** Manager melihat statistik bisnis dalam bentuk grafik  
**Main Flow:**
1. Manager klik menu "Dashboard"
2. Sistem tampilkan statistik:
   - Total transaksi hari ini
   - Total pendapatan bulan ini
   - Grafik trend rental
   - Mobil terpopuler
   - Supir terbaik
   - Occupancy rate
3. Manager dapat pilih periode
4. Sistem update grafik sesuai periode

**Metrics Displayed:**
- Revenue (daily/monthly/yearly)
- Transaction count
- Car utilization rate
- Popular car models
- Peak rental periods
- Customer satisfaction (if available)

---

### UC-M05: Export Data Laporan
**Aktor:** Manager  
**Extend:** UC-M02 (Lihat Laporan)  
**Deskripsi:** Manager export laporan ke file  
**Main Flow:**
1. Manager lihat laporan transaksi
2. Manager klik "Export"
3. Manager pilih format:
   - Excel (.xlsx)
   - PDF
   - CSV
4. Manager pilih data yang akan diexport
5. Sistem generate file
6. Sistem download file

**Export Options:**
- All data atau filtered data
- Include/exclude columns
- Date range selection
- Format customization

---

### UC-M06: Filter Laporan by Periode
**Aktor:** Manager  
**Include:** UC-M02 (Lihat Laporan)  
**Deskripsi:** Manager filter laporan berdasarkan periode waktu  
**Main Flow:**
1. Manager di halaman laporan
2. Manager pilih filter periode:
   - Hari ini
   - Minggu ini
   - Bulan ini
   - Custom range
3. Manager set tanggal mulai dan akhir
4. Manager klik "Filter"
5. Sistem tampilkan data sesuai periode

**Filter Options:**
- Quick filters (today, this week, this month)
- Custom date range
- Comparison with previous period
- Year-over-year comparison

---

### UC-M07: Lihat Detail Transaksi
**Aktor:** Manager  
**Include:** UC-M02 (Lihat Laporan)  
**Deskripsi:** Manager melihat detail lengkap transaksi  
**Main Flow:**
1. Manager di halaman laporan
2. Manager klik transaksi tertentu
3. Sistem tampilkan detail:
   - Data customer
   - Data mobil
   - Data supir (jika ada)
   - Tanggal sewa & kembali
   - Lama sewa
   - Biaya detail
   - Status pembayaran
   - History perubahan
4. Manager dapat print detail

**Detail Information:**
- Customer: Nama, KTP, HP, Alamat
- Mobil: Merk, Type, Plat, Tarif
- Supir: Nama, Tarif (atau "Lepas Kunci")
- Periode: Tanggal sewa, tanggal kembali, lama hari
- Biaya: Tarif mobil, tarif supir, total
- Status: Mulai/Selesai
- Timestamps: Created, updated

---

## 🗄️ Database Schema untuk Manager

### Tabel: `user`
```sql
ALTER TABLE user ADD COLUMN role ENUM('admin', 'manager') DEFAULT 'admin';

-- Sample manager user
INSERT INTO user (username, password, role, stuser) 
VALUES ('manager', MD5('manager123'), 'manager', 1);
```

### Permissions Table (Optional)
```sql
CREATE TABLE user_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(20) NOT NULL,
    module VARCHAR(50) NOT NULL,
    can_read BOOLEAN DEFAULT FALSE,
    can_create BOOLEAN DEFAULT FALSE,
    can_update BOOLEAN DEFAULT FALSE,
    can_delete BOOLEAN DEFAULT FALSE,
    can_export BOOLEAN DEFAULT FALSE
);

-- Manager permissions
INSERT INTO user_permissions (role, module, can_read, can_export) VALUES
('manager', 'transaksi', TRUE, TRUE),
('manager', 'mobil', TRUE, FALSE),
('manager', 'laporan', TRUE, TRUE),
('manager', 'dashboard', TRUE, TRUE);
```

---

## 🎨 UI/UX untuk Manager

### Dashboard Manager
```
┌─────────────────────────────────────────────────────┐
│  🏠 Dashboard Manager                    👤 Manager  │
├─────────────────────────────────────────────────────┤
│                                                       │
│  📊 Statistik Hari Ini                               │
│  ┌──────────┬──────────┬──────────┬──────────┐     │
│  │ Transaksi│  Mobil   │  Mobil   │ Pendapatan│     │
│  │   Aktif  │ Tersedia │  Jalan   │ Hari Ini  │     │
│  │    5     │    12    │    8     │ 2.500.000 │     │
│  └──────────┴──────────┴──────────┴──────────┘     │
│                                                       │
│  📈 Grafik Trend Rental (30 Hari)                   │
│  [=============== CHART ===============]             │
│                                                       │
│  🚗 Status Mobil Real-Time                           │
│  ┌─────────────────────────────────────────┐        │
│  │ Toyota Avanza (H 1234 AB)  🟢 Tersedia  │        │
│  │ Honda Brio (H 5678 CD)     🔴 Jalan     │        │
│  │ Suzuki Ertiga (H 9012 EF)  🟢 Tersedia  │        │
│  └─────────────────────────────────────────┘        │
│                                                       │
└─────────────────────────────────────────────────────┘
```

### Menu Manager
```
📊 Dashboard
📋 Laporan Transaksi
🚗 Monitoring Mobil
📈 Statistik & Analisis
📥 Export Data
🚪 Logout
```

---

## 🔒 Security & Access Control

### Authentication Check
```php
// Check if user is manager
if($this->session->userdata('role') != 'manager') {
    redirect('site/login');
}
```

### Read-Only Enforcement
```php
// Disable edit/delete buttons for manager
if($this->session->userdata('role') == 'manager') {
    // Show only view/export buttons
    // Hide add/edit/delete buttons
}
```

### Menu Filtering
```php
// Show different menu based on role
if($this->session->userdata('role') == 'manager') {
    // Show: Dashboard, Laporan, Monitoring, Export
    // Hide: Kelola Data, Tambah/Edit/Hapus
}
```

---

## 📱 Responsive Design

Manager dashboard harus responsive untuk:
- 💻 Desktop (full features)
- 📱 Tablet (optimized layout)
- 📱 Mobile (essential features only)

---

## 🎯 Key Performance Indicators (KPIs)

Manager dapat memantau:

1. **Operational KPIs:**
   - Car utilization rate
   - Average rental duration
   - On-time return rate

2. **Financial KPIs:**
   - Daily/Monthly revenue
   - Revenue per car
   - Revenue growth rate

3. **Customer KPIs:**
   - Number of transactions
   - Repeat customer rate
   - Customer satisfaction

---

## 🚀 Implementation Priority

### Phase 1: Basic Monitoring
- ✅ Login dengan role manager
- ✅ View laporan transaksi (read-only)
- ✅ View status mobil

### Phase 2: Advanced Features
- ✅ Dashboard dengan statistik
- ✅ Filter dan search
- ✅ Export to Excel/PDF

### Phase 3: Analytics
- ✅ Grafik dan charts
- ✅ Trend analysis
- ✅ Predictive insights

---

## 📞 Support & Maintenance

**Manager Role Benefits:**
- ✅ Separation of concerns (monitoring vs operations)
- ✅ Better security (read-only access)
- ✅ Audit trail (who viewed what)
- ✅ Business intelligence
- ✅ Decision making support

**Best Practices:**
- Regular password changes
- Session timeout for security
- Activity logging
- Data backup before export
- Performance optimization for large datasets

---

*Manager role documentation untuk Sistem Rental Mobil v1.0*  
*© 2026 - Read-Only Monitoring & Reporting Access*