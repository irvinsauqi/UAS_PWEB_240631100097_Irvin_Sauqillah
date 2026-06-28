-- ============================================
-- database.sql — Setup Database db_sekolah
-- ============================================
-- Cara pakai:
-- 1. Buka phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Klik "Import" → pilih file ini → klik "Go"
-- ATAU jalankan via terminal: mysql -u root -p < database.sql

-- Buat & pilih database
CREATE DATABASE IF NOT EXISTS db_sekolah
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_sekolah;

-- Hapus tabel jika sudah ada (untuk fresh install)
DROP TABLE IF EXISTS siswa;

-- Buat tabel siswa
CREATE TABLE siswa (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nis        VARCHAR(20)  NOT NULL UNIQUE,
    nama       VARCHAR(100) NOT NULL,
    kelas      ENUM('X','XI','XII') NOT NULL,
    jurusan    VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 5 Record Data Awal
-- ============================================
INSERT INTO siswa (nis, nama, kelas, jurusan) VALUES
('2024001', 'Andi Pratama',       'XII', 'Rekayasa Perangkat Lunak'),
('2024002', 'Siti Nurhaliza',     'XI',  'Teknik Komputer Jaringan'),
('2024003', 'Budi Santoso',       'X',   'Rekayasa Perangkat Lunak'),
('2024004', 'Dewi Rahayu',        'XII', 'Multimedia'),
('2024005', 'Rizky Fahrezi',      'XI',  'Rekayasa Perangkat Lunak');
