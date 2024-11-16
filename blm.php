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

    <div class="background-blur"></div> <!-- Blurred background image -->
    <div class="overlay"></div> <!-- Semi-transparent overlay -->
    <!-- Your main content goes here -->

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
        <h2 class="welcome">Anda Belum Login Dul!!</h2>
        <br>
        <hr>
        <br>
        <div class="mt-3">
            <a href="login.php" class="btn btn-login w-50">Login Dulu</a>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 PT. DBS Network</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>