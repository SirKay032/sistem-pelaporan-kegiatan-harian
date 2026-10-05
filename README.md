-- Database: sistem_pelaporan_pegawai
-- Created: 2026-10-05
-- Description: Schema awal untuk sistem pelaporan kegiatan harian pegawai

CREATE DATABASE IF NOT EXISTS sistem_pelaporan_pegawai;
USE sistem_pelaporan_pegawai;

CREATE TABLE unit_kerja (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama_unit VARCHAR(100) NOT NULL UNIQUE,
  deskripsi TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (unit_id) REFERENCES unit_kerja(id),
  FOREIGN KEY (atasan_id) REFERENCES users(id)
);

CREATE TABLE laporan_harian (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  tanggal DATE NOT NULL,
  judul VARCHAR(255) NOT NULL,
  deskripsi TEXT,
  status ENUM('submitted', 'approved', 'rejected', 'revision') DEFAULT 'submitted',
  catatan_atasan TEXT,
  approved_by INT,
  approved_at DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (approved_by) REFERENCES users(id)
);

CREATE TABLE laporan_detail (
  id INT PRIMARY KEY AUTO_INCREMENT,
  laporan_id INT NOT NULL,
  kegiatan TEXT NOT NULL,
  target TEXT,
  hasil TEXT,
  waktu_mulai TIME,
  waktu_selesai TIME,
  file_bukti VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (laporan_id) REFERENCES laporan_harian(id) ON DELETE CASCADE
);

CREATE TABLE notifikasi (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  judul VARCHAR(255) NOT NULL,
  pesan TEXT,
  tipe ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
  dibaca BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO unit_kerja (nama_unit, deskripsi) VALUES
('Administrasi', 'Bagian administrasi dan umum'),
('Operasional', 'Bagian yang menangani operasional harian'),
('IT', 'Bagian teknologi informasi');

INSERT INTO users (nip, nama, email, password, role, unit_id, atasan_id, status) VALUES
('00001', 'Admin Sistem', 'admin@sistem.local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'admin', 1, NULL, 'aktif'),
('00002', 'Ahmad Wijaya', 'ahmad.wijaya@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'atasan', 1, NULL, 'aktif'),
('00003', 'Joko Supriyanto', 'joko.supriyanto@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 1, 2, 'aktif'),
('00004', 'Dewi Lestari', 'dewi.lestari@local', '$2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma', 'pegawai', 2, 2, 'aktif');

INSERT INTO laporan_harian (user_id, tanggal, judul, deskripsi, status, approved_by, approved_at) VALUES
(3, '2026-10-01', 'Laporan Kegiatan 1 Oktober', 'Input data administrasi dan dokumen', 'approved', 2, NOW()),
(3, '2026-10-02', 'Laporan Kegiatan 2 Oktober', 'Penyusunan laporan mingguan', 'submitted', NULL, NULL),
(4, '2026-10-01', 'Laporan Kegiatan Operasional', 'Pengawasan kegiatan lapangan', 'approved', 2, NOW());

INSERT INTO laporan_detail (laporan_id, kegiatan, target, hasil) VALUES
(1, 'Menyusun rekap dokumen', 'Selesai semua', 'Selesai 100%'),
(1, 'Input data pegawai', 'Semua data masuk', 'Selesai 100%'),
(2, 'Penyusunan laporan mingguan', 'Rutin harian', 'Dalam proses'),
(3, 'Monitoring lapangan', '2 lokasi', 'Selesai 100%');

INSERT INTO notifikasi (user_id, judul, pesan, tipe, dibaca) VALUES
(3, 'Laporan disetujui', 'Laporan tanggal 2026-10-01 telah disetujui', 'success', TRUE),
(3, 'Pengingat laporan', 'Jangan lupa mengisi laporan hari ini', 'info', FALSE);

-- Password default untuk semua user: password123
-- Hash sesuai kebutuhan login: $2y$10$92IXUNpkio0OVc4.7lChCOYz6TtxMQJqhN8/LewY5YmNrjsnqCnma
