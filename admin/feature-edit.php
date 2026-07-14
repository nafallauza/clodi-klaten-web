<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

$id=(int)$_GET['id'];

$result=mysqli_query($conn,"SELECT * FROM features WHERE id=$id");

$feature=mysqli_fetch_assoc($result);

if(!$feature){

die("Data tidak ditemukan");

}

if(isset($_POST['update'])){

$title=mysqli_real_escape_string($conn,$_POST['title']);

$description=mysqli_real_escape_string($conn,$_POST['description']);

$icon=mysqli_real_escape_string($conn,$_POST['icon']);

$status=mysqli_real_escape_string($conn,$_POST['status']);

mysqli_query($conn,"
UPDATE features
SET
title='$title',
description='$description',
icon='$icon',
status='$status'
WHERE id=$id
");

header("Location: feature.php?success=update");

exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>Edit Feature</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="max-w-3xl mx-auto mt-10">

<div class="card">

<h1 class="text-3xl font-bold mb-8">

Edit Feature

</h1>

<form method="POST">

<div class="mb-6">

<label>Judul Feature</label>

<input
    type="text"
    name="title"
    value="<?= htmlspecialchars($feature['title']); ?>"
    required>

</div>

<div class="mb-6">

<label>Deskripsi</label>

<textarea
    name="description"
    rows="5"
    required><?= htmlspecialchars($feature['description']); ?></textarea>
</div>

<div class="mb-6">

<label>Icon</label>

<select name="icon">

    <option 
    value="fas fa-medal"
    <?= $feature['icon']=="fas fa-medal" ? "selected" : ""; ?>>
    Medal
    </option>

    <option 
    value="fas fa-truck">
    <?= $feature['icon']=="fas fa-truck" ? "selected" : ""; ?>>  
    Truck
    </option>

    <option 
    value="fas fa-shield-alt">
    <?= $feature['icon']=="fas fa-shield-alt" ? "selected" : ""; ?>>
    Shield
    </option>
    
    <option value="fas fa-star">
    <?= $feature['icon']=="fas fa-star" ? "selected" : ""; ?>>
    Star
    </option>
    
    <option value="fas fa-heart">
    <?= $feature['icon']=="fas fa-heart" ? "selected" : ""; ?>>
    Heart
    </option>

    <option value="fas fa-gift">
    <?= $feature['icon']=="fas fa-gift" ? "selected" : ""; ?>>
    Gift
    </option>
    
    <option value="fas fa-baby">
    <?= $feature['icon']=="fas fa-baby" ? "selected" : ""; ?>>
    Baby
    </option>

</select>

</div>

<div class="mb-8">

<label>Status</label>

<select name="status">

<option value="active"
<?= $feature['status']=="active" ? "selected" : ""; ?>>
    Active
</option>

<option value="inactive"
<?= $feature['status']=="inactive" ? "selected" : ""; ?>>
    Inactive
</option>

</select>

</div>

<button
type="submit"
name="update"
class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

Update Feature

</button>

<a
href="feature.php"
class="ml-3 bg-slate-300 px-6 py-3 rounded-xl">

Kembali

</a>

</form>

</div>

</div>

</body>

</html>