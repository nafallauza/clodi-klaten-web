<?php

require_once "../config/database.php";
require_once "../config/auth.php";

redirectIfLogin();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username == "" || $password == "") {

        $error = "Username dan Password wajib diisi.";

    } else {

        $query = mysqli_query(
            $conn,
            "SELECT * FROM admins WHERE username='$username' LIMIT 1"
        );

        if (mysqli_num_rows($query) > 0) {

            $admin = mysqli_fetch_assoc($query);

            if (password_verify($password, $admin['password'])) {

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['fullname'];

                header("Location: dashboard.php");
                exit;

            } else {

                $error = "Password salah.";

            }

        } else {

            $error = "Username tidak ditemukan.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md rounded-xl shadow-lg p-8">

<h1 class="text-3xl font-bold text-center mb-2">
Clodi Klaten Babyshop
</h1>

<p class="text-center text-gray-500 mb-8">
Dashboard Admin
</p>

<?php if($error != ""): ?>

<div class="bg-red-100 text-red-600 p-3 rounded mb-5">

<?= $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-4">

<label class="block mb-2 font-medium">

Username

</label>

<input
type="text"
name="username"
class="w-full border rounded-lg p-3 focus:outline-none focus:ring focus:ring-blue-300"
required>

</div>

<div class="mb-6">

<label class="block mb-2 font-medium">

Password

</label>

<input
type="password"
name="password"
class="w-full border rounded-lg p-3 focus:outline-none focus:ring focus:ring-blue-300"
required>

</div>

<button
type="submit"
class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">

Login

</button>

</form>

</div>

</div>

</body>

</html>