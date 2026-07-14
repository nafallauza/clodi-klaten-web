<?php
require_once "../config/database.php";
require_once "../config/auth.php";
requireLogin();

$result=mysqli_query($conn,"SELECT * FROM hero LIMIT 1");
$hero=mysqli_fetch_assoc($result);

if(!$hero){
    mysqli_query($conn,"INSERT INTO hero(title,subtitle,image) VALUES('Judul Hero','Sub Judul','assets/img/hero.png')");
    $result=mysqli_query($conn,"SELECT * FROM hero LIMIT 1");
    $hero=mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $subtitle=mysqli_real_escape_string($conn,$_POST['subtitle']);
    $image='assets/img/hero.png';

    if(!empty($_FILES['image']['name'])){
        $ext=strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        if(in_array($ext,['jpg','jpeg','png','webp'])){
            $target='../assets/img/hero.png';
            if(file_exists($target)){ unlink($target); }
            move_uploaded_file($_FILES['image']['tmp_name'],$target);
        }
    }

    mysqli_query($conn,"UPDATE hero SET title='$title', subtitle='$subtitle', image='$image' WHERE id=".$hero['id']);
    header('Location: hero.php?success=1');
    exit;
}

$result=mysqli_query($conn,"SELECT * FROM hero LIMIT 1");
$hero=mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang='id'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width,initial-scale=1.0'>
<title>Kelola Hero</title>
<script src='https://cdn.tailwindcss.com'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class='bg-slate-100'>
<div class='max-w-4xl mx-auto mt-10 bg-white rounded-xl shadow p-8'>
<h1 class='text-3xl font-bold mb-6'>Kelola Hero</h1>

<?php if(isset($_GET['success'])): ?>
<div class='bg-green-100 text-green-700 p-3 rounded mb-5'>Perubahan berhasil disimpan.</div>
<?php endif; ?>

<form method='POST' enctype='multipart/form-data' class='space-y-6'>
<div>
<label class='font-semibold'>Judul Hero</label>
<input type='text' name='title' value='<?= htmlspecialchars($hero['title']) ?>' class='w-full border rounded-xl px-4 py-3'>
</div>

<div>
<label class='font-semibold'>Sub Judul</label>
<textarea name='subtitle' rows='5' class='w-full border rounded-xl px-4 py-3'><?= htmlspecialchars($hero['subtitle']) ?></textarea>
</div>

<div>
<label class='font-semibold'>Gambar Hero</label>
<input type='file' name='image' class='w-full border rounded-xl p-3'>
<img src='../assets/img/hero.png?<?= time() ?>' class='w-96 mt-4 rounded-xl border'>
</div>

<button type='submit' name='update' class='bg-sky-600 text-white px-6 py-3 rounded-xl hover:bg-sky-700'>
Simpan Perubahan
</button>

</form>
</div>
</body>
</html>
