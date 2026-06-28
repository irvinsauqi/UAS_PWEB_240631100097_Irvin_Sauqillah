<?php

function bersihkan($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function formatTanggal($tanggal) {
    $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $ts  = strtotime($tanggal);
    $hari  = date('d', $ts);
    $bulan = $namaBulan[(int)date('m', $ts)];
    $tahun = date('Y', $ts);
    return "$hari $bulan $tahun";
}


function hitungSiswaPerKelas($conn, $kelas) {
    $kelas = mysqli_real_escape_string($conn, $kelas);
    $query = "SELECT COUNT(*) AS total FROM siswa WHERE kelas = '$kelas'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return (int) $row['total'];
}

function cekNISDuplikat($conn, $nis, $excludeId = null) {
    $nis = mysqli_real_escape_string($conn, $nis);
    $query = "SELECT id FROM siswa WHERE nis = '$nis'";
    if ($excludeId !== null) {
        $query .= " AND id != " . (int)$excludeId;
    }
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function redirect($url, $pesan = '', $tipe = 'success') {
    if ($pesan !== '') {
        $sep = strpos($url, '?') === false ? '?' : '&';
        $url .= $sep . 'msg=' . urlencode($pesan) . '&tipe=' . $tipe;
    }
    header("Location: $url");
    exit;
}


function tampilkanAlert() {
    if (isset($_GET['msg']) && $_GET['msg'] !== '') {
        $msg  = bersihkan($_GET['msg']);
        $tipe = (isset($_GET['tipe']) && $_GET['tipe'] === 'danger') ? 'danger' : 'success';
        echo "<div class=\"alert alert-$tipe\">$msg</div>";
    }
}
?>
