<?php
/**
 * ---------------------------------------------------------
 * Konfigurasi Database
 * Clodi Klaten Babyshop CMS
 * ---------------------------------------------------------
 */

$host = getenv("MYSQLHOST") ?: "localhost";
$username = getenv("MYSQLUSER") ?: "root";
$password = getenv("MYSQLPASSWORD") ?: "";
$database = getenv("MYSQLDATABASE") ?: "clodi_babyshop";
$port = getenv("MYSQLPORT") ?: 3306;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");