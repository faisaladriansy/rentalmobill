<?php
// Script untuk memperbaiki masalah data mobil
// Jalankan file ini untuk memastikan data mobil berfungsi dengan baik

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbrentalmobil';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔧 Fix Data Mobil</h2>";
    echo "<hr>";
    
    $fixes_applied = 0;
    
    // 1. Pastikan ada data merk
    echo "<h3>1. Cek Data Merk</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM merk");
    $merk_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if($merk_count == 0) {
        echo "<p>❌ Tidak ada data merk. Menambahkan data merk...</p>";
        
        $merks = [
            ['Toyota', 'toyota'],
            ['Honda', 'honda'],
            ['Daihatsu', 'daihatsu'],
            ['Nissan', 'nissan'],
            ['Suzuki', 'suzuki'],
            ['Mitsubishi', 'mitsubishi']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO merk (namamerk, namamerk_seo) VALUES (?, ?)");
        foreach($merks as $merk) {
            $stmt->execute($merk);
        }
        
        echo "<p>✅ Data merk berhasil ditambahkan!</p>";
        $fixes_applied++;
    } else {
        echo "<p>✅ Data merk sudah ada ($merk_count merk)</p>";
    }
    
    // 2. Pastikan ada data mobil
    echo "<h3>2. Cek Data Mobil</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM mobil");
    $mobil_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if($mobil_count < 5) {
        echo "<p>⚠️ Data mobil kurang ($mobil_count mobil). Menambahkan data mobil...</p>";
        
        // Get merk IDs
        $stmt = $pdo->query("SELECT idmerk, namamerk FROM merk ORDER BY namamerk");
        $merks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sample_cars = [
            ['Toyota', 'Avanza', 2020, 'H 1491 VZ', 8, 350000, 50000, 'HWEAS5165665651', 'avanza.jpg'],
            ['Honda', 'BRIO', 2023, 'H 1596 LO', 4, 300000, 50000, 'HWEAS5165665651', 'brio1.png'],
            ['Suzuki', 'XL 7', 2023, 'H 1395 AO', 6, 350000, 50000, 'DIJDFG523165898969', 'xl7-beta-hybrid-batam.png'],
            ['Daihatsu', 'Ayla', 2021, 'H 1234 AB', 5, 280000, 50000, 'AYLA123456789', 'ayla1.jpg'],
            ['Toyota', 'Innova', 2022, 'H 5678 CD', 8, 400000, 50000, 'INNOVA987654321', 'mobil.jpg'],
            ['Honda', 'Jazz', 2021, 'H 9012 EF', 5, 320000, 50000, 'JAZZ456789123', 'mobil.jpg'],
            ['Suzuki', 'Ertiga', 2022, 'H 3456 GH', 7, 330000, 50000, 'ERTIGA789123456', 'mobil.jpg'],
            ['Daihatsu', 'Xenia', 2020, 'H 7890 IJ', 8, 340000, 50000, 'XENIA123789456', 'xenia1.png']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, 'bebas')");
        
        foreach($sample_cars as $car) {
            // Find merk ID
            $merk_id = null;
            foreach($merks as $merk) {
                if($merk['namamerk'] == $car[0]) {
                    $merk_id = $merk['idmerk'];
                    break;
                }
            }
            
            if($merk_id) {
                $stmt->execute([
                    $merk_id,      // idmerk
                    $car[1],       // type
                    $car[2],       // tahunproduksi
                    $car[3],       // platnomer
                    $car[4],       // kursi
                    $car[5],       // tarif
                    $car[6],       // lembur
                    $car[7],       // norangka
                    $car[8]        // foto
                ]);
                echo "<p>✅ Menambahkan: {$car[0]} {$car[1]} ({$car[3]})</p>";
            }
        }
        
        echo "<p>✅ Data mobil berhasil ditambahkan!</p>";
        $fixes_applied++;
    } else {
        echo "<p>✅ Data mobil sudah cukup ($mobil_count mobil)</p>";
    }
    
    // 3. Fix foreign key relationships
    echo "<h3>3. Perbaiki Relasi Foreign Key</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM mobil WHERE idmerk IS NULL OR idmerk = 0");
    $null_merk = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if($null_merk > 0) {
        echo "<p>⚠️ Ada $null_merk mobil tanpa merk. Memperbaiki...</p>";
        
        // Set default merk (Toyota) untuk mobil yang tidak punya merk
        $stmt = $pdo->query("SELECT idmerk FROM merk WHERE namamerk = 'Toyota' LIMIT 1");
        $toyota_id = $stmt->fetch(PDO::FETCH_ASSOC)['idmerk'];
        
        $stmt = $pdo->prepare("UPDATE mobil SET idmerk = ? WHERE idmerk IS NULL OR idmerk = 0");
        $stmt->execute([$toyota_id]);
        
        echo "<p>✅ Relasi foreign key diperbaiki!</p>";
        $fixes_applied++;
    } else {
        echo "<p>✅ Semua mobil sudah memiliki merk</p>";
    }
    
    // 4. Pastikan status mobil valid
    echo "<h3>4. Perbaiki Status Mobil</h3>";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM mobil WHERE stmobil NOT IN ('bebas', 'jalan')");
    $invalid_status = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    if($invalid_status > 0) {
        echo "<p>⚠️ Ada $invalid_status mobil dengan status tidak valid. Memperbaiki...</p>";
        
        $stmt = $pdo->prepare("UPDATE mobil SET stmobil = 'bebas' WHERE stmobil NOT IN ('bebas', 'jalan')");
        $stmt->execute();
        
        echo "<p>✅ Status mobil diperbaiki!</p>";
        $fixes_applied++;
    } else {
        echo "<p>✅ Semua status mobil sudah valid</p>";
    }
    
    // 5. Test query yang digunakan aplikasi
    echo "<h3>5. Test Query Aplikasi</h3>";
    $query = "SELECT mobil.*, merk.namamerk 
              FROM mobil 
              LEFT JOIN merk ON merk.idmerk = mobil.idmerk 
              ORDER BY merk.namamerk ASC, mobil.type ASC";
    
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>✅ Query berhasil dijalankan. Ditemukan " . count($results) . " mobil</p>";
    
    if(count($results) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Merk</th><th>Type</th><th>Plat</th><th>Status</th><th>Tarif</th></tr>";
        foreach(array_slice($results, 0, 5) as $row) { // Show first 5 only
            echo "<tr>";
            echo "<td>{$row['idmobil']}</td>";
            echo "<td>{$row['namamerk']}</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td>{$row['platnomer']}</td>";
            echo "<td style='color: " . ($row['stmobil'] == 'bebas' ? 'green' : 'red') . ";'>{$row['stmobil']}</td>";
            echo "<td>Rp " . number_format($row['tarif']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        if(count($results) > 5) {
            echo "<p><em>... dan " . (count($results) - 5) . " mobil lainnya</em></p>";
        }
    }
    
    // 6. Test query untuk dropdown transaksi
    echo "<h3>6. Test Query Dropdown Transaksi</h3>";
    $query = "SELECT mobil.idmobil, mobil.type, mobil.tarif, mobil.stmobil, merk.namamerk 
              FROM mobil 
              LEFT JOIN merk ON merk.idmerk = mobil.idmerk 
              WHERE mobil.stmobil = 'bebas' 
              ORDER BY merk.namamerk ASC, mobil.type ASC";
    
    $stmt = $pdo->query($query);
    $available = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>✅ Ditemukan " . count($available) . " mobil tersedia untuk transaksi</p>";
    
    if(count($available) > 0) {
        echo "<ul>";
        foreach($available as $car) {
            echo "<li><strong>{$car['namamerk']} {$car['type']}</strong> - Rp " . number_format($car['tarif']) . " (Status: {$car['stmobil']})</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>⚠️ <strong>Tidak ada mobil yang tersedia!</strong> Semua mobil sedang jalan.</p>";
        
        // Set beberapa mobil menjadi tersedia
        echo "<p>Mengatur beberapa mobil menjadi tersedia...</p>";
        $stmt = $pdo->prepare("UPDATE mobil SET stmobil = 'bebas' WHERE idmobil IN (SELECT * FROM (SELECT idmobil FROM mobil ORDER BY idmobil LIMIT 3) as temp)");
        $stmt->execute();
        echo "<p>✅ 3 mobil pertama diatur menjadi tersedia</p>";
        $fixes_applied++;
    }
    
    echo "<hr>";
    
    // Summary
    echo "<h3>📊 Summary Perbaikan</h3>";
    if($fixes_applied > 0) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; color: #155724;'>";
        echo "<h4>✅ Perbaikan Berhasil!</h4>";
        echo "<p><strong>$fixes_applied</strong> perbaikan telah diterapkan.</p>";
        echo "<p>Silakan coba akses halaman Data Mobil di aplikasi untuk memastikan semuanya berfungsi dengan baik.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 5px; color: #0c5460;'>";
        echo "<h4>ℹ️ Tidak Ada Masalah</h4>";
        echo "<p>Semua data mobil sudah dalam kondisi baik. Tidak ada perbaikan yang diperlukan.</p>";
        echo "</div>";
    }
    
    echo "<h3>🔗 Langkah Selanjutnya</h3>";
    echo "<ol>";
    echo "<li>Buka aplikasi rental mobil di browser</li>";
    echo "<li>Login sebagai admin</li>";
    echo "<li>Klik menu 'Data Mobil' untuk melihat daftar mobil</li>";
    echo "<li>Klik menu 'Transaksi' untuk membuat transaksi baru</li>";
    echo "<li>Pastikan dropdown 'Pilih Mobil' menampilkan mobil yang tersedia</li>";
    echo "</ol>";
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; color: #721c24;'>";
    echo "<h3>❌ Database Error</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ul>";
    echo "<li>Pastikan XAMPP/WAMP sudah running</li>";
    echo "<li>Pastikan database 'dbrentalmobil' sudah dibuat</li>";
    echo "<li>Import file database/dbrentalmobil.sql terlebih dahulu</li>";
    echo "<li>Periksa konfigurasi database di application/config/database.php</li>";
    echo "</ul>";
    echo "</div>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #f5f5f5;
    line-height: 1.6;
}

table {
    background: white;
    border-collapse: collapse;
    margin: 10px 0;
    width: 100%;
    max-width: 800px;
}

th {
    background: #dc3545;
    color: white;
    padding: 10px;
    text-align: left;
}

td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

tr:nth-child(even) {
    background: #f9f9f9;
}

h2, h3 {
    color: #333;
}

h2 {
    background: #dc3545;
    color: white;
    padding: 15px;
    border-radius: 5px;
    margin: 0 0 20px 0;
}

hr {
    border: none;
    border-top: 2px solid #dc3545;
    margin: 20px 0;
}

ul, ol {
    background: white;
    padding: 15px;
    border-left: 4px solid #dc3545;
    margin: 10px 0;
}

li {
    margin: 5px 0;
}

p {
    margin: 10px 0;
}
</style>