Nama	: Irvin Sauqillah
NIM	: 240631100097
Kelas	: 4C
LAPORAN UAS
PEMROGRAMAN WEB
Sistem Informasi Data Siswa

1.	Deskripsi
Sistem Informasi Data Siswa SMK adalah aplikasi web berbasis PHP dan MySQL untuk mengelola data siswa secara efisien. Dibangun menggunakan HTML5 untuk struktur, CSS eksternal (style.css) untuk tampilan, PHP untuk logika server-side, dan MySQL sebagai sistem manajemen basis data. Desain responsif dan mudah digunakan, dapat diakses dari berbagai perangkat.
Halaman Beranda (index.php) adalah tampilan utama yang menampilkan statistik ringkasan sistem meliputi Total Siswa, jumlah Jurusan yang tersedia, dan jumlah Kelas aktif. Setiap statistik ditampilkan dalam kartu dengan warna ungu-gradasi khas sistem. Beranda juga menampilkan tabel 5 siswa terbaru dengan tombol "Lihat Semua Siswa" untuk mengakses daftar lengkap.
Halaman Daftar Siswa (daftar.php) menampilkan seluruh data siswa dalam tabel lengkap dengan fitur pencarian berdasarkan nama, NIS, atau jurusan, serta filter berdasarkan kelas (X, XI, XII). Tabel mencakup enam kolom: nomor, NIS, nama siswa, kelas, jurusan, dan tanggal terdaftar. Setiap baris dilengkapi tombol Edit (kuning) dan Hapus (merah). Kelas ditampilkan dengan badge berwarna ungu muda.
Halaman Tambah Siswa (tambah.php) menyediakan formulir input untuk mendaftarkan siswa baru dengan empat field wajib: NIS (Nomor Induk Siswa), Nama Lengkap, Kelas (X/XI/XII), dan Jurusan (dengan 5 pilihan). Sistem menyertakan validasi server-side termasuk pengecekan duplikasi NIS, serta menampilkan pesan error bila ada input yang tidak valid.
Halaman Edit Siswa (edit.php) menampilkan formulir yang sama dengan data siswa yang sudah terisi untuk diperbarui. Sistem memvalidasi ulang data termasuk memeriksa duplikasi NIS terhadap siswa lain. Operasi hapus ditangani oleh hapus.php dengan konfirmasi JavaScript sebelum data dihapus dari database.
Fitur Umum: Navigasi di bagian atas halaman, flash message (pesan sukses/error) menggunakan parameter GET, operasi CRUD lengkap (Create, Read, Update, Delete), validasi form dengan fungsi PHP helper, serta penggunaan include/require untuk header (header.php) dan footer (footer.php) agar kode tidak berulang.

2.	Screenshot Aplikasi
-	Tampilan Beranda (Home) dengan statistik siswa

-	Tampilan menu Daftar Siswa

-	Tampilan menu Tambah Data

-	Tampilan setelah data berhasil ditambahkan

-	Tampilan halaman Edit Data

-	Tampilan setelah data berhasil diedit

-	Tampilan konfirmasi dan sesudah data dihapus

-	Tampilan fitur pencarian dan filter kelas

3.	Struktur Database
Kode SQL:
CREATE DATABASE IF NOT EXISTS `db_sekolah`; USE `db_sekolah`;  CREATE TABLE `siswa` (   `id` int(11) NOT NULL,   `nis` varchar(20) NOT NULL,   `nama` varchar(100) NOT NULL,   `kelas` enum('X','XI','XII') NOT NULL,   `jurusan` varchar(100) NOT NULL,   `created_at` timestamp NOT NULL DEFAULT current_timestamp() ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;  INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jurusan`) VALUES (1, '2024001', 'Andi Pratama', 'XII', 'Rekayasa Perangkat Lunak'), (2, '2024002', 'Siti Nurhaliza', 'XI', 'Teknik Komputer Jaringan'), (3, '2024003', 'Budi Santoso', 'X', 'Rekayasa Perangkat Lunak'), (4, '2024004', 'Dewi Rahayu', 'XII', 'Multimedia'), (5, '2024005', 'Rizky Fahrezi', 'XI', 'Rekayasa Perangkat Lunak');  ALTER TABLE `siswa`   ADD PRIMARY KEY (`id`),   ADD UNIQUE KEY `nis` (`nis`);  ALTER TABLE `siswa`   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6; COMMIT;

4.	Cara Menjalankan Aplikasi
-	Pastikan XAMPP sudah diinstal dan aktifkan modul Apache serta MySQL
 
-	Buka aplikasi di browser dengan mengakses http://localhost/web_sekolah/
 
-	Halaman beranda menampilkan statistik; klik Daftar Siswa untuk melihat data
 
 
-	Klik tombol Tambah Siswa, isi formulir (NIS, Nama, Kelas, Jurusan), klik Simpan
 
-	Klik Edit pada baris siswa, ubah data yang diinginkan, klik Perbarui Data
 
-	Klik Hapus pada baris siswa, konfirmasi pada dialog, data akan terhapus
 
-	Gunakan kolom pencarian di halaman Daftar Siswa untuk menyaring data
 

dibuat dengan bantuan antropi
