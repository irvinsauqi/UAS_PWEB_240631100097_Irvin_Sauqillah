<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_sekolah');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('<div style="font-family:sans-serif;padding:30px;color:#721c24;background:#f8d7da;border:1px solid #f5c6cb;border-radius:8px;margin:20px;">
        <strong>Koneksi Gagal!</strong><br>
        Error: ' . mysqli_connect_error() . '<br><br>
        Pastikan:<br>
        1. MySQL / XAMPP aktif<br>
        2. Database <code>db_sekolah</code> sudah dibuat (jalankan <code>database.sql</code>)<br>
        3. Username & password benar di <code>config/db.php</code>
    </div>');
}

mysqli_set_charset($conn, 'utf8');
?>
