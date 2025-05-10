<?php
session_start();
include "../config_process/config.php";

$id_pesanan = (int) $_POST['id_pesanan'];
$status = $_POST['status'];

$sqlStatus = "UPDATE pesanan SET status_pesanan = '$status' WHERE id_pesanan = $id_pesanan";
mysqli_query($conn, $sqlStatus);

header("Location: index.php");
exit; // Kembali ke halaman admin