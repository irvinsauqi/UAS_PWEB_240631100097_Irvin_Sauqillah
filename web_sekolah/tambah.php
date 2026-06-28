<?php

require 'config/db.php';
require 'functions.php';

$pageTitle = 'Tambah Siswa';
$errors    = [];
$old       = ['nis' => '', 'nama' => '', 'kelas' => '', 'jurusan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil & bersihkan input
    $nis     = bersihkan($_POST['nis'] ?? '');
    $nama    = bersihkan($_POST['nama'] ?? '');
    $kelas   = bersihkan($_POST['kelas'] ?? '');
    $jurusan = bersihkan($_POST['jurusan'] ?? '');

    $old = compact('nis', 'nama', 'kelas', 'jurusan');

    if (empty($nis)) {
        $errors[] = 'NIS wajib diisi.';
    } elseif (!preg_match('/^\d{5,15}$/', $nis)) {
        $errors[] = 'NIS harus berupa angka (5–15 digit).';
    } elseif (cekNISDuplikat($conn, $nis)) {
        $errors[] = "NIS $nis sudah terdaftar.";
    }

    if (empty($nama)) {
        $errors[] = 'Nama siswa wajib diisi.';
    } elseif (strlen($nama) < 3) {
        $errors[] = 'Nama minimal 3 karakter.';
    }

    if (empty($kelas)) {
        $errors[] = 'Kelas wajib dipilih.';
    }

    if (empty($jurusan)) {
        $errors[] = 'Jurusan wajib dipilih.';
    }

    if (empty($errors)) {
        $nisDB     = mysqli_real_escape_string($conn, $nis);
        $namaDB    = mysqli_real_escape_string($conn, $nama);
        $kelasDB   = mysqli_real_escape_string($conn, $kelas);
        $jurusanDB = mysqli_real_escape_string($conn, $jurusan);

        $sql = "INSERT INTO siswa (nis, nama, kelas, jurusan)
                VALUES ('$nisDB', '$namaDB', '$kelasDB', '$jurusanDB')";

        if (mysqli_query($conn, $sql)) {
            redirect('daftar.php', "✅ Data siswa $nama berhasil ditambahkan!");
        } else {
            $errors[] = 'Gagal menyimpan data: ' . mysqli_error($conn);
        }
    }
}

$daftarKelas   = ['X', 'XI', 'XII'];
$daftarJurusan = [
    'Rekayasa Perangkat Lunak',
    'Teknik Komputer Jaringan',
    'Multimedia',
    'Akuntansi',
    'Bisnis Daring dan Pemasaran',
];

include 'includes/header.php';
?>

<div class="container">
    <h2>➕ Tambah Data Siswa</h2>
    <p class="subtitle">Isi formulir di bawah untuk mendaftarkan siswa baru.</p>

    <!-- Tampilkan Error -->
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin:8px 0 0 16px;">
            <?php foreach ($errors as $err): ?>
            <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- FORM TAMBAH -->
    <form method="POST" action="tambah.php">

        <div class="form-group">
            <label for="nis">NIS (Nomor Induk Siswa) <span style="color:#d63031">*</span></label>
            <input type="text" id="nis" name="nis" value="<?= $old['nis'] ?>"
                   placeholder="Contoh: 202400123" maxlength="15">
        </div>

        <div class="form-group">
            <label for="nama">Nama Lengkap <span style="color:#d63031">*</span></label>
            <input type="text" id="nama" name="nama" value="<?= $old['nama'] ?>"
                   placeholder="Masukkan nama lengkap siswa">
        </div>

        <div class="form-group">
            <label for="kelas">Kelas <span style="color:#d63031">*</span></label>
            <select id="kelas" name="kelas">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($daftarKelas as $k): ?>
                <option value="<?= $k ?>" <?= $old['kelas'] === $k ? 'selected' : '' ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan <span style="color:#d63031">*</span></label>
            <select id="jurusan" name="jurusan">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($daftarJurusan as $j): ?>
                <option value="<?= $j ?>" <?= $old['jurusan'] === $j ? 'selected' : '' ?>><?= $j ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">💾 Simpan Data</button>
            <a href="daftar.php" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>

<?php include 'includes/footer.php'; ?>
