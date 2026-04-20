# 🚀 Manager Quick Reference Card

## 🔑 Login Credentials

```
Manager:
  Username: manager
  Password: manager123

Admin:
  Username: admin
  Password: admin
```

---

## 🌐 URLs

```
Setup Database:
  http://localhost/rentalmobil/setup_manager_user.php

Login:
  http://localhost/rentalmobil/

Manager Dashboard:
  http://localhost/rentalmobil/manager

Monitoring:
  http://localhost/rentalmobil/manager/monitoring

Laporan:
  http://localhost/rentalmobil/manager/laporan

Statistik:
  http://localhost/rentalmobil/manager/statistik
```

---

## 📁 Key Files

### Controllers
```
application/controllers/Manager.php
application/controllers/Site.php (modified)
```

### Models
```
application/models/managermodel.php
```

### Views
```
application/views/manager/dashboard.php
application/views/manager/monitoring.php
application/views/manager/laporan.php
application/views/manager/detail.php
application/views/manager/statistik.php
```

### Templates
```
application/views/template/menu.php (modified)
application/views/template/navbar.php (modified)
```

---

## 🎯 Manager Features

### Dashboard
- Real-time statistics
- Occupancy rate
- Quick access menu

### Monitoring
- Mobil tersedia
- Mobil sedang jalan
- Auto-refresh 30s

### Laporan
- Filter by date, status, car
- Export to Excel
- Print functionality
- View detail

### Statistik
- Total statistics
- 6 months chart
- Top 10 cars
- Average metrics

---

## 🔐 Access Control

### Manager CAN:
✅ View dashboard
✅ Monitor cars
✅ View reports
✅ Export data
✅ View statistics

### Manager CANNOT:
❌ Add/Edit/Delete transactions
❌ Add/Edit/Delete cars
❌ Add/Edit/Delete brands
❌ Add/Edit/Delete drivers

---

## 🛠️ Quick Setup

### 1. Database
```sql
ALTER TABLE `user` ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin';
INSERT INTO `user` VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager', NULL, 1);
```

### 2. Test Login
```
1. Go to: http://localhost/rentalmobil/
2. Login: manager / manager123
3. Should redirect to: /manager
```

### 3. Verify Features
```
✓ Dashboard shows statistics
✓ Monitoring shows cars
✓ Laporan shows transactions
✓ Export works
✓ Cannot access admin pages
```

---

## 🎨 Theme Colors

```css
Primary: #667eea
Secondary: #764ba2
Gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%)
```

---

## 📊 Database Query Examples

### Get Statistics
```php
$this->managermodel->getStatistik();
```

### Get Available Cars
```php
$this->managermodel->getMobilTersedia();
```

### Get Reports with Filter
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

## 🐛 Troubleshooting

### Issue: Menu not showing
```
Check: Session 'role' is set in Site.php login method
```

### Issue: Cannot access Manager pages
```
Check: Database has role column and manager user
```

### Issue: Export not working
```
Check: No output before header() in export method
```

### Issue: Chart not displaying
```
Check: Chart.js loaded in statistik.php
```

---

## ✅ Testing Checklist

```
[ ] Login as Manager works
[ ] Dashboard displays correctly
[ ] Monitoring shows cars
[ ] Auto-refresh works (30s)
[ ] Laporan shows transactions
[ ] Filter works
[ ] Export Excel works
[ ] Print works
[ ] Detail view works
[ ] Statistik displays
[ ] Chart displays
[ ] Cannot access admin pages
[ ] Menu shows Manager items only
[ ] Navbar shows role
[ ] Logout works
```

---

## 📞 Quick Commands

### Enable Error Reporting
```php
// In index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Check Session
```php
// In any controller
echo '<pre>';
print_r($this->session->userdata());
echo '</pre>';
```

### Check Database
```sql
-- Check user table
SELECT * FROM user;

-- Check role column exists
DESCRIBE user;
```

---

## 🎯 Success Indicators

✅ Manager can login  
✅ Dashboard shows data  
✅ Monitoring auto-refreshes  
✅ Export downloads file  
✅ Admin pages blocked  
✅ Role displayed in navbar  
✅ Menu shows correct items  

---

*Quick Reference v1.0 - Keep this handy!*
