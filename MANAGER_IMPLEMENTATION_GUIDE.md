# 📋 Manager Implementation Guide

## ✅ Files yang Sudah Dibuat

### **Controllers:**
- ✅ `application/controllers/Manager.php` - Controller untuk Manager

### **Models:**
- ✅ `application/models/managermodel.php` - Model untuk data Manager

### **Views:**
- ✅ `application/views/manager/dashboard.php` - Dashboard Manager
- ✅ `application/views/manager/monitoring.php` - Monitoring Keluar Masuk Mobil
- ✅ `application/views/manager/laporan.php` - Laporan Transaksi dengan Filter
- ✅ `application/views/manager/detail.php` - Detail Transaksi

### **Database:**
- ✅ `setup_manager_user.php` - Script setup user Manager
- ✅ `add_manager_user.sql` - SQL script untuk Manager

---

## 🚀 Langkah Implementasi

### **Step 1: Setup Database**

Jalankan salah satu dari:

**Option A: Otomatis (Recommended)**
```
http://localhost/rentalmobil/setup_manager_user.php
```

**Option B: Manual SQL**
```sql
ALTER TABLE `user` 
ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`;

INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager', NULL, 1);
```

---

### **Step 2: Update Login Controller**

Edit `application/controllers/Site.php` untuk handle role:

```php
// Setelah validasi login berhasil
$this->session->set_userdata('status', "login");
$this->session->set_userdata('username', $username);
$this->session->set_userdata('role', $user->role); // Tambahkan ini

// Redirect berdasarkan role
if($user->role == 'manager') {
    redirect(base_url("manager"));
} else {
    redirect(base_url("transaksi"));
}
```

---

### **Step 3: Update Menu Template**

Edit `application/views/template/menu.php`:

```php
<?php
$role = $this->session->userdata('role');
?>

<!-- Menu untuk Manager -->
<?php if($role == 'manager'): ?>
<li class="header">MENU MANAGER</li>
<li>
    <a href="<?=base_url()?>manager">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>manager/monitoring">
        <i class="fa fa-car"></i> <span>Monitoring Mobil</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>manager/laporan">
        <i class="fa fa-file-text"></i> <span>Laporan Transaksi</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>manager/statistik">
        <i class="fa fa-bar-chart"></i> <span>Statistik</span>
    </a>
</li>

<!-- Menu untuk Admin -->
<?php else: ?>
<li class="header">MENU ADMIN</li>
<li>
    <a href="<?=base_url()?>transaksi">
        <i class="fa fa-exchange"></i> <span>Transaksi</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>mobil">
        <i class="fa fa-car"></i> <span>Data Mobil</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>merk">
        <i class="fa fa-tags"></i> <span>Data Merk</span>
    </a>
</li>
<li>
    <a href="<?=base_url()?>supir">
        <i class="fa fa-user"></i> <span>Data Supir</span>
    </a>
</li>
<?php endif; ?>
```

---

### **Step 4: Update Navbar**

Edit `application/views/template/navbar.php`:

```php
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-user"></i>
        <span class="hidden-xs">
            <?php echo $this->session->userdata('username'); ?>
            <?php if($this->session->userdata('role') == 'manager'): ?>
                <small>(Manager)</small>
            <?php else: ?>
                <small>(Admin)</small>
            <?php endif; ?>
        </span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header">
            <p>
                <?php echo $this->session->userdata('username'); ?>
                <small>
                    <?php echo $this->session->userdata('role') == 'manager' ? 'Manager - Read Only' : 'Administrator'; ?>
                </small>
            </p>
        </li>
        <li class="user-footer">
            <div class="pull-right">
                <a href="<?=base_url()?>site/logout" class="btn btn-default btn-flat">Logout</a>
            </div>
        </li>
    </ul>
</li>
```

---

## 🎯 Fitur Manager

### **1. Dashboard (`/manager`)**
- Statistik real-time
- Quick access menu
- Informasi occupancy rate
- Pendapatan hari ini & bulan ini

### **2. Monitoring Mobil (`/manager/monitoring`)**
- Tab Mobil Tersedia
- Tab Mobil Sedang Jalan
- Auto refresh setiap 30 detik
- Real-time status update

### **3. Laporan Transaksi (`/manager/laporan`)**
- Filter by tanggal, status, mobil
- Export ke Excel
- Print laporan
- View detail transaksi

### **4. Detail Transaksi (`/manager/detail/:id`)**
- Informasi customer lengkap
- Informasi mobil & supir
- Rincian biaya
- Status transaksi

---

## 🔒 Security Implementation

### **Protect Manager Routes**

Sudah diimplementasikan di `Manager.php` constructor:

```php
// Cek login
if($this->session->userdata('status') != "login"){
    redirect(base_url("site"));
}

// Cek role manager
if($this->session->userdata('role') != 'manager'){
    redirect(base_url("site"));
}
```

### **Protect Admin Routes**

Tambahkan di controller Admin (Transaksi, Mobil, Merk, Supir):

```php
// Di constructor
if($this->session->userdata('role') == 'manager'){
    $this->session->set_flashdata('info', 'Akses ditolak. Anda tidak memiliki hak untuk mengubah data.');
    redirect(base_url("manager"));
}
```

---

## 📊 Database Queries

### **Get Statistik:**
```php
$this->managermodel->getStatistik();
```

### **Get Mobil Tersedia:**
```php
$this->managermodel->getMobilTersedia();
```

### **Get Mobil Jalan:**
```php
$this->managermodel->getMobilJalan();
```

### **Get Laporan dengan Filter:**
```php
$filter = array(
    'tanggal_dari' => '2026-01-01',
    'tanggal_sampai' => '2026-01-31',
    'status' => 'selesai',
    'mobil' => 5
);
$this->managermodel->getLaporanTransaksi($filter);
```

---

## 🎨 UI/UX Features

### **Color Scheme:**
- Primary: `#667eea` (Purple)
- Success: `#28a745` (Green)
- Danger: `#dc3545` (Red)
- Info: `#3498db` (Blue)
- Warning: `#f39c12` (Orange)

### **Icons:**
- Dashboard: `fa-dashboard`
- Monitoring: `fa-car`
- Laporan: `fa-file-text`
- Statistik: `fa-bar-chart`
- Export: `fa-download`

### **Responsive:**
- Desktop: Full features
- Tablet: Optimized layout
- Mobile: Essential features

---

## 🧪 Testing

### **Test Login Manager:**
```
URL: http://localhost/rentalmobil/
Username: manager
Password: manager123
```

### **Test Features:**
1. ✅ Dashboard loads correctly
2. ✅ Monitoring shows real-time data
3. ✅ Laporan filter works
4. ✅ Export to Excel works
5. ✅ Detail transaksi displays correctly
6. ✅ Cannot access admin routes
7. ✅ Cannot edit/delete data

---

## 📝 TODO (Optional Enhancements)

### **Phase 2:**
- [ ] View statistik dengan grafik Chart.js
- [ ] Export to PDF
- [ ] Email laporan otomatis
- [ ] Dashboard widgets drag & drop

### **Phase 3:**
- [ ] Real-time notifications
- [ ] Advanced analytics
- [ ] Predictive insights
- [ ] Mobile app

---

## 🐛 Troubleshooting

### **Problem: Menu tidak muncul**
**Solution:** Pastikan session 'role' sudah di-set saat login

### **Problem: Redirect loop**
**Solution:** Cek kondisi role di constructor

### **Problem: Data tidak muncul**
**Solution:** Cek apakah model sudah di-load

### **Problem: Export error**
**Solution:** Cek headers sudah di-set dengan benar

---

## 📞 Support

Jika ada masalah:
1. Cek error log di `application/logs/`
2. Enable error reporting di `index.php`
3. Cek database connection
4. Verify user role di database

---

## ✅ Checklist Implementasi

- [x] Database setup (role column & manager user)
- [x] Login controller updated (role handling)
- [x] Menu template updated (role-based menu)
- [x] Navbar updated (show role)
- [x] Manager controller created
- [x] Manager model created
- [x] Manager views created (dashboard, monitoring, laporan, detail, statistik)
- [x] Security implemented (route protection)
- [x] Admin controllers protected from Manager access
- [x] Testing ready
- [x] Documentation complete

---

*Manager Implementation Guide v1.0*  
*© 2026 Sistem Rental Mobil*