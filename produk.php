<?php
require 'config_process/config.php';

// untuk nampilin produk
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

// untuk search produk
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    // mencari berdasarkan nama_produk atau kategori_produk
    $query .= " WHERE nama_produk LIKE '%$keyword%' OR kategori_produk LIKE '%$keyword%'";
}
$result = mysqli_query($conn, $query);

// Ambil riwayat pesanan jika user sudah login
$riwayat_pesanan = [];
if (isset($_SESSION['user_id'])) {
    $sqlRiwayat = "SELECT * FROM pesanan WHERE id_user = {$_SESSION['user_id']}
    ORDER BY created_at DESC";

    $query_pesanan = mysqli_query($conn, $sqlRiwayat);
    while ($row = mysqli_fetch_assoc($query_pesanan)) {
        $riwayat_pesanan[] = $row;
    }
}
?>
<?php
if (isset($_SESSION['user_id'])) {
?>
    <h1 class="title">SELAMAT DATANG <?= $_SESSION['nama']; ?>!</h1>
<?php
} else {
?>
    <h1 class="title">SELAMAT DATANG</h1>
<?php
}
?>

<h2 class="sub-title">Daftar Produk</h2>
<form method="GET" action="">
    <input type="text" name="keyword" placeholder="Cari produk atau kategori..." value="<?php echo htmlspecialchars($keyword); ?>" class="cari-input">
    <button type="submit" class="btn-cari">Cari</button>
</form>

<div class="container">
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card-produk">
                <img src="admin/uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_produk']; ?>">
                <div class="info-produk">
                    <h3><?php echo $row['nama_produk']; ?></h3>
                    <p>Kategori: <?php echo $row['kategori_produk']; ?></p>
                    <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p><?php echo $row['deskripsi']; ?></p>
                    <p>Stok: <?php echo $row['stok']; ?></p>
                </div>
                <div class="wrap-btn">
                    <button class="btn-cart" onclick="addToCart(<?php echo $row['id_produk']; ?>)">Add to cart</button>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Tidak ada produk tersedia.</p>
    <?php } ?>
</div>

<!-- Riwayat Pemesanan -->
<?php if (isset($_SESSION['user_id']) && !empty($riwayat_pesanan)): ?>
    <div class="riwayat-pesanan">
        <h2 class="sub-title">Riwayat Pemesanan Anda</h2>
        <table cellspacing="0" class="tabel-riwayat">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Jumlah Item</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat_pesanan as $pesanan): ?>
                    <tr>
                        <td><?php echo $pesanan['id_pesanan']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                        <td><?php echo number_format($pesanan['total'], 0, ',', '.'); ?> Barang</td>
                        <td class="status-<?php echo str_replace('_', '-', $pesanan['status_pesanan']); ?>">
                            <?php
                            $status = [
                                'pending' => 'pending',
                                'diproses' => 'Diproses',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai'
                            ];
                            echo $status[$pesanan['status_pesanan']] ?? $pesanan['status_pesanan'];
                            ?>
                        </td>
                        <td class="aksi">
                            <a href="detail_pesanan_user.php?id=<?php echo $pesanan['id_pesanan']; ?>" class="btn-detail">Detail Pemesanan</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>