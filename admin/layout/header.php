<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Clodi Klaten Babyshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside class="w-72 bg-white shadow-lg flex-shrink-0">
        <div class="p-8 border-b">
            <h2 class="text-2xl font-bold text-sky-600">Clodi Admin</h2>
            <p class="text-sm text-slate-500 mt-1">Content Management System</p>
        </div>
        <div class="p-5 space-y-2">
            <a href="dashboard.php" class="sidebar-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie w-6"></i> Dashboard
            </a>
            <a href="products.php" class="sidebar-link <?= in_array($current_page, ['products.php', 'product-create.php', 'product-edit.php', 'product-delete.php']) ? 'active' : '' ?>">
                <i class="fas fa-box w-6"></i> Kelola Produk
            </a>
            <a href="hero.php" class="sidebar-link <?= $current_page == 'hero.php' ? 'active' : '' ?>">
                <i class="fas fa-image w-6"></i> Hero
            </a>
            <a href="navbar.php" class="sidebar-link <?= $current_page == 'navbar.php' ? 'active' : '' ?>">
                <i class="fas fa-compass w-6"></i> Navbar
            </a>
            <a href="feature.php" class="sidebar-link <?= in_array($current_page, ['feature.php', 'feature-create.php', 'feature-edit.php', 'feature-delete.php']) ? 'active' : '' ?>">
                <i class="fas fa-star w-6"></i> Feature
            </a>
            <a href="testimonials.php" class="sidebar-link <?= in_array($current_page, ['testimonials.php', 'testimonials-create.php', 'testimonials-edit.php', 'testimonials-delete.php']) ? 'active' : '' ?>">
                <i class="fas fa-comments w-6"></i> Testimoni
            </a>
            <a href="footer.php" class="sidebar-link <?= in_array($current_page, ['footer.php', 'footer-edit.php']) ? 'active' : '' ?>">
                <i class="fas fa-phone-alt w-6"></i> Footer
            </a>
            <hr class="my-3 border-slate-200">
            <a href="../index.php" target="_blank" class="sidebar-link">
                <i class="fas fa-globe w-6"></i> Lihat Landing Page
            </a>
            <a href="logout.php" class="sidebar-link">
                <i class="fas fa-sign-out-alt w-6 text-red-500"></i> Logout
            </a>
        </div>
    </aside>
    <!-- MAIN CONTENT -->
    <main class="flex-1 p-10 overflow-y-auto h-screen">
