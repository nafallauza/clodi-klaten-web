<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

/**
 * Validasi ID
 */
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: products.php?error=invalid");
    exit;
}

$productId = (int) $_GET['id'];

/**
 * Ambil data produk
 */
$sql = "SELECT image FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $productId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$product) {
    header("Location: products.php?error=notfound");
    exit;
}

/**
 * Mulai transaksi
 */
mysqli_begin_transaction($conn);

try {

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $productId);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Gagal menghapus produk.");
    }

    mysqli_stmt_close($stmt);

    mysqli_commit($conn);

    /**
     * Hapus file gambar setelah database berhasil dihapus
     */
    if (!empty($product['image'])) {

        $imagePath = dirname(__DIR__) . "/" . $product['image'];

        if (file_exists($imagePath) && is_file($imagePath)) {
            unlink($imagePath);
        }

    }

    header("Location: products.php?success=delete");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    header("Location: products.php?error=delete");
    exit;

}