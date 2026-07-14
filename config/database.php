<?php
/**
 * ---------------------------------------------------------
 * Konfigurasi Database
 * Clodi Klaten Babyshop CMS
 * ---------------------------------------------------------
 */

$host = "localhost";
$username = "root";
$password = "";
$database = "clodi_babyshop";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi database gagal : " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");