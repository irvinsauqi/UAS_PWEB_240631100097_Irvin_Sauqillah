<?php
// ============================================
// edit.php — Edit Data Siswa (Update)
// ============================================

require 'config/db.php';
require 'functions.php';

$pageTitle = 'Edit Siswa';
$errors    = [];

// --- VALIDASI ID ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('daftar.php', '❌ ID tidak valid.', 'danger');
}

$id = (int) $_GET['id'];

// Ambil data siswa dari DB
$queryAmbil = "SELECT * FROM siswa WHERE id = $id LIMIT 1";
$hasilAmbil = mysqli_query($conn, $queryAmbil);

if (mysqli_num_rows($hasilAmbil) === 0) {
    redirect('daftar.php', '❌ Data siswa tidak ditemukan.', 'danger');
}

$siswa = mysqli_fetch_assoc($hasilAmbil);

// Nilai awal dari DB (bisa tertimpa POST jika ada error)
$old = [
    'nis'     => $siswa['nis'],
    'nama'    => $siswa['nama'],
    'kelas'   => $siswa['kelas'],
    'jurusan' => $siswa['jurusan'],
];

// --- PROSES FORM (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nis     = bersihkan($_POST['nis'] ?? '');
    $nama    = bersihkan($_POST['nama'] ?? '');
    $kelas   = bersihkan($_POST['kelas'] ?? '');
    $jurusan = bersihkan($_POST['jurusan'] ?? '');

    $old = compact('nis', 'nama', 'kelas', 'jurusan');

    // Validasi percabangan
    if (empty($nis)) {
        $errors[] = 'NIS wajib diisi.';
    } elseif (!preg_match('/^\d{5,15}$/', $nis)) {
        $errors[] = 'NIS harus berupa angka (5–15 digit).';
    } elseif (cekNISDuplikat($conn, $nis, $id)) {
        $errors[] = "NIS $nis sudah dipakai siswa lain.";
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

    // Jika valid, update ke database
    if (empty($errors)) {
        $nisDB     = mysqli_real_escape_string($conn, $nis);
        $namaDB    = mysqli_real_escape_string($conn, $nama);
        $kelasDB   = mysqli_real_escape_string($conn, $kelas);
        $jurusanDB = mysqli_real_escape_string($conn, $jurusan);

        $sql = "UPDATE siswa
                SET nis='$nisDB', nama='$namaDB', kelas='$kelasDB', jurusan='$jurusanDB'
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            redirect('daftar.php', "✅ Data siswa $nama berhasil diperbarui!");
        } else {
            $errors[] = 'Gagal memperbarui data: ' . mysqli_error($conn);
        }
    }
}

// Daftar pilihan
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
    <h2>✏️ Edit Data Siswa</h2>
    <p class="subtitle">
        Memperbarui data: <strong><?= bersihkan($siswa['nama']) ?></strong>
        (NIS: <?= bersihkan($siswa['nis']) ?>)
    </p>

    <!-- Error -->
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

    <!-- FORM EDIT -->
    <form method="POST" action="edit.php?id=<?= $id ?>">

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
            <button type="submit" class="btn btn-primary">💾 Perbarui Data</button>
            <a href="daftar.php" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>

<?php include 'includes/footer.php'; ?>
