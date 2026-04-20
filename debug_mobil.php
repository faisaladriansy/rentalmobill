<?php
// Debug script untuk mengecek data mobil
// Jalankan file ini di browser untuk melihat data mobil yang ada

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbrentalmobil';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>🔍 Debug Data Mobil</h2>";
    echo "<hr>";
    
    // 1. Cek data merk
    echo "<h3>📋 Data Merk:</h3>";
    $stmt = $pdo->query("SELECT * FROM merk ORDER BY namamerk ASC");
    $merks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($merks) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Merk</th><th>Nama Merk</th></tr>";
        foreach($merks as $merk) {
            echo "<tr><td>{$merk['idmerk']}</td><td>{$merk['namamerk']}</td></tr>";
        }
        echo "</table>";
        echo "<p><strong>✅ Total Merk: " . count($merks) . "</strong></p>";
    } else {
        echo "<p><strong>❌ Tidak ada data merk!</strong></p>";
    }
    
    echo "<hr>";
    
    // 2. Cek data mobil
    echo "<h3>🚗 Data Mobil:</h3>";
    $stmt = $pdo->query("SELECT * FROM mobil ORDER BY idmobil DESC");
    $mobils = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($mobils) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Mobil</th><th>ID Merk</th><th>Type</th><th>Plat</th><th>Status</th><th>Date</th></tr>";
        foreach($mobils as $mobil) {
            echo "<tr>";
            echo "<td>{$mobil['idmobil']}</td>";
            echo "<td>{$mobil['idmerk']}</td>";
            echo "<td>{$mobil['type']}</td>";
            echo "<td>{$mobil['platnomer']}</td>";
            echo "<td>{$mobil['stmobil']}</td>";
            echo "<td>{$mobil['date']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p><strong>✅ Total Mobil: " . count($mobils) . "</strong></p>";
    } else {
        echo "<p><strong>❌ Tidak ada data mobil!</strong></p>";
    }
    
    echo "<hr>";
    
    // 3. Cek data mobil dengan JOIN merk (seperti di aplikasi)
    echo "<h3>🔗 Data Mobil dengan JOIN Merk:</h3>";
    $query = "SELECT mobil.*, merk.namamerk 
              FROM mobil 
              LEFT JOIN merk ON merk.idmerk = mobil.idmerk 
              ORDER BY merk.namamerk ASC, mobil.type ASC";
    
    $stmt = $pdo->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($results) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Mobil</th><th>Nama Merk</th><th>Type</th><th>Plat</th><th>Status</th><th>Tarif</th></tr>";
        foreach($results as $row) {
            echo "<tr>";
            echo "<td>{$row['idmobil']}</td>";
            echo "<td>" . ($row['namamerk'] ? $row['namamerk'] : '<em>NULL</em>') . "</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td>{$row['platnomer']}</td>";
            echo "<td>{$row['stmobil']}</td>";
            echo "<td>" . number_format($row['tarif']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p><strong>✅ Total Data dengan JOIN: " . count($results) . "</strong></p>";
    } else {
        echo "<p><strong>❌ Tidak ada data dengan JOIN!</strong></p>";
    }
    
    echo "<hr>";
    
    // 4. Cek mobil yang tersedia untuk transaksi
    echo "<h3>🟢 Mobil Tersedia (Status = 'bebas'):</h3>";
    $query = "SELECT mobil.idmobil, mobil.type, mobil.tarif, mobil.stmobil, merk.namamerk 
              FROM mobil 
              LEFT JOIN merk ON merk.idmerk = mobil.idmerk 
              WHERE mobil.stmobil = 'bebas' 
              ORDER BY merk.namamerk ASC, mobil.type ASC";
    
    $stmt = $pdo->query($query);
    $available = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($available) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Mobil</th><th>Merk</th><th>Type</th><th>Status</th><th>Tarif</th></tr>";
        foreach($available as $row) {
            echo "<tr>";
            echo "<td>{$row['idmobil']}</td>";
            echo "<td>" . ($row['namamerk'] ? $row['namamerk'] : '<em>NULL</em>') . "</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td style='color: green; font-weight: bold;'>{$row['stmobil']}</td>";
            echo "<td>" . number_format($row['tarif']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p><strong>✅ Mobil Tersedia: " . count($available) . "</strong></p>";
    } else {
        echo "<p><strong>⚠️ Tidak ada mobil yang tersedia!</strong></p>";
    }
    
    echo "<hr>";
    
    // 5. Cek mobil yang sedang jalan
    echo "<h3>🔴 Mobil Sedang Jalan (Status = 'jalan'):</h3>";
    $query = "SELECT mobil.idmobil, mobil.type, mobil.stmobil, merk.namamerk 
              FROM mobil 
              LEFT JOIN merk ON merk.idmerk = mobil.idmerk 
              WHERE mobil.stmobil = 'jalan' 
              ORDER BY merk.namamerk ASC, mobil.type ASC";
    
    $stmt = $pdo->query($query);
    $busy = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($busy) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID Mobil</th><th>Merk</th><th>Type</th><th>Status</th></tr>";
        foreach($busy as $row) {
            echo "<tr>";
            echo "<td>{$row['idmobil']}</td>";
            echo "<td>" . ($row['namamerk'] ? $row['namamerk'] : '<em>NULL</em>') . "</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td style='color: red; font-weight: bold;'>{$row['stmobil']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p><strong>🔴 Mobil Sedang Jalan: " . count($busy) . "</strong></p>";
    } else {
        echo "<p><strong>✅ Tidak ada mobil yang sedang jalan</strong></p>";
    }
    
    echo "<hr>";
    
    // 6. Summary
    echo "<h3>📊 Summary:</h3>";
    echo "<ul>";
    echo "<li><strong>Total Merk:</strong> " . count($merks) . "</li>";
    echo "<li><strong>Total Mobil:</strong> " . count($mobils) . "</li>";
    echo "<li><strong>Mobil Tersedia:</strong> " . count($available) . "</li>";
    echo "<li><strong>Mobil Sedang Jalan:</strong> " . count($busy) . "</li>";
    echo "</ul>";
    
    // 7. Rekomendasi
    echo "<h3>💡 Rekomendasi:</h3>";
    if(count($mobils) == 0) {
        echo "<p>❌ <strong>Tidak ada data mobil!</strong> Silakan tambah data mobil terlebih dahulu.</p>";
    } elseif(count($available) == 0) {
        echo "<p>⚠️ <strong>Semua mobil sedang jalan!</strong> Tidak ada mobil yang tersedia untuk disewa.</p>";
    } else {
        echo "<p>✅ <strong>Sistem berjalan normal.</strong> Ada " . count($available) . " mobil yang tersedia untuk disewa.</p>";
    }
    
} catch(PDOException $e) {
    echo "<h2>❌ Database Error:</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ul>";
    echo "<li>Pastikan database 'dbrentalmobil' sudah dibuat</li>";
    echo "<li>Pastikan XAMPP/WAMP sudah running</li>";
    echo "<li>Periksa konfigurasi database di application/config/database.php</li>";
    echo "</ul>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background: #f5f5f5;
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

hr {
    border: none;
    border-top: 2px solid #dc3545;
    margin: 20px 0;
}

ul {
    background: white;
    padding: 15px;
    border-left: 4px solid #dc3545;
}
</style>