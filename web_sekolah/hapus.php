<?php

require 'config/db.php';
require 'functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('daftar.php', '❌ ID tidak valid.', 'danger');
}

$id = (int) $_GET['id'];

$queryAmbil = "SELECT nama FROM siswa WHERE id = $id LIMIT 1";
$hasil      = mysqli_query($conn, $queryAmbil);

if (mysqli_num_rows($hasil) === 0) {
    redirect('daftar.php', '❌ Data tidak ditemukan.', 'danger');
}

$siswa = mysqli_fetch_assoc($hasil);
$nama  = $siswa['nama'];

$queryHapus = "DELETE FROM siswa WHERE id = $id";

if (mysqli_query($conn, $queryHapus)) {
    redirect('daftar.php', "🗑️ Data siswa $nama berhasil dihapus.");
} else {
    redirect('daftar.php', '❌ Gagal menghapus data: ' . mysqli_error($conn), 'danger');
}
?>
