<?php
include "config_process/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data keranjang
$sqlKeranjang = "SELECT produk.nama_produk, produk.harga, keranjang.jumlah 
FROM keranjang JOIN produk ON keranjang.id_produk = produk.id_produk 
WHERE keranjang.id_user = {$_SESSION['user_id']}";
$query = mysqli_query($conn, $sqlKeranjang);

$total = 0;
$item_count = mysqli_num_rows($query);

?>

<h1 class="title">Keranjang Belanja</h1>
<div class="keranjang-pesanan">
    <table cellspacing="0" class="tabel-keranjang">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        <?php
        $no = 0;
        while ($row = mysqli_fetch_assoc($query)):
            $no++;
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $no; ?></td>
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?php echo $row['jumlah']; ?></td>
            </tr>
            <?php $total += $row['harga'] * $row['jumlah']; ?>
        <?php endwhile; ?>
    </table>

    <h4>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></h4>

    <div class="opsi-checkout">
        <a href="checkout.php" onclick="return validateCheckout()" class="btn-checkout">Checkout</a>
    </div>
</div>

<script>
    function validateCheckout() {
        <?php if ($item_count == 0): ?>
            alert("Keranjang kosong! Tambahkan produk terlebih dahulu.");
            window.location.href = "index.php";
            return false;
        <?php else: ?>
            return true;
        <?php endif; ?>
    }
</script>