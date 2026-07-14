<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

if(isset($_POST['save'])){

    $customer_name = mysqli_real_escape_string(
        $conn,
        $_POST['customer_name']
    );

    $comment = mysqli_real_escape_string(
        $conn,
        $_POST['comment']
    );

    $rating = mysqli_real_escape_string(
        $conn,
        $_POST['rating']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    $photo = "assets/img/default-user.png";

    if(!empty($_FILES['photo']['name'])){

        $ext = strtolower(
            pathinfo(
                $_FILES['photo']['name'],
                PATHINFO_EXTENSION
            )
        );

        $allowed = ['jpg','jpeg','png','webp'];

        if(in_array($ext,$allowed)){

            if(!is_dir("../uploads/testimonials")){
                mkdir("../uploads/testimonials",0777,true);
            }

            $filename = time().".".$ext;

            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../uploads/testimonials/".$filename
            );

            $photo = "uploads/testimonials/".$filename;

        }

    }

    mysqli_query($conn,"
        INSERT INTO testimonials
        (
            customer_name,
            rating,
            comment,
            status
        )
        VALUES
        (
            '$customer_name',
            '$rating',
            '$comment',
            '$status'
        )
    ");

    header("Location: testimonials.php?success=create");
    exit;

}

?>
<?php
require_once "layout/header.php";
?>

<div class="max-w-3xl mx-auto mt-10">

<div class="card">

<h1 class="text-3xl font-bold mb-8">

<?= isset($testimonials) ? "Edit Testimoni" : "Tambah Testimoni"; ?>

</h1>

<form
method="POST"
enctype="multipart/form-data">

<div class="mb-6">

<label>Nama Customer</label>

<input
type="text"
name="customer_name"
value="<?= isset($testimonials) ? htmlspecialchars($testimonials['customer_name']) : ''; ?>"
required>

</div>

<div class="mb-6">

<?php if(isset($testimonials)): ?>

<?php endif; ?>

</div>

<div class="mb-6">

<label>Rating</label>

<select
name="rating">

<option 
value="5"
    <?= isset($testimonials) && $testimonials['rating']==5 ? "selected" : ""; ?>>

    ★★★★★ (5)
</option>

<option 
value="4"
    <?= isset($testimonials) && $testimonials['rating']==4 ? "selected" : ""; ?>>

    ★★★★☆ (4)
</option>

<option value="3"<?= isset($testimonials) && $testimonials['rating']==3 ? "selected" : ""; ?>>★★★☆☆ (3)</option>

<option value="2"<?= isset($testimonials) && $testimonials['rating']==2 ? "selected" : ""; ?>>★★☆☆☆ (2)</option>

<option value="1"<?= isset($testimonials) && $testimonials['rating']==1 ? "selected" : ""; ?>>★☆☆☆☆ (1)</option>

</select>

</div>

<div class="mb-6">

<label>Komentar</label>

<textarea
name="comment"
rows="5"
required><?= isset($testimonials) ? htmlspecialchars($testimonials['comment']) : ''; ?></textarea>

</div>

<div class="mb-8">

<label>Status</label>

<select
name="status">

<option
value="active"
<?= isset($testimonials) && $testimonials['status']=="active" ? "selected" : ""; ?>>

Active

</option>

<option
value="inactive"
<?= isset($testimonials) && $testimonials['status']=="inactive" ? "selected" : ""; ?>>

Inactive

</option>

</select>

</div>

<?php if(isset($testimonials)): ?>

<button
type="submit"
name="update"
class="btn-primary">

Update Testimoni

</button>

<?php else: ?>

<button
type="submit"
name="save"
class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

Simpan Testimoni

</button>

<button
<?php endif; ?>
class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

Simpan Testimoni

</button>

<a
href="testimonials.php"
class="ml-3 bg-slate-300 px-6 py-3 rounded-xl">

Kembali

</a>

</form>

</div>

</div>
<?php
require_once "layout/footer.php";
?>