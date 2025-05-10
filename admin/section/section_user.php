<div class="col">
    <h3>Data User</h3>
    <table class="table mt-4">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama lengkap</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Waktu Pembuatan</th>
        </tr>

        <?php
        $no = 1;
        $query_user = "SELECT * FROM user";
        $result_user = mysqli_query($conn, $query_user);

        if (mysqli_num_rows($result_user) > 0) :
            while ($row_user = mysqli_fetch_assoc($result_user)) :
        ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row_user['username']; ?></td>
                    <td><?php echo $row_user['nama_lengkap']; ?></td>
                    <td><?php echo $row_user['no_telepon']; ?></td>
                    <td><?php echo $row_user['alamat']; ?></td>
                    <td><?php echo $row_user['created_at']; ?></td>
                </tr>
        <?php
            endwhile;
        else :
            echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
        endif;
        ?>
    </table>
</div>