# 🚀 Deployment Checklist - Manager Feature

## Pre-Deployment Verification

### ✅ Files Check
```
[ ] application/controllers/Manager.php - Created
[ ] application/models/managermodel.php - Created
[ ] application/views/manager/dashboard.php - Created
[ ] application/views/manager/monitoring.php - Created
[ ] application/views/manager/laporan.php - Created
[ ] application/views/manager/detail.php - Created
[ ] application/views/manager/statistik.php - Created
[ ] application/controllers/Site.php - Modified
[ ] application/controllers/Transaksi.php - Modified
[ ] application/controllers/Mobil.php - Modified
[ ] application/controllers/Merk.php - Modified
[ ] application/controllers/Supir.php - Modified
[ ] application/views/template/menu.php - Modified
[ ] application/views/template/navbar.php - Modified
[ ] setup_manager_user.php - Created
[ ] add_manager_user.sql - Created
```

---

## Step 1: Backup

### Database Backup
```bash
# Backup database
mysqldump -u root -p dbrentalmobil > backup_before_manager_$(date +%Y%m%d).sql
```

### Files Backup
```bash
# Backup entire project
tar -czf backup_rentalmobil_$(date +%Y%m%d).tar.gz /path/to/rentalmobil/
```

---

## Step 2: Upload Files

### Upload New Files
```
Upload to server:
- application/controllers/Manager.php
- application/models/managermodel.php
- application/views/manager/ (entire folder)
- setup_manager_user.php
- add_manager_user.sql
```

### Replace Modified Files
```
Replace on server:
- application/controllers/Site.php
- application/controllers/Transaksi.php
- application/controllers/Mobil.php
- application/controllers/Merk.php
- application/controllers/Supir.php
- application/views/template/menu.php
- application/views/template/navbar.php
```

---

## Step 3: Database Setup

### Option A: Web Setup (Recommended)
```
1. Open browser
2. Navigate to: http://yoursite.com/setup_manager_user.php
3. Click "Setup Manager User"
4. Verify success message
5. Delete setup_manager_user.php from server (security)
```

### Option B: Manual SQL
```sql
-- Connect to database
mysql -u root -p dbrentalmobil

-- Run SQL commands
ALTER TABLE `user` 
ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`;

INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager', NULL, 1);

-- Verify
SELECT * FROM user;
DESCRIBE user;
```

---

## Step 4: Verify Installation

### Check Files
```bash
# Check if files exist
ls -la application/controllers/Manager.php
ls -la application/models/managermodel.php
ls -la application/views/manager/
```

### Check Permissions
```bash
# Set proper permissions
chmod 644 application/controllers/Manager.php
chmod 644 application/models/managermodel.php
chmod 755 application/views/manager/
chmod 644 application/views/manager/*.php
```

---

## Step 5: Testing

### Test 1: Login as Manager
```
URL: http://yoursite.com/
Username: manager
Password: manager123

Expected: Redirect to /manager dashboard
```

### Test 2: Manager Dashboard
```
URL: http://yoursite.com/manager

Expected: 
- Statistics displayed
- No errors
- Purple theme visible
```

### Test 3: Monitoring
```
URL: http://yoursite.com/manager/monitoring

Expected:
- Tabs working
- Data displayed
- Auto-refresh countdown visible
```

### Test 4: Laporan
```
URL: http://yoursite.com/manager/laporan

Expected:
- Transactions listed
- Filter form visible
- Export button works
```

### Test 5: Statistik
```
URL: http://yoursite.com/manager/statistik

Expected:
- Statistics displayed
- Chart rendered
- No JavaScript errors
```

### Test 6: Access Control
```
Try accessing as Manager:
- http://yoursite.com/transaksi
- http://yoursite.com/mobil
- http://yoursite.com/merk
- http://yoursite.com/supir

Expected: Access denied, redirect to /manager
```

### Test 7: Login as Admin
```
URL: http://yoursite.com/
Username: admin
Password: admin

Expected: 
- Redirect to /transaksi
- Admin menu visible
- Can access all pages
```

---

## Step 6: Security Check

### Remove Setup Files
```bash
# Delete setup file after successful installation
rm setup_manager_user.php
rm add_manager_user.sql
```

### Check Error Reporting
```php
// In production, ensure error reporting is OFF
// In index.php
error_reporting(0);
ini_set('display_errors', 0);
```

### Verify Session Security
```php
// In application/config/config.php
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
```

---

## Step 7: Performance Check

### Check Page Load Times
```
Dashboard: Should load < 2 seconds
Monitoring: Should load < 2 seconds
Laporan: Should load < 3 seconds
Statistik: Should load < 3 seconds
```

### Check Database Queries
```sql
-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

-- Monitor slow queries
SHOW VARIABLES LIKE 'slow_query_log%';
```

### Check Memory Usage
```bash
# Monitor PHP memory
watch -n 1 'ps aux | grep php'
```

---

## Step 8: Documentation

### Update Admin Documentation
```
[ ] Add Manager credentials to admin docs
[ ] Document Manager features
[ ] Update user manual
[ ] Create training materials
```

### Create User Guide
```
[ ] How to login as Manager
[ ] How to use Dashboard
[ ] How to monitor cars
[ ] How to generate reports
[ ] How to export data
```

---

## Step 9: User Training

### Train Manager Users
```
[ ] Show login process
[ ] Demonstrate dashboard
[ ] Explain monitoring features
[ ] Show how to filter reports
[ ] Demonstrate export functionality
[ ] Explain statistics page
```

### Train Admin Users
```
[ ] Explain new role system
[ ] Show how to create Manager users
[ ] Demonstrate access control
[ ] Explain differences between roles
```

---

## Step 10: Monitoring

### Monitor for 24 Hours
```
[ ] Check error logs
[ ] Monitor user activity
[ ] Check database performance
[ ] Verify auto-refresh working
[ ] Check export functionality
```

### Error Log Locations
```
application/logs/log-YYYY-MM-DD.php
/var/log/apache2/error.log (Linux)
/var/log/nginx/error.log (Nginx)
```

---

## Rollback Plan

### If Issues Occur

#### Restore Database
```bash
mysql -u root -p dbrentalmobil < backup_before_manager_YYYYMMDD.sql
```

#### Restore Files
```bash
tar -xzf backup_rentalmobil_YYYYMMDD.tar.gz -C /path/to/restore/
```

#### Quick Fix
```sql
-- Remove role column if needed
ALTER TABLE `user` DROP COLUMN `role`;

-- Delete manager user
DELETE FROM `user` WHERE username = 'manager';
```

---

## Post-Deployment Checklist

### Immediate (Day 1)
```
[ ] All tests passed
[ ] No errors in logs
[ ] Manager can login
[ ] Admin can login
[ ] All features working
[ ] Performance acceptable
[ ] Security verified
```

### Short-term (Week 1)
```
[ ] User feedback collected
[ ] Performance monitored
[ ] No critical bugs
[ ] Documentation updated
[ ] Training completed
```

### Long-term (Month 1)
```
[ ] Feature adoption measured
[ ] Performance optimized
[ ] User satisfaction surveyed
[ ] Future enhancements planned
```

---

## Success Criteria

### Technical
- ✅ All files deployed correctly
- ✅ Database updated successfully
- ✅ No errors in logs
- ✅ All tests passed
- ✅ Performance acceptable

### Functional
- ✅ Manager can login
- ✅ Dashboard displays data
- ✅ Monitoring works
- ✅ Reports generate correctly
- ✅ Export works
- ✅ Access control enforced

### User Acceptance
- ✅ Manager users trained
- ✅ Admin users informed
- ✅ Documentation complete
- ✅ Support ready

---

## Contact Information

### Technical Support
```
Developer: [Your Name]
Email: [Your Email]
Phone: [Your Phone]
```

### Emergency Contacts
```
Database Admin: [Name/Contact]
Server Admin: [Name/Contact]
Project Manager: [Name/Contact]
```

---

## Sign-off

```
Deployed By: ________________
Date: ________________
Time: ________________

Verified By: ________________
Date: ________________
Time: ________________

Approved By: ________________
Date: ________________
Time: ________________
```

---

*Deployment Checklist v1.0*  
*Follow this checklist step-by-step for successful deployment*
