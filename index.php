<?php
include "fungsi/pesan_kilat.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Banner -->
    <div class="banner bg" style="color: #05090c;">
        <div class="container-fluid">
            <!-- Logo di kiri -->
            <a class="navbar-brand" href="#">
                <img src="img/JTI.png" alt="Logo">
            </a>

            <!-- Tulisan di tengah -->
            <div class="navbar-text">
                Prestasi Mahasiswa
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-card mt-10 pt-10">
        <h5 class="welcome">Silahkan Login</h5><br>
        <form action="cek_login.php" method="post">

            <?php
            if (isset($_SESSION['_flashdata'])) {
                foreach ($_SESSION['_flashdata'] as $key => $val) {
                    echo get_flashdata($key);
                }
            }
            ?>

            <div class="mb-3">
                <label for="floatingPassword">Username</label>
                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username"
                    required>
            </div>
            <div class="mb-3">
                <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password"
                    required>
            </div>
            <a href="#" class="forgot-password">Lupa Password?</a>
            <div class="mt-3">
                <button type="submit" class="btn btn-login w-50">Login</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>