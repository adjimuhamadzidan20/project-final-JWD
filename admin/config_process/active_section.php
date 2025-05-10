<?php

if (@$_GET['section'] == 'produk') {
    $active1 = 'active';
    $active2 = '';
    $active3 = '';
} else if (@$_GET['section'] == 'user') {
    $active1 = '';
    $active2 = 'active';
    $active3 = '';
} else if (@$_GET['section'] == 'pesanan') {
    $active1 = '';
    $active2 = '';
    $active3 = 'active';
} else {
    $active1 = 'active';
    $active2 = '';
    $active3 = '';
}
