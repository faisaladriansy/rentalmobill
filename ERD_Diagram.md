# Entity Relationship Diagram (ERD)
## Sistem Rental Mobil

```
┌─────────────────┐         ┌─────────────────┐         ┌─────────────────┐
│      MERK       │         │      MOBIL      │         │    TRANSAKSI    │
├─────────────────┤         ├─────────────────┤         ├─────────────────┤
│ idmerk (PK)     │◄────────┤ idmobil (PK)    │◄────────┤ idtransaksi(PK) │
│ namamerk        │   1:M   │ date            │   1:M   │ date            │
│ namamerk_seo    │         │ idmerk (FK)     │         │ namapelanggan   │
└─────────────────┘         │ type            │         │ noktp           │
                            │ tahunproduksi   │         │ nohp            │
                            │ platnomer       │         │ alamat          │
                            │ kursi           │         │ tglsewa         │
                            │ tarif           │         │ tglkembali      │
                            │ lembur          │         │ selisih         │
                            │ norangka        │         │ idmobil (FK)    │
                            │ foto            │         │ idsupir (FK)    │
                            │ update          │         │ total           │
                            │ stmobil         │         │ sttransaksi     │
                            └─────────────────┘         └─────────────────┘
                                                                 ▲
                                                                 │
                                                                 │ M:1
                                                                 │
                            ┌─────────────────┐                 │
                            │      SUPIR      │─────────────────┘
                            ├─────────────────┤
                            │ idsupir (PK)    │
                            │ date            │
                            │ namasupir       │
                            │ tgllahir        │
                            │ alamat          │
                            │ noktp           │
                            │ foto            │
                            │ tarif           │
                            │ lembur          │
                            └─────────────────┘

┌─────────────────┐
│      USER       │  (Independent Table)
├─────────────────┤
│ iduser (PK)     │
│ username        │
│ password        │
│ lastlogin       │
│ stuser          │
└─────────────────┘
```

## Penjelasan Relasi:

### 1. **MERK → MOBIL** (One-to-Many)
- **Kardinalitas**: 1:M
- **Relasi**: `merk.idmerk` → `mobil.idmerk`
- **Penjelasan**: Satu merk dapat memiliki banyak mobil
- **Contoh**: Toyota memiliki Avanza, Innova, Fortuner, dll

### 2. **MOBIL → TRANSAKSI** (One-to-Many)
- **Kardinalitas**: 1:M
- **Relasi**: `mobil.idmobil` → `transaksi.idmobil`
- **Penjelasan**: Satu mobil dapat memiliki banyak transaksi (history rental)
- **Contoh**: Avanza H1234AB pernah disewa berkali-kali

### 3. **SUPIR → TRANSAKSI** (One-to-Many, Optional)
- **Kardinalitas**: 1:M (Optional)
- **Relasi**: `supir.idsupir` → `transaksi.idsupir`
- **Penjelasan**: Satu supir dapat melayani banyak transaksi, bisa NULL untuk lepas kunci
- **Contoh**: Supir Bambang melayani beberapa customer

### 4. **USER** (Independent)
- **Kardinalitas**: Independent
- **Penjelasan**: Tabel untuk autentikasi admin, tidak berelasi dengan tabel lain

## Business Rules:

### Constraint Rules:
1. **RESTRICT**: Mobil tidak bisa dihapus jika masih ada transaksi
2. **RESTRICT**: Merk tidak bisa dihapus jika masih ada mobil  
3. **SET NULL**: Supir bisa dihapus, transaksi menjadi "Lepas Kunci"
4. **CASCADE**: Update ID akan ter-propagasi ke tabel terkait

### Status Rules:
1. **Mobil Status**: 'bebas' (tersedia) atau 'jalan' (sedang disewa)
2. **Transaksi Status**: 'mulai' atau 'selesai'
3. **Auto Update**: Status mobil otomatis berubah berdasarkan transaksi

## Query Patterns:

### Typical Joins:
```sql
-- Mobil dengan Merk
SELECT m.*, mk.namamerk 
FROM mobil m 
LEFT JOIN merk mk ON m.idmerk = mk.idmerk;

-- Transaksi Lengkap
SELECT t.*, mk.namamerk, m.type, s.namasupir
FROM transaksi t
LEFT JOIN mobil m ON t.idmobil = m.idmobil
LEFT JOIN merk mk ON m.idmerk = mk.idmerk  
LEFT JOIN supir s ON t.idsupir = s.idsupir;
```

## Data Integrity:

### Primary Keys:
- `merk.idmerk` (AUTO_INCREMENT)
- `mobil.idmobil` (AUTO_INCREMENT)
- `transaksi.idtransaksi` (AUTO_INCREMENT)
- `supir.idsupir` (AUTO_INCREMENT)
- `user.iduser` (AUTO_INCREMENT)

### Foreign Keys:
- `mobil.idmerk` → `merk.idmerk`
- `transaksi.idmobil` → `mobil.idmobil`
- `transaksi.idsupir` → `supir.idsupir` (NULLABLE)

### Indexes:
- Primary keys (automatic)
- Foreign key indexes for performance
- Status indexes for filtering
- Date indexes for reporting