# Sistem Pelaporan Kegiatan Harian Pegawai

**Aplikasi Web untuk mencatat, memantau, dan mengelola laporan kegiatan harian pegawai dengan fitur rekapan bulanan yang dapat diunduh dalam format PDF.**

## 🎯 Fitur Utama

✅ **Manajemen User** - Login multi-role (Admin, Pegawai, Atasan)
✅ **Pelaporan Harian** - Input laporan kegiatan dengan detail, target, hasil, dan file bukti
✅ **Approval System** - Atasan dapat menyetujui, menolak, atau meminta revisi laporan
✅ **Dashboard** - Monitoring laporan untuk setiap role
✅ **Rekapan Bulanan** - Generate dan download laporan bulanan dalam PDF
✅ **Notifikasi** - Sistem notifikasi otomatis untuk status laporan
✅ **Riwayat Laporan** - Lihat seluruh riwayat laporan harian

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- MySQL 5.7+ atau MariaDB 10.3+
- Composer
- Git

### Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/SirKay032/sistem-pelaporan-kegiatan-harian.git
   cd sistem-pelaporan-kegiatan-harian
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Edit file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_pelaporan_pegawai
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan Migrasi & Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

7. **Akses Aplikasi**
   ```
   http://localhost:8000
   ```

## 👥 Default Login Credentials

| Email | Password | Role |
|-------|----------|------|
| admin@sistem.local | password123 | Admin |
| joko.supriyanto@local | password123 | Pegawai |
| ahmad.wijaya@local | password123 | Atasan |

## 📋 Struktur Project

```
sistemp-pelaporan-kegiatan-harian/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Services/
├── resources/views/
│   ├── auth/
│   ├── layouts/
│   ├── pegawai/
│   ├── atasan/
│   └── admin/
├── routes/
├── database/
│   ├── migrations/
│   └── seeders/
├── .env.example
├── composer.json
└── README.md
```

## 🔧 Konfigurasi Penting

### Konfigurasi PDF (DomPDF)
Edit `config/dompdf.php` jika diperlukan customization PDF.

### Konfigurasi Upload File
Ubah `UPLOAD_PATH` di file controller jika perlu mengubah lokasi upload.

## 🎨 Role & Hak Akses

### Admin
- Mengelola user dan unit kerja
- Melihat semua laporan
- Download semua rekapan bulanan
- Dashboard statistik keseluruhan

### Atasan
- Melihat laporan bawahan
- Menyetujui/menolak/revisi laporan
- Download rekapan diri sendiri dan bawahan
- Dashboard monitoring bawahan

### Pegawai
- Input laporan harian
- Melihat riwayat laporan diri sendiri
- Download rekapan bulanan diri sendiri
- Menerima notifikasi

## 📊 Fitur Rekapan Bulanan

### Cara Menggunakan
1. Login sebagai Pegawai/Atasan
2. Klik menu "Rekapan Bulanan"
3. Pilih bulan dan tahun
4. Klik "Generate Rekapan"
5. Download PDF

### Isi Rekapan PDF
- Header dengan identitas pegawai
- Ringkasan statistik bulanan
- Tabel detail laporan per hari
- Analisis pencapaian target vs hasil
- Daftar kendala yang dihadapi
- Catatan atasan (jika ada)
- Tanda tangan digital

## 🔐 Security Features

- Password hashing dengan Bcrypt
- CSRF protection
- SQL Injection prevention
- XSS protection
- Role-based access control
- Session management

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## 📝 Database Schema

### Tabel Utama
- `users` - Data pengguna
- `unit_kerja` - Data unit/departemen
- `laporan_harian` - Data laporan harian
- `laporan_detail` - Detail kegiatan per laporan
- `notifikasi` - Notifikasi sistem

Lihat file `database.sql` untuk schema lengkap.

## 🚀 Deployment

### Hosting Gratis
1. **InfinityFree** - Unlimited hosting
2. **000webhost** - Hosting gratis dengan domain
3. **Render** - Free tier untuk deploy

### Hosting Berbayar (Recommended)
1. **DigitalOcean** - $4/bulan
2. **Linode** - $5/bulan
3. **Heroku** - Free tier + berbayar

## 📚 Dokumentasi

- [PROPOSAL_SISTEM.md](PROPOSAL_SISTEM.md) - Proposal lengkap sistem
- [database.sql](database.sql) - Schema database

## 🤝 Kontribusi

Untuk berkontribusi:
1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini menggunakan Lisensi MIT. Lihat file `LICENSE` untuk detail.

## 👨‍💻 Author

**SirKay032**
- GitHub: [@SirKay032](https://github.com/SirKay032)

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Buat issue di GitHub
2. Hubungi melalui email (cek profil GitHub)
3. Lihat FAQ di dokumentasi

## 🗺️ Roadmap

- [ ] Mobile app (React Native)
- [ ] Email notification
- [ ] WhatsApp notification
- [ ] Analytics dashboard
- [ ] Export Excel (Optional)
- [ ] Dark mode
- [ ] Multi-language support
- [ ] API REST

## 📊 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Bootstrap 5 + Blade Templating
- **Database**: MySQL
- **PDF Generator**: DomPDF
- **Authentication**: Laravel Auth
- **Session Management**: Laravel Session

---

**Dibuat dengan ❤️ untuk meningkatkan efisiensi pelaporan kegiatan pegawai**

Last Updated: October 5, 2026
