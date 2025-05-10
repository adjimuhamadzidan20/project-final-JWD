<div class="col">
    <h3>Data Pesanan</h3>
    <table class="table mt-4">
        <tr>
            <th>ID Pesanan</th>
            <th>Pelanggan</th>
            <th>Total Item</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th class="text-center">Aksi</th>
        </tr>
        <?php
        $query_pesanan = "SELECT pesanan.*, user.username 
                    FROM pesanan JOIN user ON pesanan.id_user = user.id_user
                    ORDER BY pesanan.created_at DESC";
        $result_pesanan = mysqli_query($conn, $query_pesanan);

        if (mysqli_num_rows($result_pesanan) > 0) :
            while ($row = mysqli_fetch_assoc($result_pesanan)) :
        ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= number_format($row['total'], 0, ',', '.') ?> Barang</td>
                    <td>
                        <form action="update_status.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                            <select name="status" onchange="this.form.submit()" class="form-select">
                                <option value="pending" <?= ($row['status_pesanan'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="diproses" <?= ($row['status_pesanan'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                <option value="dikirim" <?= ($row['status_pesanan'] == 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                                <option value="selesai" <?= ($row['status_pesanan'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-sm" href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Tidak ada pesanan.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>