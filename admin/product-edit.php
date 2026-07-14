<?php
/**
 * admin/product-edit.php
 * Skeleton implementation for product edit.
 * NOTE: This file is generated to be completed in subsequent iterations if needed.
 */

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: products.php");
    exit;
}

$productId = (int)$_GET["id"];

$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $productId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: products.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Inisialisasi data produk
|--------------------------------------------------------------------------
*/

$name = $product["name"];
$category = $product["category"];
$description = $product["description"];
$price = $product["price"];
$originalPrice = $product["original_price"];
$status = $product["status"];

$errors = [];

$name = $product["name"];
$category = $product["category"];
$description = $product["description"];
$price = $product["price"];
$originalPrice = $product["original_price"];
$status = $product["status"];

if (!$product) {
    header("Location: products.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = (int) ($_POST["price"] ?? 0);

    $originalPrice = ($_POST["original_price"] === "")
        ? null
        : (int) $_POST["original_price"];

    $status = $_POST["status"] ?? $product["status"];

    if ($name === "") {
        $errors[] = "Nama produk wajib diisi.";
    }

    if ($category === "") {
        $errors[] = "Kategori wajib diisi.";
    }

    if ($price <= 0) {
        $errors[] = "Harga tidak valid.";
    }

    $imagePath = $product["image"];
    $newImageUploaded = false;

    if (
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] === UPLOAD_ERR_OK
    ) {

        if (!is_uploaded_file($_FILES["image"]["tmp_name"])) {
            $errors[] = "Upload gambar tidak valid.";
        } else {

            $imageInfo = getimagesize($_FILES["image"]["tmp_name"]);

            if ($imageInfo === false) {
                $errors[] = "File harus berupa gambar.";
            }

            $allowedExtensions = [
                "jpg",
                "jpeg",
                "png",
                "webp"
            ];

            $extension = strtolower(
                pathinfo(
                    $_FILES["image"]["name"],
                    PATHINFO_EXTENSION
                )
            );

            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "Format gambar tidak didukung.";
            }

            if ($_FILES["image"]["size"] > (2 * 1024 * 1024)) {
                $errors[] = "Ukuran gambar maksimal 2 MB.";
            }

            if (!$errors) {

                $uploadDirectory = __DIR__ . "/uploads/products/";

                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }

                $imageName = uniqid("product_", true) . "." . $extension;

                $destination = $uploadDirectory . $imageName;

                if (
                    move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $destination
                    )
                ) {

                    $imagePath = "admin/uploads/products/" . $imageName;

                    $newImageUploaded = true;

                } else {

                    $errors[] = "Upload gambar gagal.";

                }

            }

        }

    }

    if (!$errors) {

        mysqli_begin_transaction($conn);

        try {

            $sql = "
                UPDATE products
                SET
                    name = ?,
                    category = ?,
                    description = ?,
                    image = ?,
                    price = ?,
                    original_price = ?,
                    status = ?
                WHERE id = ?
            ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssissi",
                $name,
                $category,
                $description,
                $imagePath,
                $price,
                $originalPrice,
                $status,
                $productId
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Update database gagal.");
            }

            mysqli_commit($conn);

            if (
                $newImageUploaded &&
                !empty($product["image"])
            ) {

                $oldImage = dirname(__DIR__) . "/" . $product["image"];

                if (
                    file_exists($oldImage) &&
                    is_file($oldImage)
                ) {
                    unlink($oldImage);
                }

            }

            header("Location: products.php?success=update");

            exit;

        } catch (Exception $e) {

            mysqli_rollback($conn);

            if ($newImageUploaded) {

                $uploadedFile = dirname(__DIR__) . "/" . $imagePath;

                if (
                    file_exists($uploadedFile) &&
                    is_file($uploadedFile)
                ) {
                    unlink($uploadedFile);
                }

            }

            $errors[] = "Terjadi kesalahan saat menyimpan data.";

        }

    }

}

?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Produk</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-slate-100">
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-xl shadow p-8">
<h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

<?php if ($errors): ?>
<div class="bg-red-100 text-red-700 p-4 rounded mb-6">
<?php foreach($errors as $e): ?>
<div><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<form
    method="POST"
    enctype="multipart/form-data">

<div class="grid grid-cols-2 gap-4">
<div>
<label>Nama Produk</label>
<input class="w-full border p-2 rounded" type="text" name="name" value="<?= htmlspecialchars($name) ?>">
</div>

<div>
<label>Kategori</label>
<input class="w-full border p-2 rounded" type="text" name="category" value="<?= htmlspecialchars($category) ?>">
</div>

<div>
<label>Harga</label>
<input class="w-full border p-2 rounded" type="number" name="price" value="<?= htmlspecialchars($price) ?>">

<div>
<label>Harga Coret</label>
<input class="w-full border p-2 rounded" type="number" name="original_price" value="<?= htmlspecialchars($originalPrice) ?>">
</div>

<div>
<label>Status</label>

<select
    name="status"
    class="w-full border p-2 rounded">

    <option
        value="active"
        <?= $status == "active" ? "selected" : "" ?>>
        Active
    </option>

    <option
        value="inactive"
        <?= $status == "inactive" ? "selected" : "" ?>>
        Inactive
    </option>

</select>
</div>

</div>

<div class="mt-4">

<label>Deskripsi</label>

<textarea
class="w-full border p-2 rounded"
rows="5"
name="description"><?= htmlspecialchars($description) ?></textarea>

</div>

<div class="mt-4">
<label>Ganti Gambar (Opsional)</label>
<input type="file" name="image">
</div>

<div class="mt-6 flex gap-3">
<button class="bg-sky-600 text-white px-5 py-2 rounded" type="submit">Simpan Perubahan</button>
<a class="bg-slate-300 px-5 py-2 rounded" href="products.php">Batal</a>
</div>
</form>
</div>
</body>
</html>
