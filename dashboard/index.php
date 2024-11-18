<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Jika session tidak ada, arahkan ke halaman login
    header("Location: ../belum_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PresMa Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/page.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    
</head>

<body id="body" class="light-mode">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary custom-navbar fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Pencatatan Prestasi Mahasiswa</a>
            <img src="../img/example-logo.png" alt="Logo" width="30" height="30"
                class="d-inline-block align-text-top logo-navbar">
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a class="sidebar-class sidebar-default" href="#"><i class="bi bi-house-fill"></i> Dashboard</a>
        <a class="sidebar-class" href="#"><i class="bi bi-person-circle"></i> Profile</a>
        <a class="sidebar-class" href="#">Settings</a>
        <a class="sidebar-class" href=""><button class="btn btn-outline-light" id="darkModeToggle" onclick="toggleDarkMode()">Dark
                Mode</button></a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Log Out</a> <!-- Trigger logout modal -->
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="kotak-judul">
            <p>SELAMAT DATANG DI SISTEM PENCATATAN PRESTASI MAHASISWA</p>
        </div><br>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>No Tlp</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ines</td>
                    <td>Perempuan</td>
                    <td>Jalan Inaja</td>
                    <td>12345</td>
                    <td><button class="btn btn-success btn-sm edit_data"><i class="fa  fa-edit"></i>Edit</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Ines</td>
                    <td>Perempuan</td>
                    <td>Jalan Inaja</td>
                    <td>12345</td>
                    <td><button class="btn btn-success btn-sm edit_data"><i class="fa  fa-edit"></i>Edit</button></td>
                </tr>
            </tbody>
        </table>
        
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- Custom JS -->
    <script src="../js/script.js"> </script>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin keluar dari aplikasi?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="../fungsi/logout.php" type="button" class="btn btn-danger">Keluar</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
