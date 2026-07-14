<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Fungsi Mengecek Login
|--------------------------------------------------------------------------
*/

function isLogin()
{
    return isset($_SESSION['admin_id']);
}

/*
|--------------------------------------------------------------------------
| Redirect jika belum login
|--------------------------------------------------------------------------
*/

function requireLogin()
{
    if (!isLogin()) {
        header("Location: login.php");
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Redirect jika sudah login
|--------------------------------------------------------------------------
*/

function redirectIfLogin()
{
    if (isLogin()) {
        header("Location: dashboard.php");
        exit;
    }
}