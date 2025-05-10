<?php
session_start();
include "config_process/config.php";

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

$id_pesanan = (int)$_GET['id'];

// Ambil data pesanan
$sqlPesanan = "SELECT * FROM pesanan WHERE id_pesanan = $id_pesanan AND id_user = {$_SESSION['user_id']}";
$query_pesanan = mysqli_query($conn, $sqlPesanan);
$pesanan = mysqli_fetch_assoc($query_pesanan);

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}

// Ambil item pesanan
$sqlItem = "SELECT detail_pesanan.*, produk.nama_produk, produk.gambar
FROM detail_pesanan JOIN produk ON detail_pesanan.id_produk = produk.id_produk 
WHERE detail_pesanan.id_pesanan = $id_pesanan";
$query_items = mysqli_query($conn, $sqlItem);

// Hitung total harga
$total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($query_items)) {
    $total += $row['harga'] * $row['jumlah'];
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>BeyourselF Product | Detail Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .info-section {
            margin-bottom: 18px;
            border: 1px solid lightgrey;
            padding: 0 20px;
            border-radius: 4px;
        }

        .bukti-transfer {
            max-width: 300px;
            margin-top: 10px;
        }

        .status-pending {
            color: #e67e22;
        }

        .status-diproses {
            color: #3498db;
        }

        .status-dikirim {
            color: #2ecc71;
        }

        .status-selesai {
            color: #27ae60;
        }

        .btn-kembali {
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            text-decoration: none;
            text-align: center;
        }

        .btn-kembali:hover {
            background: #45a049;
        }
    </style>
</head>

<body>
    <h1>Detail Pesanan #<?= $pesanan['id_pesanan'] ?></h1>
    <div class="container">
        <div class="info-section">
            <h3>Informasi Pesanan</h3>
            <p><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></p>
            <p><strong>Status:</strong>
                <span class="status-<?= str_replace('_', '-', $pesanan['status_pesanan']) ?>">
                    <?php
                    $status = [
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai'
                    ];
                    echo $status[$pesanan['status_pesanan']] ?? $pesanan['status_pesanan'];
                    ?>
                </span>
            </p>
            <p><strong>Total Item:</strong> <?= number_format($pesanan['total'], 0, ',', '.') ?> Barang</p>
            <p><strong>Alamat Pengiriman:</strong> <?= nl2br(htmlspecialchars($pesanan['alamat'])) ?></p>
        </div>

        <div class="info-section">
            <h3>Item Pesanan</h3>
            <table>
                <tr>
                    <th>Produk</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                        <td><img src="admin/uploads/<?= $item['gambar'] ?>" width="50"></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p><strong>Total Harga: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
        </div>

        <div style="margin-top: 40px;">
            <a href="index.php" class="btn-kembali">Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>