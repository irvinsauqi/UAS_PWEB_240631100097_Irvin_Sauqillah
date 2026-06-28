<?php
// ============================================
// daftar.php — Daftar Data Siswa (Read + Delete)
// ============================================

require 'config/db.php';
require 'functions.php';

$pageTitle = 'Daftar Siswa';

// --- FITUR PENCARIAN (GET) ---
$cari = '';
$kondisi = '';

if (isset($_GET['cari']) && $_GET['cari'] !== '') {
    $cari     = bersihkan($_GET['cari']);
    $cariDB   = mysqli_real_escape_string($conn, $_GET['cari']);
    $kondisi  = "WHERE nama LIKE '%$cariDB%' OR nis LIKE '%$cariDB%' OR jurusan LIKE '%$cariDB%'";
}

// --- FILTER KELAS ---
$filterKelas = '';
if (isset($_GET['kelas']) && $_GET['kelas'] !== '') {
    $filterKelas = mysqli_real_escape_string($conn, $_GET['kelas']);
    $sep = ($kondisi === '') ? 'WHERE' : 'AND';
    $kondisi .= " $sep kelas = '$filterKelas'";
}

$query   = "SELECT * FROM siswa $kondisi ORDER BY created_at DESC";
$hasil   = mysqli_query($conn, $query);
$total   = mysqli_num_rows($hasil);

include 'includes/header.php';
?>

<div class="container">
    <div class="action-bar">
        <div>
            <h2>Daftar Siswa</h2>
            <p class="subtitle" style="margin-bottom:0; border:none; padding:0;">
                Menampilkan <strong><?= $total ?></strong> data
                <?= $cari !== '' ? " — hasil pencarian: \"$cari\"" : '' ?>
            </p>
        </div>
        <a href="tambah.php" class="btn btn-primary">➕ Tambah Siswa</a>
    </div>

    <?php tampilkanAlert(); ?>

    <!-- Form Pencarian & Filter -->
    <form method="GET" action="daftar.php" style="display:flex; gap:10px; margin-bottom:22px; flex-wrap:wrap;">
        <input
            type="text"
            name="cari"
            placeholder="Cari nama, NIS, atau jurusan..."
            value="<?= $cari ?>"
            style="flex:1; min-width:200px;"
        >
        <select name="kelas" style="width:130px;">
            <option value="">Semua Kelas</option>
            <?php
            $kelasOpt = ['X', 'XI', 'XII'];
            foreach ($kelasOpt as $k):
            ?>
            <option value="<?= $k ?>" <?= $filterKelas === $k ? 'selected' : '' ?>><?= $k ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">🔍 Cari</button>
        <?php if ($cari !== '' || $filterKelas !== ''): ?>
        <a href="daftar.php" class="btn btn-secondary">✕ Reset</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data -->
    <?php if ($total > 0): ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($siswa = mysqli_fetch_assoc($hasil)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= bersihkan($siswa['nis']) ?></td>
                <td><strong><?= bersihkan($siswa['nama']) ?></strong></td>
                <td><span class="badge"><?= bersihkan($siswa['kelas']) ?></span></td>
                <td><?= bersihkan($siswa['jurusan']) ?></td>
                <td><?= formatTanggal($siswa['created_at']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $siswa['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                    <a href="hapus.php?id=<?= $siswa['id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus data siswa <?= bersihkan($siswa['nama']) ?>?')">
                        🗑️ Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php else: ?>
    <div class="empty-state">
        <div class="icon">🔍</div>
        <p>
            <?= ($cari !== '' || $filterKelas !== '')
                ? "Tidak ditemukan data yang cocok."
                : "Belum ada data siswa." ?>
        </p>
        <?php if ($cari !== '' || $filterKelas !== ''): ?>
            <a href="daftar.php" class="btn btn-secondary" style="margin-top:12px;">Tampilkan Semua</a>
        <?php else: ?>
            <a href="tambah.php" class="btn btn-primary" style="margin-top:12px;">Tambah Siswa Pertama</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
