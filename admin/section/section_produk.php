<div class="col">
    <div class="d-flex justify-content-between">
        <h3>Data Produk</h3>
        <div>
            <a href="tambah_produk.php" class="btn btn-primary btn-sm">Tambah Produk</a>
        </div>
    </div>

    <table class="table mt-4">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th class="text-center">Aksi</th>
        </tr>

        <?php
        $no = 1;
        $query = "SELECT * FROM produk";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_assoc($result)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_produk']; ?></td>
                    <td><?php echo $row['kategori_produk']; ?></td>
                    <td><img src="uploads/<?php echo $row['gambar']; ?>" width="50"></td>
                    <td><?php echo $row['harga']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-sm" href="edit_produk.php?id=<?php echo $row['id_produk']; ?>">Edit</a>
                        <a class="btn btn-primary btn-sm" href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" onclick="return confirm('Yakin ingin hapus produk ini?');">Delete</a>
                    </td>
                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>
</div>