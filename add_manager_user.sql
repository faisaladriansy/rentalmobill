-- ============================================
-- Script untuk Menambahkan User Manager
-- Sistem Rental Mobil
-- ============================================

-- 1. Tambah kolom 'role' ke tabel user (jika belum ada)
ALTER TABLE `user` 
ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`;

-- 2. Update user admin yang sudah ada
UPDATE `user` SET `role` = 'admin' WHERE `username` = 'admin';

-- 3. Tambahkan user Manager baru
INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
VALUES ('manager', '1d0258c2440a8d19e716292b231e3190', 'manager', NULL, 1);

-- Password: manager123 (MD5 hash)
-- Username: manager

-- 4. Verifikasi data yang ditambahkan
SELECT * FROM `user`;

-- ============================================
-- Informasi Login Manager:
-- Username: manager
-- Password: manager123
-- Role: manager (read-only access)
-- ============================================

-- 5. Optional: Tambah user manager lainnya
-- INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) 
-- VALUES ('manager2', MD5('password123'), 'manager', NULL, 1);

-- ============================================
-- Catatan:
-- - Password disimpan dalam format MD5
-- - Role 'manager' memiliki akses read-only
-- - Role 'admin' memiliki full access
-- - stuser = 1 (aktif), 0 (nonaktif)
-- ============================================