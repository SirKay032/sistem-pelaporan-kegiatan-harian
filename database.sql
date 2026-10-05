-- Database: sistem_pelaporan_pegawai
-- Created: 2026-10-05
-- Description: Database schema untuk Sistem Pelaporan Kegiatan Harian Pegawai

CREATE DATABASE IF NOT EXISTS sistem_pelaporan_pegawai;
USE sistem_pelaporan_pegawai;

-- =============================================
-- TABLE: unit_kerja
-- =============================================
CREATE TABLE unit_kerja (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama_unit VARCHAR(100) NOT NULL UNIQUE,
  kepala_unit_id INT,
  deskripsi TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =============================================
-- TABLE: users
-- =============================================
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nip VARCHAR(20) UNIQUE NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'pegawai', 'atasan') DEFAULT 'pegawai',
  unit_id INT,
  atasan_id INT,
  status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
  foto_profil VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (unit_id) REFERENCES unit_kerja(id),
  FOREIGN KEY (atasan_id) REFERENCES users(id),
  INDEX idx_role (role),
  INDEX idx_unit_id (unit_id),
  INDEX idx_email (email)
);

-- =============================================
-- TABLE: laporan_harian
-- =============================================
CREATE TABLE laporan_harian (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  tanggal DATE NOT NULL,
  judul VARCHAR(255),
  deskripsi TEXT,
  status ENUM('draft', 'submitted', 'approved', 'rejected', 'revision') DEFAULT 'draft',
  catatan_atasan TEXT,
  approved_by INT,
  approved_at DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (approved_by) REFERENCES users(id),
  INDEX idx_user_tanggal (user_id, tanggal),
  INDEX idx_status (status),
  INDEX idx_tanggal (tanggal),
  UNIQUE KEY unique_laporan (user_id, tanggal)
);

-- =============================================
-- TABLE: laporan_detail
-- =============================================
CREATE TABLE laporan_detail (
  id INT PRIMARY KEY AUTO_INCREMENT,
  laporan_id INT NOT NULL,
  kegiatan TEXT NOT NULL,
  output TEXT,
  target TEXT,
  hasil TEXT,
  waktu_mulai TIME,
  waktu_selesai TIME,
  file_bukti VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (laporan_id) REFERENCES laporan_harian(id) ON DELETE CASCADE,
  INDEX idx_laporan_id (laporan_id)
);

-- =============================================
-- TABLE: notifikasi
-- =============================================
CREATE TABLE notifikasi (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  judul VARCHAR(255) NOT NULL,
  pesan TEXT,
  tipe ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
  dibaca BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_user_dibaca (user_id, dibaca),
  INDEX idx_created_at (created_at)
);

-- =============================================
-- Insert Data Demo
-- =============================================

-- Insert unit kerja
INSERT INTO unit_kerja (nama_unit, deskripsi) VALUES
('Administrasi', 'Bagian Administrasi dan Tata Usaha'),
('Operasional', 'Bagian Operasional dan Lapangan'),
('IT & Teknologi', 'Bagian IT dan Infrastruktur');

-- Insert users - Admin
INSERT INTO users (nip, nama, email, password, role, unit_id, status) VALUES
('00001', 'Admin Sistem', 'admin@sistem.local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'admin', 1, 'aktif');

-- Insert users - Atasan (Supervisor)
INSERT INTO users (nip, nama, email, password, role, unit_id, status) VALUES
('00002', 'Ahmad Wijaya', 'ahmad.wijaya@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'atasan', 1, 'aktif'),
('00003', 'Rini Rahayu', 'rini.rahayu@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'atasan', 2, 'aktif');

-- Insert users - Pegawai
INSERT INTO users (nip, nama, email, password, role, unit_id, atasan_id, status) VALUES
('00004', 'Joko Supriyanto', 'joko.supriyanto@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 1, 2, 'aktif'),
('00005', 'Dewi Lestari', 'dewi.lestari@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 1, 2, 'aktif'),
('00006', 'Eka Putra Wijaya', 'eka.putra@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 2, 3, 'aktif'),
('00007', 'Sinta Megawati', 'sinta.megawati@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 2, 3, 'aktif');

-- Insert laporan harian demo (Oktober 2026)
INSERT INTO laporan_harian (user_id, tanggal, judul, deskripsi, status, approved_by, approved_at) VALUES
(4, '2026-10-01', 'Laporan Kegiatan 1 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 2, NOW()),
(4, '2026-10-02', 'Laporan Kegiatan 2 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 2, NOW()),
(4, '2026-10-03', 'Laporan Kegiatan 3 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 2, NOW()),
(4, '2026-10-04', 'Laporan Kegiatan 4 Oktober 2026', 'Laporan kegiatan rutin', 'submitted', NULL, NULL),
(5, '2026-10-01', 'Laporan Kegiatan 1 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 2, NOW()),
(5, '2026-10-02', 'Laporan Kegiatan 2 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 2, NOW()),
(6, '2026-10-01', 'Laporan Kegiatan 1 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 3, NOW()),
(6, '2026-10-02', 'Laporan Kegiatan 2 Oktober 2026', 'Laporan kegiatan rutin', 'approved', 3, NOW()),
(6, '2026-10-03', 'Laporan Kegiatan 3 Oktober 2026', 'Laporan kegiatan rutin', 'submitted', NULL, NULL);

-- Insert laporan detail
INSERT INTO laporan_detail (laporan_id, kegiatan, output, target, hasil, waktu_mulai, waktu_selesai) VALUES
(1, 'Menyusun dokumen rekap perjalanan dinas', '15 dokumen', 'Selesai hari ini', 'Selesai 100%', '08:00:00', '11:00:00'),
(1, 'Input data ke sistem absensi', 'Data lengkap', 'Selesai hari ini', 'Selesai 100%', '13:00:00', '16:00:00'),
(2, 'Follow up dokumen yang hilang', '5 dokumen terverifikasi', 'Selesai hari ini', 'Selesai 100%', '08:30:00', '10:30:00'),
(2, 'Rapat dengan bagian operasional', 'Notulen rapat', 'Selesai hari ini', 'Selesai 100%', '14:00:00', '15:30:00'),
(3, 'Pembaruan database karyawan', '50 data', 'Selesai hari ini', 'Selesai 90%', '09:00:00', '12:00:00'),
(3, 'Koordinasi dengan bagian HR', 'Koordinasi selesai', 'Selesai hari ini', 'Selesai 100%', '13:00:00', '14:00:00'),
(4, 'Menyelesaikan laporan bulanan', 'Laporan draft', 'Selesai hari ini', 'Dalam proses 60%', '08:00:00', '15:00:00'),
(5, 'Pengarsipan dokumen lama', '100 dokumen', 'Selesai hari ini', 'Selesai 100%', '08:00:00', '11:00:00'),
(5, 'Input ke sistem manajemen', 'Data terinput', 'Selesai hari ini', 'Selesai 80%', '13:00:00', '16:00:00'),
(6, 'Persiapan laporan operasional', 'Data terkumpul', 'Selesai hari ini', 'Selesai 100%', '08:30:00', '11:30:00'),
(7, 'Monitoring lapangan', 'Laporan monitoring', 'Selesai hari ini', 'Selesai 100%', '07:00:00', '15:00:00'),
(8, 'Inspeksi area kerja', '2 area', 'Inspeksi 2 area', 'Selesai 100%', '08:00:00', '12:00:00'),
(8, 'Koordinasi dengan tim lapangan', 'Koordinasi selesai', 'Selesai hari ini', 'Selesai 100%', '14:00:00', '16:00:00'),
(9, 'Pengumpulan data lapangan', 'Data dari 3 lokasi', 'Target: 3 lokasi', 'Selesai 70%', '07:00:00', '16:00:00');

-- Insert notifikasi demo
INSERT INTO notifikasi (user_id, judul, pesan, tipe, dibaca) VALUES
(2, 'Laporan baru menunggu persetujuan', 'Anda memiliki 2 laporan yang menunggu persetujuan', 'warning', FALSE),
(4, 'Laporan disetujui', 'Laporan Anda untuk tanggal 2026-10-01 telah disetujui', 'success', TRUE),
(4, 'Pengingat pengisian laporan', 'Jangan lupa isi laporan kegiatan hari ini', 'info', FALSE),
(6, 'Laporan ditolak', 'Laporan Anda untuk tanggal 2026-10-03 ditolak dengan catatan: Kurang detail', 'error', FALSE);

-- =============================================
-- VIEWS
-- =============================================

-- View untuk laporan yang menunggu persetujuan
CREATE OR REPLACE VIEW v_laporan_menunggu AS
SELECT 
  lh.id,
  lh.user_id,
  u.nama AS nama_pegawai,
  u.nip,
  lh.tanggal,
  lh.judul,
  lh.status,
  lh.created_at
FROM laporan_harian lh
JOIN users u ON lh.user_id = u.id
WHERE lh.status IN ('submitted', 'revision')
ORDER BY lh.created_at DESC;

-- =============================================
-- SAMPLE PASSWORD: password123
-- Hash: $2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma
-- =============================================
