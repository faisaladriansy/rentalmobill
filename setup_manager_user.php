<?php
/**
 * Setup Manager User - Sistem Rental Mobil
 * Script untuk menambahkan user manager ke database
 * 
 * Jalankan file ini di browser: http://localhost/rentalmobil/setup_manager_user.php
 */

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbrentalmobil';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<html><head><title>Setup Manager User</title>";
    echo "<style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            margin: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 { 
            color: #2c3e50; 
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        h2 { 
            color: #34495e; 
            margin-top: 30px;
        }
        .success { 
            background: #d4edda; 
            border: 2px solid #28a745; 
            color: #155724; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 15px 0;
        }
        .error { 
            background: #f8d7da; 
            border: 2px solid #dc3545; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 15px 0;
        }
        .info { 
            background: #d1ecf1; 
            border: 2px solid #17a2b8; 
            color: #0c5460; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 15px 0;
        }
        .warning { 
            background: #fff3cd; 
            border: 2px solid #ffc107; 
            color: #856404; 
            padding: 15px; 
            border-radius: 8px; 
            margin: 15px 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0;
            background: white;
        }
        th { 
            background: #667eea; 
            color: white; 
            padding: 12px; 
            text-align: left;
        }
        td { 
            padding: 10px; 
            border-bottom: 1px solid #ddd;
        }
        tr:hover { 
            background: #f8f9fa;
        }
        .credential-box {
            background: #e8f5e8;
            border: 3px solid #28a745;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .credential-box h3 {
            margin: 0 0 15px 0;
            color: #155724;
        }
        .credential-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: white;
            margin: 5px 0;
            border-radius: 5px;
        }
        .credential-label {
            font-weight: bold;
            color: #495057;
        }
        .credential-value {
            font-family: 'Courier New', monospace;
            color: #28a745;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #5a67d8;
        }
    </style></head><body>";
    
    echo "<div class='container'>";
    echo "<h1>🔧 Setup Manager User</h1>";
    echo "<p>Script untuk menambahkan user Manager ke sistem rental mobil</p>";
    
    $steps_completed = 0;
    $total_steps = 4;
    
    // Step 1: Check if 'role' column exists
    echo "<h2>Step 1: Cek Kolom 'role' di Tabel User</h2>";
    
    $stmt = $pdo->query("SHOW COLUMNS FROM `user` LIKE 'role'");
    $role_exists = $stmt->rowCount() > 0;
    
    if (!$role_exists) {
        echo "<div class='warning'>⚠️ Kolom 'role' belum ada. Menambahkan kolom...</div>";
        
        try {
            $pdo->exec("ALTER TABLE `user` ADD COLUMN `role` ENUM('admin', 'manager') DEFAULT 'admin' AFTER `password`");
            echo "<div class='success'>✅ Kolom 'role' berhasil ditambahkan!</div>";
            $steps_completed++;
        } catch (PDOException $e) {
            echo "<div class='error'>❌ Error menambahkan kolom: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='success'>✅ Kolom 'role' sudah ada</div>";
        $steps_completed++;
    }
    
    // Step 2: Update existing admin user
    echo "<h2>Step 2: Update User Admin yang Ada</h2>";
    
    try {
        $stmt = $pdo->prepare("UPDATE `user` SET `role` = 'admin' WHERE `username` = 'admin'");
        $stmt->execute();
        echo "<div class='success'>✅ User admin berhasil diupdate dengan role 'admin'</div>";
        $steps_completed++;
    } catch (PDOException $e) {
        echo "<div class='error'>❌ Error update admin: " . $e->getMessage() . "</div>";
    }
    
    // Step 3: Check if manager user already exists
    echo "<h2>Step 3: Cek User Manager</h2>";
    
    $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `username` = 'manager'");
    $stmt->execute();
    $manager_exists = $stmt->rowCount() > 0;
    
    if ($manager_exists) {
        echo "<div class='warning'>⚠️ User 'manager' sudah ada. Mengupdate password...</div>";
        
        try {
            $stmt = $pdo->prepare("UPDATE `user` SET `password` = MD5('manager123'), `role` = 'manager', `stuser` = 1 WHERE `username` = 'manager'");
            $stmt->execute();
            echo "<div class='success'>✅ User manager berhasil diupdate!</div>";
            $steps_completed++;
        } catch (PDOException $e) {
            echo "<div class='error'>❌ Error update manager: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='info'>ℹ️ User 'manager' belum ada. Menambahkan user baru...</div>";
        
        try {
            $stmt = $pdo->prepare("INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) VALUES ('manager', MD5('manager123'), 'manager', NULL, 1)");
            $stmt->execute();
            echo "<div class='success'>✅ User manager berhasil ditambahkan!</div>";
            $steps_completed++;
        } catch (PDOException $e) {
            echo "<div class='error'>❌ Error menambahkan manager: " . $e->getMessage() . "</div>";
        }
    }
    
    // Step 4: Verify and display all users
    echo "<h2>Step 4: Verifikasi Data User</h2>";
    
    // Check if role column exists before selecting it
    $stmt_check = $pdo->query("SHOW COLUMNS FROM `user` LIKE 'role'");
    $has_role = $stmt_check->rowCount() > 0;
    
    if($has_role) {
        $stmt = $pdo->query("SELECT `iduser`, `username`, `role`, `lastlogin`, `stuser` FROM `user` ORDER BY `iduser`");
    } else {
        $stmt = $pdo->query("SELECT `iduser`, `username`, 'admin' as `role`, `lastlogin`, `stuser` FROM `user` ORDER BY `iduser`");
    }
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "<div class='success'>✅ Data user berhasil diverifikasi</div>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Last Login</th><th>Status</th></tr>";
        
        foreach ($users as $user) {
            $status = $user['stuser'] == 1 ? '<span style="color: green;">✅ Aktif</span>' : '<span style="color: red;">❌ Nonaktif</span>';
            $role_badge = $user['role'] == 'admin' ? '<span style="background: #3498db; color: white; padding: 3px 8px; border-radius: 3px;">Admin</span>' : '<span style="background: #9c27b0; color: white; padding: 3px 8px; border-radius: 3px;">Manager</span>';
            
            echo "<tr>";
            echo "<td>{$user['iduser']}</td>";
            echo "<td><strong>{$user['username']}</strong></td>";
            echo "<td>{$role_badge}</td>";
            echo "<td>" . ($user['lastlogin'] ? $user['lastlogin'] : '-') . "</td>";
            echo "<td>{$status}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        $steps_completed++;
    } else {
        echo "<div class='error'>❌ Tidak ada data user ditemukan!</div>";
    }
    
    // Summary
    echo "<h2>📊 Summary</h2>";
    echo "<div class='info'>";
    echo "<strong>Progress:</strong> {$steps_completed}/{$total_steps} steps completed<br>";
    
    if ($steps_completed == $total_steps) {
        echo "<strong>Status:</strong> <span style='color: green; font-weight: bold;'>✅ SETUP BERHASIL!</span>";
    } else {
        echo "<strong>Status:</strong> <span style='color: orange; font-weight: bold;'>⚠️ SETUP TIDAK LENGKAP</span>";
    }
    echo "</div>";
    
    // Display credentials
    if ($steps_completed == $total_steps) {
        echo "<div class='credential-box'>";
        echo "<h3>🔐 Kredensial Login Manager</h3>";
        
        echo "<div class='credential-item'>";
        echo "<span class='credential-label'>Username:</span>";
        echo "<span class='credential-value'>manager</span>";
        echo "</div>";
        
        echo "<div class='credential-item'>";
        echo "<span class='credential-label'>Password:</span>";
        echo "<span class='credential-value'>manager123</span>";
        echo "</div>";
        
        echo "<div class='credential-item'>";
        echo "<span class='credential-label'>Role:</span>";
        echo "<span class='credential-value'>manager (read-only)</span>";
        echo "</div>";
        
        echo "<div class='credential-item'>";
        echo "<span class='credential-label'>Access Level:</span>";
        echo "<span class='credential-value'>Monitoring & Reporting Only</span>";
        echo "</div>";
        
        echo "</div>";
        
        echo "<div class='info'>";
        echo "<h4>📋 Hak Akses Manager:</h4>";
        echo "<ul>";
        echo "<li>✅ Lihat Laporan Transaksi</li>";
        echo "<li>✅ Pantau Keluar Masuk Mobil</li>";
        echo "<li>✅ Dashboard Statistik</li>";
        echo "<li>✅ Export Data Laporan</li>";
        echo "<li>❌ Tidak bisa tambah/edit/hapus data</li>";
        echo "</ul>";
        echo "</div>";
    }
    
    // Additional users section
    echo "<h2>➕ Tambah User Manager Lainnya (Optional)</h2>";
    echo "<div class='info'>";
    echo "<p>Jika ingin menambahkan user manager lainnya, jalankan query berikut di phpMyAdmin:</p>";
    echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
    echo "INSERT INTO `user` (`username`, `password`, `role`, `lastlogin`, `stuser`) \n";
    echo "VALUES ('manager2', MD5('password123'), 'manager', NULL, 1);";
    echo "</pre>";
    echo "<p><strong>Note:</strong> Ganti 'manager2' dan 'password123' sesuai kebutuhan</p>";
    echo "</div>";
    
    // Next steps
    echo "<h2>🚀 Langkah Selanjutnya</h2>";
    echo "<div class='warning'>";
    echo "<ol>";
    echo "<li><strong>Login ke sistem</strong> menggunakan kredensial manager di atas</li>";
    echo "<li><strong>Verifikasi akses</strong> - pastikan hanya bisa melihat data (read-only)</li>";
    echo "<li><strong>Test fitur monitoring</strong> - cek laporan dan dashboard</li>";
    echo "<li><strong>Ganti password</strong> setelah login pertama kali (recommended)</li>";
    echo "<li><strong>Hapus file ini</strong> setelah setup selesai untuk keamanan</li>";
    echo "</ol>";
    echo "</div>";
    
    // Links
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='index.php' class='btn'>🏠 Ke Halaman Login</a>";
    echo "<a href='Manager_Role_Documentation.md' class='btn'>📖 Dokumentasi Manager</a>";
    echo "</div>";
    
    echo "</div>"; // container
    echo "</body></html>";
    
} catch (PDOException $e) {
    echo "<div style='background: #f8d7da; border: 2px solid #dc3545; color: #721c24; padding: 20px; margin: 20px; border-radius: 10px;'>";
    echo "<h2>❌ Database Connection Error</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<h3>Solusi:</h3>";
    echo "<ul>";
    echo "<li>Pastikan XAMPP/WAMP sudah running</li>";
    echo "<li>Pastikan database 'dbrentalmobil' sudah dibuat</li>";
    echo "<li>Periksa konfigurasi database di file ini (host, username, password)</li>";
    echo "<li>Import file database/dbrentalmobil.sql terlebih dahulu</li>";
    echo "</ul>";
    echo "</div>";
}
?>