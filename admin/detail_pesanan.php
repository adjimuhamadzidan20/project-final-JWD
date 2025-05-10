<?php
session_start();
include "../config_process/config.php";

$id_pesanan = (int)$_GET['id'];

// Ambil data pesanan + bukti transfer
$sqlPesanan =  "SELECT pesanan.*, user.username FROM pesanan JOIN user 
ON pesanan.id_user = user.id_user WHERE pesanan.id_pesanan = $id_pesanan";

$query_pesanan = mysqli_query($conn, $sqlPesanan);
$pesanan = mysqli_fetch_assoc($query_pesanan);

// Ambil item pesanan
$sqlItems = "SELECT detail_pesanan.*, produk.nama_produk, produk.gambar FROM detail_pesanan
JOIN produk ON detail_pesanan.id_produk = produk.id_produk WHERE detail_pesanan.id_pesanan = $id_pesanan";

$query_items = mysqli_query($conn, $sqlItems);

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
            margin-bottom: 30px;
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
            font-weight: bold;
        }

        .status-verified {
            color: #2ecc71;
            font-weight: bold;
        }

        .btn-kembali,
        .btn-download {
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

        .btn-kembali:hover,
        .btn-download:hover {
            background: #45a049;
        }
    </style>
</head>

<body>
    <h1>Detail Pesanan #<?= $id_pesanan ?></h1>

    <div class="container">
        <!-- Informasi Utama Pesanan -->
        <div class="info-section">
            <h3>Informasi Pesanan</h3>
            <p><strong>Pelanggan:</strong> <?= $pesanan['username'] ?></p>
            <p><strong>Tanggal Pesan:</strong> <?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></p>
            <p><strong>Status:</strong>
                <span class="<?= ($pesanan['status_pesanan'] == 'menunggu_verifikasi') ? 'status-pending' : 'status-verified' ?>">
                    <?= ucfirst(str_replace('_', ' ', $pesanan['status_pesanan'])) ?>
                </span>
            </p>
            <p><strong>Total Item:</strong> <?= number_format($pesanan['total'], 0, ',', '.') ?> Barang</p>
            <p><strong>Alamat Pengiriman:</strong> <?= nl2br($pesanan['alamat']) ?></p>
        </div>

        <!-- Bukti Transfer -->
        <div class="info-section">
            <h3>Bukti Transfer</h3>
            <?php if ($pesanan['bukti_transfer']): ?>
                <img src="../bukti_transfer/<?= $pesanan['bukti_transfer'] ?>" alt="Bukti Transfer" class="bukti-transfer">
                <p style="margin-top: 30px; margin-bottom: 30px;">
                    <a href="../bukti_transfer/<?= $pesanan['bukti_transfer'] ?>" class="btn-download" download>Download Bukti</a>
                </p>
            <?php else: ?>
                <p>Belum mengupload bukti transfer.</p>
            <?php endif; ?>
        </div>

        <!-- Daftar Item Pesanan -->
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
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['nama_produk'] ?></td>
                        <td><img src="uploads/<?= $item['gambar'] ?>" width="50"></td>
                        <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td>Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p><strong>Total Harga: Rp <?= number_format($total, 0, ',', '.') ?></strong></p>
        </div>

        <div style="margin-top: 30px; margin-bottom: 50px;">
            <a href="index.php" class="btn-kembali">Kembali ke Dashboard</a>
        </div>
    </div>
</body>

</html>