<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beyourself Product</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <div class="nav-elemen">
            <a href="index.php" class="logo-title">Beyourself Product</a>
            <ul>
                <li><a href="index.php?page=produk">Product</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php?page=keranjang" class="opsi">Keranjang</a></li>
                    <li><a href="logout_user.php" class="opsi">Logout</a></li>
                <?php else: ?>
                    <li><a href="index.php?page=about">About Us</a></li>
                    <li><a href="index.php?page=contact">Contact</a></li>
                    <li><a href="login_user.php" class="opsi">Keranjang</a></li>
                    <li><a href="login_user.php" class="opsi">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main>
        <?php
        require 'config_page/config_page.php';
        ?>
    </main>

    <script>
        function addToCart(productId) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert("Silakan login terlebih dahulu!");
                window.location.href = "login_user.php";
            <?php else: ?>
                fetch("add_cart.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "id_produk=" + productId
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === "success") {
                            window.location.reload();
                        }
                    });
            <?php endif; ?>
        }
    </script>

</body>

</html>