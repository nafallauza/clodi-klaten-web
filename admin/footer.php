<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

$result = mysqli_query(
    $conn,
    "SELECT * FROM footer LIMIT 1"
);

$footer = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Footer | Clodi Klaten Babyshop</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="flex min-h-screen">

<aside class="w-72 bg-white shadow-lg">

<div class="p-8 border-b">

<h2 class="text-2xl font-bold text-sky-600">

Clodi Admin

</h2>

<p class="text-sm text-slate-500 mt-2">

Content Management System

</p>

</div>

        <div class="p-5 space-y-2">
            <a href="dashboard.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie w-6"></i>
                Dashboard
            </a>
            <a href="products.php" class="sidebar-link <?= in_array(basename($_SERVER['PHP_SELF']), ['products.php', 'product-create.php', 'product-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-box w-6"></i>
                Kelola Produk
            </a>
            <a href="hero.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'hero.php' ? 'active' : '' ?>">
                <i class="fas fa-image w-6"></i>
                Hero
            </a>
            <a href="navbar.php" class="sidebar-link <?= basename($_SERVER['PHP_SELF']) == 'navbar.php' ? 'active' : '' ?>">
                <i class="fas fa-compass w-6"></i>
                Navbar
            </a>
            <a href="feature.php" class="sidebar-link <?= in_array(basename($_SERVER['PHP_SELF']), ['feature.php', 'feature-create.php', 'feature-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-star w-6"></i>
                Feature
            </a>
            <a href="testimonials.php" class="sidebar-link <?= in_array(basename($_SERVER['PHP_SELF']), ['testimonials.php', 'testimonials-create.php', 'testimonials-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-comments w-6"></i>
                Testimoni
            </a>
            <a href="footer.php" class="sidebar-link <?= in_array(basename($_SERVER['PHP_SELF']), ['footer.php', 'footer-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-phone-alt w-6"></i>
                Footer
            </a>
            <hr class="my-3 border-slate-200">
            <a href="../index.php" target="_blank" class="sidebar-link">
                <i class="fas fa-globe w-6"></i>
                Lihat Landing Page
            </a>
            <a href="logout.php" class="sidebar-link">
                <i class="fas fa-sign-out-alt w-6 text-red-500"></i>
                Logout
            </a>
        </div>

    </aside>

<main class="flex-1 p-10">

<h1 class="text-3xl font-bold mb-2">

Kelola Footer

</h1>

<p class="text-slate-500 mb-8">

Kelola informasi kontak dan footer website.

</p>

<div class="card">

<div class="space-y-6">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>

<label>

Alamat

</label>

<textarea
rows="4"
readonly><?= htmlspecialchars($footer['address']); ?></textarea>

</div>

<div>

<label>

Nomor WhatsApp

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['phone']); ?>"
readonly>

</div>

<div>

<label>

Email

</label>

<input
type="email"
value="<?= htmlspecialchars($footer['email']); ?>"
readonly>

</div>

<div>

<label>

Instagram

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['instagram']); ?>"
readonly>

</div>

<div>

<label>

Facebook

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['facebook']); ?>"
readonly>

</div>

<div>

<label>

YouTube

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['youtube']); ?>"
readonly>

</div>

<div>

<label>

TikTok

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['tiktok']); ?>"
readonly>

</div>

</div>

<div class="mt-6">

<label>

Copyright

</label>

<input
type="text"
value="<?= htmlspecialchars($footer['copyright']); ?>"
readonly>

</div>

<div class="mt-8">

<div class="mt-8">

<a
href="footer-edit.php"
class="inline-block bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

<i class="fas fa-edit"></i> Edit Footer

</a>

</div>

</div>

</form>

</div>

</main>

</div>

</body>

</html>