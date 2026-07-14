<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

$errors = [];

$name = "";
$category = "";
$description = "";
$price = "";
$original_price = "";
$rating = 5.0;
$status = "active";
$is_sale = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $category = trim($_POST["category"]);
    $description = trim($_POST["description"]);
    $price = trim($_POST["price"]);
    $original_price = trim($_POST["original_price"]);
    $rating = (float) $_POST["rating"];
    $status = $_POST["status"];
    $is_sale = isset($_POST["is_sale"]) ? 1 : 0;

    /*
    |--------------------------------------------------------------------------
    | VALIDASI INPUT
    |--------------------------------------------------------------------------
    */

    if ($name === "") {
        $errors[] = "Nama produk wajib diisi.";
    }

    if ($category === "") {
        $errors[] = "Kategori wajib diisi.";
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors[] = "Harga produk tidak valid.";
    }

    if ($original_price !== "" && !is_numeric($original_price)) {
        $errors[] = "Harga coret tidak valid.";
    }

    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating harus antara 1 - 5.";
    }

    if (
        $status !== "active" &&
        $status !== "inactive"
    ) {
        $errors[] = "Status tidak valid.";
    }

    if (
        !isset($_FILES["image"]) ||
        $_FILES["image"]["error"] != UPLOAD_ERR_OK
    ) {
        $errors[] = "Gambar produk wajib dipilih.";
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI GAMBAR
    |--------------------------------------------------------------------------
    */

    if (count($errors) == 0) {

        $allowedMime = [

            "image/jpeg",
            "image/png",
            "image/webp"

        ];

        $allowedExt = [

            "jpg",
            "jpeg",
            "png",
            "webp"

        ];

        $maxSize = 2 * 1024 * 1024;

        $fileMime = mime_content_type(
            $_FILES["image"]["tmp_name"]
        );

        $extension = strtolower(

            pathinfo(

                $_FILES["image"]["name"],

                PATHINFO_EXTENSION

            )

        );

        if (!in_array($fileMime, $allowedMime)) {

            $errors[] = "Format gambar tidak didukung.";

        }

        if (!in_array($extension, $allowedExt)) {

            $errors[] = "Ekstensi file tidak didukung.";

        }

        if ($_FILES["image"]["size"] > $maxSize) {

            $errors[] = "Ukuran gambar maksimal 2 MB.";

        }

    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA
    |--------------------------------------------------------------------------
    */

    if (count($errors) == 0) {

        $uploadDir = "uploads/products/";

        if (!is_dir($uploadDir)) {

            mkdir($uploadDir, 0777, true);

        }

        $newFilename =
            uniqid("product_", true) .
            "." .
            $extension;

        $uploadPath =
            $uploadDir .
            $newFilename;

        if (

            move_uploaded_file(

                $_FILES["image"]["tmp_name"],

                $uploadPath

            )

        ) {

            $imageDatabase =
                "uploads/products/" .
                $newFilename;

            $originalPriceValue =
                ($original_price === "")
                ? null
                : (int) $original_price;

            $stmt = mysqli_prepare(

                $conn,

                "INSERT INTO products
                (
                    name,
                    category,
                    description,
                    image,
                    price,
                    original_price,
                    rating,
                    is_sale,
                    status
                )
                VALUES
                (
                    ?,?,?,?,?,?,?,?,?
                )"

            );

            mysqli_stmt_bind_param(

                $stmt,

                "ssssiidis",

                $name,
                $category,
                $description,
                $imageDatabase,
                $price,
                $originalPriceValue,
                $rating,
                $is_sale,
                $status

            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: products.php");

                exit;

            } else {

                if (file_exists($uploadPath)) {

                    unlink($uploadPath);

                }

                $errors[] =
                    "Gagal menyimpan data ke database.";

            }

        } else {

            $errors[] =
                "Upload gambar gagal.";

        }

    }

}

?>
<?php
require_once "layout/header.php";
?>

<div class="card">

<h1 class="text-3xl font-bold mb-8">

Tambah Produk

</h1>

<?php

if(count($errors)>0){

echo "<div class='error'>";

foreach($errors as $error){

echo $error."<br>";

}

echo "</div>";

}

?>

<form
method="POST"
enctype="multipart/form-data">

<div class="grid md:grid-cols-2 gap-6">

<div>

<label>Nama Produk</label>

<input class="w-full"
type="text"
name="name"
value="<?= htmlspecialchars($name) ?>">

</div>

<div>

<label>Kategori</label>

<input class="w-full"
type="text"
name="category"
value="<?= htmlspecialchars($category) ?>">

</div>

<div>

<label>Harga</label>

<input class="w-full"
type="number"
name="price"
value="<?= htmlspecialchars($price) ?>">

</div>

<div>

<label>Harga Coret</label>

<input class="w-full"
type="number"
name="original_price"
value="<?= htmlspecialchars($original_price) ?>">

</div>

<div>

<label>Rating</label>

<select name="rating">

<?php

for($i=1;$i<=5;$i++){

?>

<option
value="<?= $i ?>"
<?= ($rating==$i) ? "selected":"" ?>>

<?= $i ?>

</option>

<?php

}

?>

</select>

</div>

<div>

<label>Status</label>

<select name="status">

<option
value="active"
<?= $status=="active"?"selected":"" ?>>

Active

</option>

<option
value="inactive"
<?= $status=="inactive"?"selected":"" ?>>

Inactive

</option>

</select>

</div>

</div>

<div class="mt-6">

<label>Deskripsi</label>

<textarea
rows="5"
name="description"><?= htmlspecialchars($description) ?></textarea>

</div>

<div class="mt-6">

<label>Upload Gambar</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.webp">

</div>

<div class="mt-6">

<label>

<input
type="checkbox"
name="is_sale"
value="1"
<?= $is_sale ? "checked" : "" ?>>

Produk Sedang Sale

</label>

</div>

<div class="mt-8">

<button class="btn-primary" type="submit">
<i class="fas fa-save"></i> Simpan Produk
</button>

<a
href="products.php"
class="cancel">

Batal

</a>

</div>

</form>

</div>

<?php
require_once "layout/footer.php";
?>