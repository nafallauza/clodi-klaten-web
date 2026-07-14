<?php
require_once "config/database.php";

echo "<h1>Menginstall Database...</h1>";

$sqlFile = "database/clodi.sql";
if (!file_exists($sqlFile)) {
    die("File database/clodi.sql tidak ditemukan.");
}

$sql = file_get_contents($sqlFile);

if (mysqli_multi_query($conn, $sql)) {
    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
    
    echo "<h2 style='color:green;'>Instalasi Database Berhasil! 🎉</h2>";
    echo "<p>Silakan hapus file install.php ini untuk alasan keamanan.</p>";
    echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
} else {
    echo "<h2 style='color:red;'>Gagal menginstall database:</h2>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}
