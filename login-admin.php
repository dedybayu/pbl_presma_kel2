<?php
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Banner -->
    <div class="banner bg" style="color: #05090c;">
        <div class="container-fluid">
            <!-- Logo di kiri -->
            <a class="navbar-brand" href="#">
                <img src="img/polinema.png" alt="Logo">
            </a>

            <!-- Tulisan di tengah -->
            <div class="navbar-text fs-5">
                Pencatatan Prestasi Mahasiswa
            </div>

            <a class="navbar-brand" href="#">
                <img src="img/JTI.png" alt="Logo">
            </a>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-card mt-10 pt-10">
        <h5 class="welcome">Silahkan Login</h5><br>

        <form action="cek_login.php" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" id="floatingInput"
                    placeholder="Masukan Username" required>
            </div>
            <br>
            <div class="mb-3">
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="floatingPassword"
                        placeholder="Masukan Password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i> <!-- Ikon mata dari Bootstrap Icons -->
                    </button>
                </div>
            </div>

            <!-- Menampilkan pesan error jika ada -->
            <?php
            if ($error_message = get_flashdata('error')) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $error_message . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            ?>

            <div class="forgot-password">
                <a href="#" class="forgot">Lupa Password?</a>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-login w-50">Login</button>
            </div>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2024 PT. DBS Network</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordField = document.getElementById("floatingPassword");
            var passwordIcon = this.querySelector("i");

            // Toggle antara password dan teks
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordIcon.classList.remove("bi-eye");
                passwordIcon.classList.add("bi-eye-slash"); // Mengubah ikon ke "mata tertutup"
            } else {
                passwordField.type = "password";
                passwordIcon.classList.remove("bi-eye-slash");
                passwordIcon.classList.add("bi-eye"); // Mengubah ikon ke "mata terbuka"
            }
        });

    </script>
</body>

</html>