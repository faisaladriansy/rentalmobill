<?php
// Script untuk menambahkan data mobil sample
// Jalankan file ini sekali untuk menambahkan 25+ data mobil

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dbrentalmobil';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Menambahkan Data Mobil Sample...</h2>";

// Data mobil sample dengan query INSERT langsung
$queries = [
    // Toyota (idmerk = 1)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 1, 'Innova', 2021, 'H 1101 BB', 8, 400000, 60000, 'INN001', 'innova.jpg', 'jalan')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 1, 'Fortuner', 2022, 'H 1102 CC', 7, 500000, 70000, 'FOR001', 'fortuner.jpg', 'bebas')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 1, 'Camry', 2021, 'H 1103 DD', 5, 600000, 80000, 'CAM001', 'camry.jpg', 'bebas')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 1, 'Vios', 2020, 'H 1104 EE', 5, 300000, 50000, 'VIO001', 'vios.jpg', 'jalan')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 1, 'Yaris', 2021, 'H 1105 FF', 5, 320000, 50000, 'YAR001', 'yaris.jpg', 'bebas')",
    
    // Honda (idmerk = 2)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'Jazz', 2021, 'H 2101 HH', 5, 350000, 50000, 'JAZ001', 'jazz.jpg', 'bebas')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'City', 2022, 'H 2102 II', 5, 400000, 60000, 'CIT001', 'city.jpg', 'jalan')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'Civic', 2021, 'H 2103 JJ', 5, 450000, 70000, 'CIV001', 'civic.jpg', 'bebas')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'CR-V', 2022, 'H 2104 KK', 7, 550000, 80000, 'CRV001', 'crv.jpg', 'jalan')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'HR-V', 2021, 'H 2105 LL', 5, 450000, 70000, 'HRV001', 'hrv.jpg', 'bebas')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 2, 'Accord', 2020, 'H 2106 MM', 5, 650000, 90000, 'ACC001', 'accord.jpg', 'bebas')",
    
    // Daihatsu (idmerk = 3)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 3, 'Ayla', 2020, 'H 3101 NN', 5, 250000, 40000, 'AYL001', 'ayla.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 3, 'Xenia', 2021, 'H 3102 OO', 8, 350000, 50000, 'XEN001', 'xenia.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 3, 'Terios', 2022, 'H 3103 PP', 7, 400000, 60000, 'TER001', 'terios.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 3, 'Sigra', 2020, 'H 3104 QQ', 7, 300000, 50000, 'SIG001', 'sigra.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 3, 'Gran Max', 2021, 'H 3105 RR', 8, 320000, 50000, 'GRM001', 'granmax.jpg', 'tersedia')",
    
    // Suzuki (idmerk = 5)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 5, 'Ertiga', 2021, 'H 5101 SS', 7, 350000, 50000, 'ERT001', 'ertiga.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 5, 'Swift', 2020, 'H 5102 UU', 5, 320000, 50000, 'SWI001', 'swift.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 5, 'Baleno', 2021, 'H 5103 VV', 5, 340000, 50000, 'BAL001', 'baleno.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 5, 'Jimny', 2022, 'H 5104 WW', 4, 450000, 70000, 'JIM001', 'jimny.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 5, 'Ignis', 2020, 'H 5105 XX', 5, 300000, 50000, 'IGN001', 'ignis.jpg', 'tersedia')",
    
    // Nissan (idmerk = 4)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 4, 'March', 2020, 'H 4101 YY', 5, 300000, 50000, 'MAR001', 'march.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 4, 'Livina', 2021, 'H 4102 ZZ', 7, 350000, 50000, 'LIV001', 'livina.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 4, 'X-Trail', 2022, 'H 4103 AA', 7, 500000, 70000, 'XTR001', 'xtrail.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 4, 'Serena', 2021, 'H 4104 BB', 8, 450000, 60000, 'SER001', 'serena.jpg', 'tersedia')",
    
    // Mitsubishi (idmerk = 7)
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 7, 'Pajero', 2022, 'H 7101 CC', 7, 600000, 80000, 'PAJ001', 'pajero.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 7, 'Outlander', 2021, 'H 7102 DD', 7, 550000, 70000, 'OUT001', 'outlander.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 7, 'Xpander', 2022, 'H 7103 EE', 7, 380000, 60000, 'XPA001', 'xpander.jpg', 'tersedia')",
    "INSERT INTO mobil (date, idmerk, type, tahunproduksi, platnomer, kursi, tarif, lembur, norangka, foto, stmobil) VALUES (NOW(), 7, 'Mirage', 2020, 'H 7104 FF', 5, 280000, 45000, 'MIR001', 'mirage.jpg', 'tersedia')"
];

$success_count = 0;
$error_count = 0;

foreach ($queries as $index => $sql) {
    if ($conn->query($sql) === TRUE) {
        $success_count++;
        echo "✓ Berhasil menambahkan mobil #" . ($index + 1) . "<br>";
    } else {
        $error_count++;
        echo "✗ Gagal menambahkan mobil #" . ($index + 1) . " - Error: " . $conn->error . "<br>";
    }
}

echo "<br><h3>RINGKASAN:</h3>";
echo "<strong>Berhasil:</strong> $success_count mobil<br>";
echo "<strong>Gagal:</strong> $error_count mobil<br>";
echo "<strong>Total:</strong> " . ($success_count + $error_count) . " mobil<br>";

// Cek total data di database
$result = $conn->query("SELECT COUNT(*) as total FROM mobil");
$row = $result->fetch_assoc();
echo "<strong>Total data mobil di database:</strong> " . $row['total'] . " mobil<br>";

$conn->close();

echo "<br><div style='background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0;'>";
echo "<strong>✓ SELESAI!</strong><br>";
echo "Silakan buka <a href='mobil' style='color: #155724; font-weight: bold;'>Data Mobil</a> untuk melihat hasilnya.";
echo "</div>";

echo "<br><small><em>Catatan: Anda bisa menghapus file ini setelah selesai untuk keamanan.</em></small>";
?>