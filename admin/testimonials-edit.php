<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = mysqli_query($conn, "SELECT * FROM testimonials WHERE id = $id");
$testimonial = mysqli_fetch_assoc($result);

if (!$testimonial) {
    die("Data testimoni tidak ditemukan.");
}

if (isset($_POST['update'])) {

    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $comment       = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating        = (float) $_POST['rating'];
    $status        = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn,"
        UPDATE testimonials
        SET
            customer_name='$customer_name',
            comment='$comment',
            rating='$rating',
            status='$status'
        WHERE id=$id
    ");

    header("Location: testimonials.php?success=update");
    exit;
}

?>

?>
<?php
require_once "layout/header.php";
?>

<div class="max-w-3xl mx-auto mt-10">

<div class="card">

<h1 class="text-3xl font-bold mb-8">

Edit Testimoni

</h1>

<form method="POST">

<div class="mb-6">

<label>Nama Customer</label>

<input
type="text"
name="customer_name"
value="<?= htmlspecialchars($testimonial['customer_name']); ?>"
required>

</div>

<div class="mb-6">

<label>Rating</label>

<select name="rating">

<?php for($i=5;$i>=1;$i--): ?>

<option
value="<?= $i; ?>"
<?= $testimonial['rating']==$i ? "selected" : ""; ?>>

★★★★★ (<?= $i; ?>)

</option>

<?php endfor; ?>

</select>

</div>

<div class="mb-6">

<label>Komentar</label>

<textarea
name="comment"
rows="5"
required><?= htmlspecialchars($testimonial['comment']); ?></textarea>

</div>

<div class="mb-8">

<label>Status</label>

<select name="status">

<option
value="active"
<?= $testimonial['status']=="active" ? "selected" : ""; ?>>

Active

</option>

<option
value="inactive"
<?= $testimonial['status']=="inactive" ? "selected" : ""; ?>>

Inactive

</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn-primary">

Update Testimoni

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