<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

/*
|--------------------------------------------------------------------------
| Validasi ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {

    header("Location: feature.php");
    exit;

}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| Cek Data Feature
|--------------------------------------------------------------------------
*/

$result = mysqli_query(
    $conn,
    "SELECT * FROM features WHERE id = $id"
);

if (mysqli_num_rows($result) == 0) {

    header("Location: feature.php?error=notfound");
    exit;

}

/*
|--------------------------------------------------------------------------
| Hapus Data
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM features WHERE id = $id"
);

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location: feature.php?success=delete");
exit;

?>