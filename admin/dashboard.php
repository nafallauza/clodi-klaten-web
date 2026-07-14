<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

/*
|--------------------------------------------------------------------------
| Statistik Dashboard
|--------------------------------------------------------------------------
*/

$productResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$productData = mysqli_fetch_assoc($productResult);
$totalProducts = $productData['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | Clodi Klaten Babyshop</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->

    <aside class="w-72 bg-white shadow-lg">

        <div class="p-8 border-b">

            <h2 class="text-2xl font-bold text-sky-600">
                Clodi Admin
            </h2>

            <p class="text-sm text-slate-500 mt-1">
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

    <!-- CONTENT -->

    <main class="flex-1 p-10">

        <div class="flex justify-between items-center mb-10">

            <div>

                <h1 class="text-3xl font-bold">

                    Dashboard

                </h1>

                <p class="text-slate-500 mt-2">

                    Selamat datang,

                    <strong><?= htmlspecialchars($_SESSION['admin_name']); ?></strong>

                </p>

            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="card">

                <div class="text-slate-500">

                    Total Produk

                </div>

                <div class="text-5xl font-bold text-sky-600 mt-3">

                    <?= $totalProducts; ?>

                </div>

            </div>

            <div class="card">

                <div class="text-slate-500">

                    Hero Section

                </div>

                <div class="text-2xl font-bold mt-3">

                    Aktif

                </div>

            </div>

            <div class="card">

                <div class="text-slate-500">

                    Status Website

                </div>

                <div class="text-2xl font-bold text-green-600 mt-3">

                    Online

                </div>

            </div>

        </div>

        <div class="card mt-8">

            <h2 class="text-xl font-bold mb-6">

                Menu Pengelolaan

            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                <a href="products.php"
                   class="border rounded-xl p-6 hover:bg-sky-50 transition">

                    <h3 class="font-bold text-lg">

                        Produk

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        Tambah, ubah dan hapus produk.

                    </p>

                </a>

                <a href="hero.php"
                   class="border rounded-xl p-6 hover:bg-sky-50 transition">

                    <h3 class="font-bold text-lg">

                        Hero

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        Kelola banner utama website.

                    </p>

                </a>

                <a href="testimonials.php"
                   class="border rounded-xl p-6 hover:bg-sky-50 transition">

                    <h3 class="font-bold text-lg">

                        Testimoni

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        Kelola testimoni pelanggan.

                    </p>

                </a>

                <a href="footer.php"
                   class="border rounded-xl p-6 hover:bg-sky-50 transition">

                    <h3 class="font-bold text-lg">

                        Footer

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        Kelola informasi kontak.

                    </p>

                </a>

            </div>

        </div>

    </main>

</div>

</body>

</html>