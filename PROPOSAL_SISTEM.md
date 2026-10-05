# PROPOSAL SISTEM PELAPORAN KEGIATAN HARIAN PEGAWAI (Versi Gratis)

## 1. PENDAHULUAN

### 1.1 Latar Belakang
Manajemen sumber daya manusia memerlukan sistem untuk memantau dan mengevaluasi kinerja pegawai secara objektif. Sistem pelaporan kegiatan harian pegawai dirancang untuk:
- Meningkatkan transparansi dan akuntabilitas kerja
- Memudahkan monitoring kinerja pegawai
- Mempercepat proses persetujuan laporan
- Menghasilkan data yang akurat untuk evaluasi kinerja
- **Menghasilkan rekapan bulanan yang dapat diunduh oleh setiap pegawai dalam format PDF**

### 1.2 Tujuan Sistem
Sistem ini bertujuan untuk:
1. Memfasilitasi pegawai dalam mencatat kegiatan harian secara sistematis
2. Memungkinkan atasan memantau dan menyetujui laporan kerja
3. Menghasilkan rekapan bulanan per pegawai dalam format PDF
4. Memungkinkan pegawai mengunduh rekapan bulanan mereka sendiri
5. Meningkatkan efisiensi administrasi pelaporan kegiatan

## 2. RUANG LINGKUP SISTEM

### 2.1 Fitur Utama
1. **Manajemen User**
   - Login multi-role (Admin, Pegawai, Atasan)
   - Manajemen user dan hak akses
   - Reset password

2. **Pelaporan Harian**
   - Input laporan kegiatan harian
   - Rincian kegiatan, target, dan hasil
   - Pencatatan waktu kerja
   - Upload file bukti kerja (foto, dokumen)
   - Revisi laporan

3. **Persetujuan & Monitoring**
   - Dashboard laporan untuk atasan
   - Persetujuan/penolakan/revisi laporan
   - Notifikasi otomatis
   - Riwayat laporan

4. **Rekapan Bulanan (Fitur Utama)**
   - Generate rekapan laporan bulanan per pegawai
   - Download PDF rekapan bulanan
   - Statistik kegiatan per bulan
   - **Setiap pegawai hanya bisa unduh rekapan dirinya sendiri**

### 2.2 Role & Hak Akses

| Fitur | Pegawai | Atasan | Admin |
|-------|---------|--------|-------|
| Input Laporan Harian | ✓ | ✓ | ✓ |
| Lihat Laporan Sendiri | ✓ | ✓ | ✓ |
| Lihat Laporan Bawahan | ✗ | ✓ | ✓ |
| Setujui Laporan | ✗ | ✓ | ✓ |
| Download Rekapan Bulanan Sendiri | ✓ | ✓ | ✓ |
| Download Rekapan Bawahan | ✗ | ✓ | ✓ |
| Lihat Dashboard Admin | ✗ | ✗ | ✓ |
| Kelola User | ✗ | ✗ | ✓ |
| Kelola Unit Kerja | ✗ | ✗ | ✓ |

## 3. ALUR KERJA SISTEM

```
┌─────────────────┐
│  PEGAWAI LOGIN  │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────┐
│  INPUT LAPORAN HARIAN       │
│  - Kegiatan                 │
│  - Target & Hasil           │
│  - Kendala                  │
│  - Upload File Bukti        │
└────────┬────────────────────┘
         │
         ▼
┌─────────────────────────────┐
│  LAPORAN TERSIMPAN (DRAFT)  │
└────────┬────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│  PEGAWAI SUBMIT LAPORAN      │
│  Status: MENUNGGU PERSETUJUAN│
└────────┬─────────────────────┘
         │
         ▼
┌──────────────────────────────┐
│  ATASAN MENERIMA NOTIFIKASI  │
└────────┬─────────────────────┘
         │
    ┌────┴────┐
    │          │
    ▼          ▼
┌────────┐ ┌──────────┐
│DISETUJUI│ │DITOLAK/ │
└────┬───┘ │REVISI   │
     │      └────┬────┘
     │           │
     │      ┌────▼─────┐
     │      │ PEGAWAI   │
     │      │ REVISI    │
     │      └────┬─────┘
     │           │
     └───────┬───┘
             │
             ▼
    ┌──────────────────────┐
    │ LAPORAN DISETUJUI    │
    │ (Status: APPROVED)   │
    └──────────┬───────────┘
               │
               ▼
    ┌──────────────────────┐
    │ PEGAWAI DAPAT:       │
    │ - Lihat Rekap Bulanan│
    │ - Download PDF       │
    │ - Cetak Laporan      │
    └──────────────────────┘
```

## 4. FITUR REKAPAN LAPORAN BULANAN (SPESIFIKASI)

### 4.1 Cara Kerja
1. Pegawai dapat mengakses menu "Rekapan Bulanan"
2. Memilih bulan dan tahun yang ingin direkapkan
3. Sistem mengumpulkan semua laporan harian yang sudah disetujui
4. Generate rekapan dalam format PDF
5. Pegawai dapat download PDF rekapan

### 4.2 Isi Rekapan Bulanan PDF
- **Header**: 
  - Logo Perusahaan
  - Judul: "REKAPAN LAPORAN KEGIATAN HARIAN"
  - Nama Pegawai & NIP
  - Unit Kerja
  - Periode (Bulan & Tahun)

- **Ringkasan Statistik**:
  - Total hari kerja
  - Total laporan disetujui
  - Total laporan tertunda
  - Rata-rata kegiatan per hari

- **Tabel Detail Laporan**:
  - Tanggal
  - Kegiatan (ringkas)
  - Target
  - Hasil
  - Status

- **Analisis Pencapaian**:
  - Perbandingan target vs hasil
  - Kendala-kendala yang dihadapi
  - Catatan atasan (jika ada)

- **Footer**:
  - Tanda tangan digital pegawai
  - Tanda tangan digital atasan
  - Tanggal cetak

### 4.3 Batasan Akses
- Pegawai hanya bisa download rekapan dirinya sendiri
- Atasan bisa download rekapan dirinya + bawahan
- Admin bisa download semua rekapan

### 4.4 Route & Endpoint
```
GET  /pegawai/rekap-bulanan              # Halaman pilih bulan/tahun
POST /pegawai/rekap-bulanan/generate     # Generate rekapan
GET  /pegawai/rekap-bulanan/download/{id}?bulan=10&tahun=2026  # Download PDF
GET  /pegawai/preview-rekap/{id}?bulan=10&tahun=2026           # Preview rekap
```

## 5. TEKNOLOGI & INFRASTRUKTUR (GRATIS)

### Backend
- **Bahasa**: PHP 8.1+
- **Framework**: Laravel 11
- **Database**: MySQL 5.7+ atau MariaDB

### Frontend
- **HTML5 & CSS3**
- **Bootstrap 5 (CDN)**
- **JavaScript (jQuery optional)**

### Library Tambahan (Gratis & Open Source)
- **DomPDF**: Generate PDF dari HTML
- **Intervention/Image**: Upload gambar
- **Laravel/Tinker**: Debug

### Hosting Gratis (Pilihan)
1. **InfinityFree**: Unlimited hosting gratis
2. **000webhost**: Hosting gratis dengan domain
3. **Render**: Free tier untuk deploy
4. **Localhost**: Untuk development

### Tools Gratis
- **Composer**: Package manager PHP
- **Git**: Version control
- **Visual Studio Code**: Code editor
- **MySQL Workbench / phpMyAdmin**: Database management

## 6. STRUKTUR PROJECT LARAVEL

```
sistemp-pelaporan-kegiatan-harian/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── LaporanController.php
│   │   │   ├── RekapanController.php
│   │   │   ├── DashboardController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── UnitKerja.php
│   │   ├── LaporanHarian.php
│   │   ├── LaporanDetail.php
│   │   └── Notifikasi.php
│   └── Services/
│       └── RekapanService.php
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── navbar.blade.php
│   │   ├── pegawai/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── laporan/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   └── rekap/
│   │   │       ├── index.blade.php
│   │   │       ├── form.blade.php
│   │   │       └── pdf.blade.php
│   │   ├── atasan/
│   │   │   ├── dashboard.blade.php
│   │   │   └── laporan-bawahan.blade.php
│   │   └── admin/
│   │       ├── dashboard.blade.php
│   │       └── users.blade.php
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php
│   └── api.php
├── database/
│   └── migrations/
│       ├── 2026_10_05_001_create_unit_kerja.php
│       ├── 2026_10_05_002_create_users.php
│       ├── 2026_10_05_003_create_laporan_harian.php
│       ├── 2026_10_05_004_create_laporan_detail.php
│       └── 2026_10_05_005_create_notifikasi.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── dompdf.php
├── .env.example
├── composer.json
├── artisan
└── README.md
```

## 7. TIMELINE IMPLEMENTASI (Estimasi)

| Fase | Durasi | Kegiatan |
|------|--------|----------|
| Phase 1 | 3 hari | Setup project Laravel, database, authentication |
| Phase 2 | 4 hari | Input laporan harian, approval system |
| Phase 3 | 2 hari | Dashboard & monitoring |
| Phase 4 | 3 hari | Fitur rekapan bulanan & export PDF |
| Phase 5 | 2 hari | Testing & refinement |
| Phase 6 | 1 hari | Documentation |

**Total: 2-3 minggu**

## 8. BIAYA IMPLEMENTASI

| Komponen | Biaya |
|----------|-------|
| Pengembangan | **GRATIS** (Open Source) |
| Framework Laravel | **GRATIS** |
| Database MySQL | **GRATIS** |
| PDF Generator (DomPDF) | **GRATIS** |
| Hosting (Pilihan) | **GRATIS - Rp 100rb/bulan** |
| Domain (Optional) | Rp 150rb - 300rb/tahun |
| **TOTAL TAHUN PERTAMA** | **GRATIS - Rp 1.2 juta** |

## 9. KEUNTUNGAN SISTEM

✅ **Transparansi**: Laporan kegiatan tercatat jelas dan terukur
✅ **Efisiensi Administrasi**: Mengurangi beban administrasi manual
✅ **Data-Driven Decision**: Data akurat untuk evaluasi kinerja
✅ **Akuntabilitas**: Pegawai lebih bertanggung jawab
✅ **Dokumentasi Digital**: Arsip mudah dicari dan diakses
✅ **Reporting Otomatis**: Rekapan bulanan dapat diunduh dalam sekejap
✅ **Biaya Minimal**: Menggunakan teknologi gratis & open source
✅ **Mudah Dikembangkan**: Berbasis Laravel, mudah ditambah fitur baru

## 10. REQUIREMENTS & INSTALASI

### Minimum System Requirements
- PHP 8.1+
- MySQL 5.7+ atau MariaDB 10.3+
- Composer
- Minimal 512MB RAM
- Minimal 500MB Storage

### Cara Instalasi
1. Clone repository
   ```bash
   git clone https://github.com/SirKay032/sistem-pelaporan-kegiatan-harian.git
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Setup environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Konfigurasi database di `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_pelaporan_pegawai
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migrasi
   ```bash
   php artisan migrate --seed
   ```

6. Jalankan server
   ```bash
   php artisan serve
   ```

7. Akses aplikasi
   ```
   http://localhost:8000
   ```

### Default Login
| Username | Password | Role |
|----------|----------|------|
| admin@sistem.local | password123 | Admin |
| joko.supriyanto@local | password123 | Pegawai |
| ahmad.wijaya@local | password123 | Atasan |

---

**Dokumen Proposal Sistem Pelaporan Kegiatan Harian Pegawai (Versi Gratis)**
Dibuat: 5 Oktober 2026
