<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>

    <link rel="stylesheet" href="assets/bootstrap-5.3.6/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row m-4">
            <div class="col-5 border p-4 rounded">
                <h2 class="mb-4">Register Admin</h2>
                <form action="config_process/proses_register.php" method="POST">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Username</label>
                        <input type="username" class="form-control" id="exampleFormControlInput1" placeholder="Username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm mb-2">Register</button>
                    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/bootstrap-5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>