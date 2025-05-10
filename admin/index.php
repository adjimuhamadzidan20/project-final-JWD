<?php
require "../config_process/config.php";
require "config_process/active_section.php";

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beyourself Product | Admin</title>

    <link rel="stylesheet" href="assets/bootstrap-5.3.6/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="head-title d-flex mt-4 mb-3 justify-content-between align-items-center">
            <h1 class="text-left fs-4">DASHBOARD ADMIN</h1>
            <div>
                <a href="logout.php" class="btn btn-primary btn-sm" onclick="return confirm('Anda yakin?')">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link text-dark <?= $active1; ?>" aria-current="page" href="index.php?section=produk">Data Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark <?= $active2; ?>" aria-current="page" href="index.php?section=user">Data User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark <?= $active3; ?>" aria-current="page" href="index.php?section=pesanan">Data Pesanan</a>
            </li>
        </ul>

        <div class="row">
            <?php include 'config_process/config_section.php' ?>
        </div>
    </div>

    <br><br><br><br>

    <script src="assets/bootstrap-5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>