<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

/*
|--------------------------------------------------------------------------
| Ambil Data Footer
|--------------------------------------------------------------------------
*/

$result = mysqli_query(
    $conn,
    "SELECT * FROM footer LIMIT 1"
);

$footer = mysqli_fetch_assoc($result);

if (!$footer) {
    die("Data footer tidak ditemukan.");
}

/*
|--------------------------------------------------------------------------
| Update Footer
|--------------------------------------------------------------------------
*/

if (isset($_POST['update'])) {

    $address = mysqli_real_escape_string(
        $conn,
        trim($_POST['address'])
    );

    $phone = mysqli_real_escape_string(
        $conn,
        trim($_POST['phone'])
    );

    $email = mysqli_real_escape_string(
        $conn,
        trim($_POST['email'])
    );

    $facebook = mysqli_real_escape_string(
        $conn,
        trim($_POST['facebook'])
    );

    $instagram = mysqli_real_escape_string(
        $conn,
        trim($_POST['instagram'])
    );

    $youtube = mysqli_real_escape_string(
        $conn,
        trim($_POST['youtube'])
    );

    $tiktok = mysqli_real_escape_string(
        $conn,
        trim($_POST['tiktok'])
    );

    $copyright = mysqli_real_escape_string(
        $conn,
        trim($_POST['copyright'])
    );

    mysqli_query($conn,"
        UPDATE footer
        SET
            address='$address',
            phone='$phone',
            email='$email',
            facebook='$facebook',
            instagram='$instagram',
            youtube='$youtube',
            tiktok='$tiktok',
            copyright='$copyright',
            updated_at=NOW()
        WHERE id=".$footer['id']
    );

    header("Location: footer.php?success=update");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Footer | Clodi Klaten Babyshop</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
rel="stylesheet">

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="max-w-4xl mx-auto mt-10">

<div class="card">

<h1 class="text-3xl font-bold mb-2">

Edit Footer

</h1>

<p class="text-slate-500 mb-8">

Perbarui informasi footer website.

</p>

<form method="POST">

<div class="grid md:grid-cols-2 gap-6">

<div>

<label>

Alamat

</label>

<textarea
name="address"
rows="4"
required><?= htmlspecialchars($footer['address']); ?></textarea>

</div>

<div>

<label>

WhatsApp

</label>

<input
type="text"
name="phone"
value="<?= htmlspecialchars($footer['phone']); ?>"
required>

</div>

<div>

<label>

Email

</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($footer['email']); ?>"
required>

</div>

<div>

<label>

Instagram

</label>

<input
type="url"
name="instagram"
value="<?= htmlspecialchars($footer['instagram']); ?>">

</div>

<div>

<label>

Facebook

</label>

<input
type="url"
name="facebook"
value="<?= htmlspecialchars($footer['facebook']); ?>">

</div>

<div>

<label>

YouTube

</label>

<input
type="url"
name="youtube"
value="<?= htmlspecialchars($footer['youtube']); ?>">

</div>

<div>

<label>

TikTok

</label>

<input
type="url"
name="tiktok"
value="<?= htmlspecialchars($footer['tiktok']); ?>">

</div>

<div>

<label>

Copyright

</label>

<input
type="text"
name="copyright"
value="<?= htmlspecialchars($footer['copyright']); ?>">

</div>

</div>

<div class="mt-8 flex gap-3">

<button
type="submit"
name="update"
class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

<i class="fas fa-save"></i> Simpan Perubahan

</button>

<a
href="footer.php"
class="bg-slate-300 hover:bg-slate-400 px-6 py-3 rounded-xl">

← Kembali

</a>

</div>

</form>

</div>

</div>

</body>

</html>