# Skenario Use Case - Kelola Transaksi Rental Mobil

## Use Case 1: Tambah Transaksi Rental

### Informasi Dasar
- **Nama Use Case:** Tambah Transaksi Rental
- **Aktor:** Admin
- **Deskripsi:** Admin menambahkan transaksi rental mobil baru untuk pelanggan
- **Tujuan:** Mencatat transaksi penyewaan mobil dengan data pelanggan, mobil, supir, dan periode sewa

### Kondisi Awal (Precondition)
- Admin sudah login ke sistem
- Terdapat minimal satu mobil dengan status tersedia
- Terdapat data supir di sistem (opsional untuk lepas kunci)

### Kondisi Akhir (Postcondition)
- Data transaksi tersimpan di database
- Status mobil berubah menjadi "sedang disewa"
- Transaksi muncul di daftar transaksi dengan status "aktif"

### Alur Normal (Basic Flow)

1. Admin membuka halaman Data Transaksi
2. Sistem menampilkan daftar transaksi yang ada
3. Admin mengklik tombol "Tambah Transaksi"
4. Sistem menampilkan form transaksi kosong dengan:
   - Dropdown mobil yang tersedia (status tersedia)
   - Dropdown supir (opsional)
   - Field input data pelanggan
   - Field tanggal sewa dan tanggal kembali
5. Admin mengisi data pelanggan:
   - Nama pelanggan
   - Nomor KTP
   - Nomor HP
   - Alamat
6. Admin memilih tanggal sewa
7. Admin memilih tanggal kembali
8. Admin memilih mobil dari dropdown
9. Admin memilih supir dari dropdown (opsional, bisa dikosongkan untuk lepas kunci)
10. Sistem menghitung jumlah hari sewa
11. Sistem menghitung total biaya berdasarkan tarif mobil dan supir
12. Admin mengklik tombol "Simpan"
13. Sistem menyimpan data transaksi dengan status "aktif"
14. Sistem mengubah status mobil menjadi "sedang disewa"
15. Sistem menampilkan pesan "Transaksi berhasil disimpan"
16. Sistem mengarahkan ke halaman Data Transaksi
17. Transaksi baru muncul di daftar

### Alur Alternatif (Alternative Flow)

**A1: Data tidak lengkap**
- Pada langkah 12, jika ada field wajib yang kosong:
  - Sistem menampilkan pesan error "Mohon lengkapi semua data"
  - Sistem tetap di halaman form
  - Admin melengkapi data yang kurang
  - Kembali ke langkah 12

**A2: Tanggal tidak valid**
- Pada langkah 7, jika tanggal kembali lebih awal dari tanggal sewa:
  - Sistem menampilkan pesan error "Tanggal kembali harus setelah tanggal sewa"
  - Admin memperbaiki tanggal
  - Kembali ke langkah 7

**A3: Tidak ada mobil tersedia**
- Pada langkah 4, jika tidak ada mobil dengan status tersedia:
  - Sistem menampilkan pesan "Tidak ada mobil tersedia saat ini"
  - Admin tidak dapat melanjutkan transaksi
  - Use case berakhir

**A4: Admin membatalkan transaksi**
- Pada langkah 5-11, Admin dapat mengklik tombol "Batal":
  - Sistem kembali ke halaman Data Transaksi
  - Data yang diisi tidak disimpan
  - Use case berakhir

---

## Use Case 2: Lihat Data Transaksi

### Informasi Dasar
- **Nama Use Case:** Lihat Data Transaksi
- **Aktor:** Admin
- **Deskripsi:** Admin melihat daftar semua transaksi rental
- **Tujuan:** Menampilkan informasi transaksi untuk monitoring

### Kondisi Awal (Precondition)
- Admin sudah login ke sistem

### Kondisi Akhir (Postcondition)
- Daftar transaksi ditampilkan di layar

### Alur Normal (Basic Flow)

1. Admin membuka halaman Data Transaksi
2. Sistem mengambil semua data transaksi dari database
3. Sistem menampilkan tabel transaksi dengan kolom:
   - Nama Pelanggan
   - Nomor KTP
   - Nomor HP
   - Alamat
   - Tanggal Sewa
   - Tanggal Kembali
   - Jumlah Hari
   - Mobil (nama dan plat)
   - Supir (nama, atau "Lepas Kunci")
   - Total Biaya
   - Status (Aktif/Selesai)
   - Aksi (tombol Edit, Hapus, Selesai)
4. Admin dapat melihat detail setiap transaksi

### Alur Alternatif (Alternative Flow)

**A1: Tidak ada data transaksi**
- Pada langkah 2, jika belum ada transaksi:
  - Sistem menampilkan pesan "Belum ada data transaksi"
  - Sistem menampilkan tombol "Tambah Transaksi"

---

## Use Case 3: Edit Transaksi

### Informasi Dasar
- **Nama Use Case:** Edit Transaksi
- **Aktor:** Admin
- **Deskripsi:** Admin mengubah data transaksi yang sudah ada
- **Tujuan:** Memperbaiki atau memperbarui informasi transaksi

### Kondisi Awal (Precondition)
- Admin sudah login ke sistem
- Terdapat minimal satu transaksi di database
- Transaksi yang akan diedit berstatus "aktif"

### Kondisi Akhir (Postcondition)
- Data transaksi berhasil diperbarui
- Perubahan tersimpan di database

### Alur Normal (Basic Flow)

1. Admin membuka halaman Data Transaksi
2. Sistem menampilkan daftar transaksi
3. Admin mengklik tombol "Edit" pada transaksi yang dipilih
4. Sistem menampilkan form edit terisi dengan data transaksi lama
5. Admin mengubah data yang diperlukan:
   - Data pelanggan
   - Tanggal sewa/kembali
   - Mobil
   - Supir
6. Sistem menghitung ulang jumlah hari dan total biaya
7. Admin mengklik tombol "Simpan"
8. Sistem memperbarui data transaksi di database
9. Sistem menampilkan pesan "Transaksi berhasil diperbarui"
10. Sistem mengarahkan ke halaman Data Transaksi
11. Data transaksi yang diubah muncul dengan informasi terbaru

### Alur Alternatif (Alternative Flow)

**A1: Admin membatalkan edit**
- Pada langkah 5-6, Admin mengklik tombol "Batal":
  - Sistem kembali ke halaman Data Transaksi
  - Perubahan tidak disimpan
  - Use case berakhir

**A2: Data tidak valid**
- Pada langkah 7, jika data tidak valid:
  - Sistem menampilkan pesan error
  - Admin memperbaiki data
  - Kembali ke langkah 7

**A3: Transaksi sudah selesai**
- Pada langkah 3, jika transaksi berstatus "selesai":
  - Tombol "Edit" tidak ditampilkan atau dinonaktifkan
  - Admin tidak dapat mengedit transaksi
  - Use case berakhir

---

## Use Case 4: Selesaikan Transaksi

### Informasi Dasar
- **Nama Use Case:** Selesaikan Transaksi
- **Aktor:** Admin
- **Deskripsi:** Admin menyelesaikan transaksi rental yang sudah selesai
- **Tujuan:** Mengubah status transaksi menjadi selesai dan mengembalikan status mobil

### Kondisi Awal (Precondition)
- Admin sudah login ke sistem
- Terdapat transaksi dengan status "aktif"
- Pelanggan sudah mengembalikan mobil

### Kondisi Akhir (Postcondition)
- Status transaksi berubah menjadi "selesai"
- Status mobil berubah menjadi "tersedia"
- Mobil dapat disewa kembali oleh pelanggan lain

### Alur Normal (Basic Flow)

1. Admin membuka halaman Data Transaksi
2. Sistem menampilkan daftar transaksi
3. Admin mencari transaksi yang akan diselesaikan (status "aktif")
4. Admin mengklik tombol "Selesai" pada transaksi tersebut
5. Sistem menampilkan dialog konfirmasi "Apakah Anda yakin ingin menyelesaikan transaksi ini?"
6. Admin mengklik tombol "Ya"
7. Sistem mengubah status transaksi menjadi "selesai"
8. Sistem mengubah status mobil menjadi "tersedia"
9. Sistem menampilkan pesan "Transaksi berhasil diselesaikan"
10. Sistem memperbarui tampilan daftar transaksi
11. Tombol "Selesai" pada transaksi tersebut hilang
12. Mobil muncul kembali di daftar mobil tersedia

### Alur Alternatif (Alternative Flow)

**A1: Admin membatalkan penyelesaian**
- Pada langkah 6, Admin mengklik tombol "Tidak" atau "Batal":
  - Dialog konfirmasi ditutup
  - Status transaksi tetap "aktif"
  - Status mobil tetap "sedang disewa"
  - Use case berakhir

**A2: Transaksi sudah selesai**
- Pada langkah 3, jika transaksi sudah berstatus "selesai":
  - Tombol "Selesai" tidak ditampilkan
  - Admin tidak dapat menyelesaikan transaksi lagi
  - Use case berakhir

---

## Use Case 5: Hapus Transaksi

### Informasi Dasar
- **Nama Use Case:** Hapus Transaksi
- **Aktor:** Admin
- **Deskripsi:** Admin menghapus data transaksi dari sistem
- **Tujuan:** Menghapus transaksi yang salah atau tidak valid

### Kondisi Awal (Precondition)
- Admin sudah login ke sistem
- Terdapat minimal satu transaksi di database

### Kondisi Akhir (Postcondition)
- Data transaksi terhapus dari database
- Jika transaksi berstatus "aktif", status mobil dikembalikan menjadi "tersedia"

### Alur Normal (Basic Flow)

1. Admin membuka halaman Data Transaksi
2. Sistem menampilkan daftar transaksi
3. Admin mengklik tombol "Hapus" pada transaksi yang dipilih
4. Sistem menampilkan dialog konfirmasi "Apakah Anda yakin ingin menghapus transaksi ini?"
5. Admin mengklik tombol "Ya"
6. Sistem memeriksa status transaksi
7. Jika transaksi berstatus "aktif", sistem mengubah status mobil menjadi "tersedia"
8. Sistem menghapus data transaksi dari database
9. Sistem menampilkan pesan "Transaksi berhasil dihapus"
10. Sistem memperbarui tampilan daftar transaksi
11. Transaksi yang dihapus tidak muncul lagi di daftar

### Alur Alternatif (Alternative Flow)

**A1: Admin membatalkan penghapusan**
- Pada langkah 5, Admin mengklik tombol "Tidak" atau "Batal":
  - Dialog konfirmasi ditutup
  - Data transaksi tidak dihapus
  - Use case berakhir

---

## Ringkasan Use Case Transaksi

| No | Use Case | Aktor | Tujuan |
|----|----------|-------|--------|
| 1 | Tambah Transaksi Rental | Admin | Mencatat penyewaan mobil baru |
| 2 | Lihat Data Transaksi | Admin | Melihat daftar semua transaksi |
| 3 | Edit Transaksi | Admin | Mengubah data transaksi |
| 4 | Selesaikan Transaksi | Admin | Menyelesaikan rental dan mengembalikan mobil |
| 5 | Hapus Transaksi | Admin | Menghapus transaksi yang tidak valid |

---

## Catatan Penting

1. **Status Transaksi:**
   - "Aktif" = Transaksi sedang berjalan, mobil sedang disewa
   - "Selesai" = Transaksi sudah selesai, mobil sudah dikembalikan

2. **Status Mobil:**
   - "Tersedia" = Mobil dapat disewa
   - "Sedang disewa" = Mobil sedang dirental, tidak dapat disewa

3. **Relasi dengan Entitas Lain:**
   - Setiap transaksi harus memiliki satu mobil
   - Setiap transaksi dapat memiliki satu supir (opsional)
   - Mobil yang sedang disewa tidak dapat dipilih untuk transaksi baru

4. **Perhitungan Biaya:**
   - Total = (Tarif Mobil + Tarif Supir) × Jumlah Hari
   - Jika lepas kunci (tanpa supir), Tarif Supir = 0
