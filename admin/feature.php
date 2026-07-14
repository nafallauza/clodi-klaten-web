<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

/*
|--------------------------------------------------------------------------
| Ambil Data Feature
|--------------------------------------------------------------------------
*/

$features = mysqli_query(
    $conn,
    "SELECT * FROM features ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Feature | Clodi Klaten Babyshop</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="assets/css/admin.css">

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

<div class="flex justify-between items-center mb-8">

<div>

<h1 class="text-3xl font-bold">

Kelola Feature

</h1>

<p class="text-slate-500 mt-2">

Kelola Feature Landing Page.

</p>

<?php if(isset($_GET['success'])): ?>

<div class="mt-4 p-4 rounded-lg bg-green-100 text-green-700">

<?php

switch($_GET['success']){

case 'create':
echo "Feature berhasil ditambahkan.";
break;

case 'update':
echo "Feature berhasil diperbarui.";
break;

case 'delete':
echo "Feature berhasil dihapus.";
break;

}

?>

</div>

<?php endif; ?>

</div>

<a
href="feature-create.php"
class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-xl font-semibold">

<i class="fas fa-plus"></i> Tambah Feature

</a>

</div>

<div class="card">

<div class="overflow-x-auto">

<table>

<thead>

<tr>

<th>No</th>

<th>Icon</th>

<th>Judul</th>

<th>Deskripsi</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

if(mysqli_num_rows($features)==0):

?>

<tr>

<td colspan="6" class="text-center py-10 text-slate-500">

Belum ada Feature.

</td>

</tr>

<?php

else:

while($row=mysqli_fetch_assoc($features)):

?>

<tr>

<td><?= $no++; ?></td>

<td class="text-center">

    <i class="<?= htmlspecialchars($row['icon']); ?> text-2xl text-sky-500"></i>

</td>

<td>

<?= htmlspecialchars($row['title']); ?>

</td>

<td>

<?= htmlspecialchars($row['description']); ?>

</td>

<td>

<?php if($row['status']=="active"): ?>

<span class="badge badge-active">

Active

</span>

<?php else: ?>

<span class="badge badge-inactive">

Inactive

</span>

<?php endif; ?>

</td>

<td>

<div class="flex gap-2">

<a
href="feature-edit.php?id=<?= $row['id']; ?>"
class="bg-amber-400 hover:bg-amber-500 text-white px-4 py-2 rounded-lg">

Edit

</a>

<a
href="feature-delete.php?id=<?= $row['id']; ?>"
onclick="return confirm('Yakin ingin menghapus feature ini?');"
class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

Hapus

</a>

</div>

</td>

</tr>

<?php

endwhile;

endif;

?>

</tbody>

</table>

</div>

</div>

</main>

</div>

</body>

</html>