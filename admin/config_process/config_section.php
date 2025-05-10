<?php

if (isset($_GET['section'])) {
    if ($_GET['section'] == 'produk') {
        $active1 = 'active';
        $active2 = '';
        $active3 = '';

        include 'section/section_produk.php';
    } else if ($_GET['section'] == 'user') {
        $active1 = '';
        $active2 = 'active';
        $active3 = '';

        include 'section/section_user.php';
    } else if ($_GET['section'] == 'pesanan') {
        $active1 = '';
        $active2 = '';
        $active3 = 'active';

        include 'section/section_pesanan.php';
    } else {
        $active1 = 'active';
        $active2 = '';
        $active3 = '';
        include 'section/section_produk.php';
    }
} else {
    $active1 = 'active';
    $active2 = '';
    $active3 = '';
    include 'section/section_produk.php';
}
