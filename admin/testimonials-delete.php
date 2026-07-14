<?php

require_once "../config/database.php";
require_once "../config/auth.php";

requireLogin();

if(!isset($_GET['id'])){

    header("Location: testimonials.php");
    exit;

}

$id = (int) $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM testimonials WHERE id=$id"
);

$testimonials = mysqli_fetch_assoc($result);

if(!$testimonials){

    header("Location: testimonials.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Hapus Foto
|--------------------------------------------------------------------------
*/

if(
    !empty($testimonials['photo']) &&
    $testimonials['photo'] != "assets/img/default-user.png"
){

    $photoPath = "../".$testimonials['photo'];

    if(file_exists($photoPath)){

        unlink($photoPath);

    }

}

/*
|--------------------------------------------------------------------------
| Hapus Database
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM testimonials WHERE id=$id"
);

header("Location: testimonials.php?success=delete");
exit;

?>