<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' — ' : '' ?>Data Siswa SMK Nusantara</title>
    <link rel="stylesheet" href="<?= $cssPath ?? '' ?>css/style.css">
</head>
<body>

<nav>
    <a href="<?= $basePath ?? '' ?>index.php" <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : '' ?>>🏠 Home</a>
    <a href="<?= $basePath ?? '' ?>daftar.php" <?= (basename($_SERVER['PHP_SELF']) == 'daftar.php') ? 'class="active"' : '' ?>>📋 Daftar Siswa</a>
    <a href="<?= $basePath ?? '' ?>tambah.php" <?= (basename($_SERVER['PHP_SELF']) == 'tambah.php') ? 'class="active"' : '' ?>>➕ Tambah Data</a>
</nav>

<header>
    <h1>📚 SMK </h1>
    <p>Sistem Informasi Data Siswa</p>
</header>
