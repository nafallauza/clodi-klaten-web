<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

if(isset($_POST['save'])){

    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $icon = mysqli_real_escape_string($conn,$_POST['icon']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    mysqli_query($conn,"
        INSERT INTO features
        (title,description,icon,status)
        VALUES
        ('$title','$description','$icon','$status')
    ");

    header("Location: feature.php?success=create");
    exit;
}

?>
<?php
require_once "layout/header.php";
?>

<div class="max-w-3xl mx-auto mt-10">

<div class="card">

<h1 class="text-3xl font-bold mb-8">

Tambah Feature

</h1>

<form method="POST">

<div class="mb-6">

<label>Judul Feature</label>

<input
    type="text"
    name="title"
    required>

</div>

<div class="mb-6">

<label>Deskripsi</label>

<textarea
    name="description"
    rows="5"
    required></textarea>

</div>

<div class="mb-6">

<label>Icon</label>

<select name="icon">

<option value="fas fa-box">Box</option>
<option value="fas fa-tags">Tags</option>
<option value="fas fa-truck">Truck</option>
<option value="fas fa-headset">Headset</option>
<option value="fas fa-medal">Medal</option>
<option value="fas fa-shield-alt">Shield</option>
<option value="fas fa-star">Star</option>
<option value="fas fa-heart">Heart</option>
<option value="fas fa-gift">Gift</option>
<option value="fas fa-baby">Baby</option>

</select>

</div>

<div class="mb-8">

<label>Status</label>

<select name="status">

<option value="active">Active</option>
<option value="inactive">Inactive</option>

</select>

</div>

<?php if(isset($feature)): ?>

<button
type="submit"
name="update"
class="btn-primary">

Update Feature

</button>
<?php else: ?>

<button
type="submit"
name="save"
class="btn-primary">

Simpan Feature

</button>

<?php endif; ?>

<a
href="feature.php"
class="ml-3 bg-slate-300 px-6 py-3 rounded-xl">

Kembali

</a>

</form>

</div>

</div>
<?php
require_once "layout/footer.php";
?>