<?php
// ============================================
// index.php — Beranda (Home)
// ============================================

require 'config/db.php';
require 'functions.php';

$pageTitle = 'Beranda';

$totalSiswa    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS n FROM siswa"))['n'];
$totalJurusan  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT jurusan) AS n FROM siswa"))['n'];
$totalKelas    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT kelas) AS n FROM siswa"))['n'];

$querySiswa = "SELECT * FROM siswa ORDER BY created_at DESC LIMIT 5";
$hasilSiswa = mysqli_query($conn, $querySiswa);

include 'includes/header.php';
?>

<div class="container">
    <h2>Selamat Datang 👋</h2>
    <p class="subtitle">Sistem Informasi Data Siswa — kelola data siswa dengan mudah dan cepat.</p>

    <?php tampilkanAlert(); ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="number"><?= $totalSiswa ?></div>
            <div class="label">Total Siswa</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= $totalJurusan ?></div>
            <div class="label">Jurusan</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= $totalKelas ?></div>
            <div class="label">Kelas</div>
        </div>
    </div>

    <h3>Siswa Terbaru</h3>

    <?php if (mysqli_num_rows($hasilSiswa) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($siswa = mysqli_fetch_assoc($hasilSiswa)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= bersihkan($siswa['nis']) ?></td>
                <td><?= bersihkan($siswa['nama']) ?></td>
                <td><span class="badge"><?= bersihkan($siswa['kelas']) ?></span></td>
                <td><?= bersihkan($siswa['jurusan']) ?></td>
                <td><?= formatTanggal($siswa['created_at']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div style="margin-top:20px;">
        <a href="daftar.php" class="btn btn-primary">Lihat Semua Siswa →</a>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="icon">📭</div>
        <p>Belum ada data siswa. <a href="tambah.php">Tambah sekarang</a>.</p>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
