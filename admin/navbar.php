<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

$result = mysqli_query($conn, "SELECT * FROM navbar LIMIT 1");
$navbar = mysqli_fetch_assoc($result);

if (!$navbar) {

    mysqli_query($conn,"
        INSERT INTO navbar
        (logo, store_name)
        VALUES
        ('assets/img/logo.png','Clodi Klaten Babyshop')
    ");

    $result = mysqli_query($conn, "SELECT * FROM navbar LIMIT 1");
    $navbar = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {

    $store_name = mysqli_real_escape_string(
        $conn,
        $_POST['store_name']
    );

    $logo = "assets/img/logo.png";

    if (!empty($_FILES['logo']['name'])) {

        $ext = strtolower(pathinfo(
            $_FILES['logo']['name'],
            PATHINFO_EXTENSION
        ));

        $allowed = ['jpg','jpeg','png','webp'];

        if (in_array($ext,$allowed)) {

            $target = "../assets/img/logo.png";

            if(file_exists($target)){
                unlink($target);
            }

            if(move_uploaded_file($_FILES['logo']['tmp_name'], $target)){
            echo "Upload berhasil";
                }else{
                echo "Upload gagal";
            }
        }
    }

    mysqli_query($conn,"
        UPDATE navbar
        SET
            store_name='$store_name',
            logo='$logo'
        WHERE id=".$navbar['id']
    );

    header("Location: navbar.php?success=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Navbar | Clodi Klaten Babyshop</title>

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

            Kelola Navbar

        </h1>

        <p class="text-slate-500 mb-8">

            Pengaturan logo dan nama toko.

        </p>

        <div class="card">

<form method="POST" enctype="multipart/form-data">

    <?php if(isset($_GET['success'])): ?>

        <div class="mb-6 bg-green-100 text-green-700 p-4 rounded-xl">

            Navbar berhasil diperbarui.

        </div>

    <?php endif; ?>

    <div class="mb-6">

        <label>

            Nama Toko

        </label>

        <input
            type="text"
            name="store_name"
            value="<?= htmlspecialchars($navbar['store_name']); ?>">

    </div>

    <div class="mb-6">

        <label>

            Logo

        </label>

        <input
            type="file"
            name="logo">

    </div>

    <div class="mb-8">

        <img
            src="../assets/img/logo.png?<?= time(); ?>"
            class="w-36 rounded-lg border p-3 bg-white">

    </div>

    <button
        type="submit"
        name="update"
        class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl">

        Simpan Perubahan

    </button>

</form>

        </div>

    </main>

</div>

</body>

</html>
